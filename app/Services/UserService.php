<?php
namespace App\Services;
use App\Models\Faculty;
use App\Models\User;
use App\Models\Role;
use App\Models\Logo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Ramsey\Uuid\Uuid;
use App\Soaps\LoginSoap;
use App\Soaps\UserInfoSoap;

/**
 * Created by PhpStorm.
 * UserRequest: chaow
 * Date: 4/7/2015
 * Time: 3:03 PM
 */

class UserService extends Service{

    var $withArr = ['roles','logo','faculty'];

    public function getAll(){
        return User::with($this->withArr)->get();
    }

    public function get($id){
        $user = User::with($this->withArr)->find($id);
        return $user;
    }

    private function linkToRole(User $user, array $input){

        if (isset($input['roles'])){
            $roles = $input['roles'];
            $user->syncRoles($roles);
        }else {
            $user->syncRoles([]);
        }

        return $user;
    }

    private function setPassword(User $user, array $input){
        if(isset($input['password'])){
            $user->password = \Hash::make($input['password']);
        }

        return $user;
    }

    public function store(array $input){

        $user = new User();
        $user->fill($input);
        $user = $this->setPassword($user,$input);
        $user->save();
        $this->linkToRole($user,$input);
        $this->linkToFaculty($user,$input);
        return $user;
    }



    public function save(array $input){

        if (array_has($input,'id')){
            $id = $input['id'];
            /* @var User $user */
            $user = User::find($id);
            $user->fill($input);
            $user = $this->setPassword($user,$input);
            $user->save();
            $this->linkToRole($user,$input);
            $this->linkToFaculty($user,$input);
            return $user;
        }else {
            return $this->store($input);
        }
    }

    public function create()
    {
        return new User();
    }

    public function delete($id){
        return [User::find($id)->delete()];
    }

    public function saveLogo($userId,Request $input){
        /* @var User $user */
        $user = $this->get($userId);
        $uuid = Uuid::uuid4();
        $storage_path= "app/users/$userId/logo/";
        $destination_path = storage_path($storage_path);
        $input->file('file')->move($destination_path,$uuid);

        $logo = $this->getLogoFromModel($user);
        $logo->url = "/img/users/$userId/logo/$uuid";
        $user->logo()->save($logo);
        return $logo;
    }

    public function search(array $input){
        $keyword = $input['keyword'];
        $users = User::with(['faculty','logo'])
            ->where(function($q) use ($keyword){
                return $q->where('firstname','=~',"(?i).*$keyword.*")->where('lastname','=~',"(?i).*$keyword.*","or");
            })
            ->take(10)
            ->get();
        return $users;
    }

    private function linkToFaculty(User $user, array $input)
    {
        if (isset($input['faculty'])) {
            $id = $input['faculty']['id'];
            if($oldFac = $user->faculty()->first()){
                /* @var Faculty $oldFac */
                $oldFac->users()->detach($user->id);
            }
            $faculty = Faculty::find($id);
            $faculty->users()->attach($user->id);
        }else {
            if($oldFac = $user->faculty()->first()){
                /* @var Faculty $oldFac */
                $oldFac->users()->detach($user->id);
            }
        }

        return $user;
    }

    public function getUserInfoFromSoap($username,$password){
        $data = [
            'Login' => [
                'username' => base64_encode($username),
                'password' => base64_encode($password),
                'ProductName' => 'decaffair_student',
            ]
        ];

        $loginSoap = new LoginSoap();
        $result = $loginSoap->call('Login', $data);
        $sid = $result->LoginResult;

        $data2 = [
            'GetStaffInfo' => [
                'sessionID' => $sid
            ]
        ];


        $userInfo = new UserInfoSoap();
        $infoResult = $userInfo->call('GetStaffInfo', $data2)->GetStaffInfoResult;

        return $infoResult;
    }

    public function createUserFromSoap($username,$password){

        $infoResult = $this->getUserInfoFromSoap($username,$password);

        $user = new User();
        $user->username = $username;
        $user->title = $infoResult->Title;
        $user->firstname = $infoResult->FirstName_TH;
        $user->lastname = $infoResult->LastName_TH;
        $user->email = $username."@up.ac.th";
        $user->save();

        $faculty = Faculty::where('name_th','=',$infoResult->Faculty)->first();
        if($faculty){
            $user->faculty()->save($faculty);
        }

        $role = Role::where('key','=','researcher')->first();
        if($role){
            $user->roles()->sync([$role->id]);
        }
        $user->roles;
        $user->faculty;
        return $user;
    }


}

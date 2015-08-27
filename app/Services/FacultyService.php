<?php
namespace App\Services;
use App\Models\Faculty;
use App\Models\Logo;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Input;
use Ramsey\Uuid\Uuid;

use App\Services\UserService;

/**
 * Created by PhpStorm.
 * UserRequest: chaow
 * Date: 4/7/2015
 * Time: 3:03 PM
 */

class FacultyService extends Service{


    public function getAll(){
        return Faculty::with('logo')->get();
    }

    public function get($id){
        $faculty = Faculty::with('logo')->find($id);
        return $faculty;
    }

    public function store(array $input){
        $faculty = new Faculty();
        $faculty->fill($input);
        $faculty->save();
        return $faculty;
    }
    public function save(array $input){
        if (array_has($input,'id')){
            $id = $input['id'];
            /* @var Faculty $faculty */
            $faculty = Faculty::find($id);
            $faculty->fill($input);
            $faculty->save();
            return $faculty;
        }else {
            return $this->store($input);
        }
    }

    public function create()
    {
        return new Faculty();
    }

    public function delete($id){
        return [Faculty::find($id)->delete()];
    }

    public function saveLogo($facultyId,Request $input){
        /* @var Faculty $faculty */
        $faculty = $this->get($facultyId);

        $uuid = Uuid::uuid4(); // ชื่อไฟล์
        $storage_path= "app/faculties/$facultyId/logo/"; // พาธ
        $destination_path = storage_path($storage_path); // เอาไว้ใน storage ถ้าเอาไว้ public ใช้ public_path($path)
        $input->file('file')->move($destination_path,$uuid); // save ไฟล์

        $logo = $this->getLogoFromModel($faculty);

        $logo->url = "/img/faculties/$facultyId/logo/$uuid";
        $faculty->logo()->save($logo);
        return $logo;
    }

    public function addUser($facultyId,array $input){
        /* @var Faculty $faculty */
        $faculty = $this->get($facultyId);
        $user = User::find($input['id']);

        if($user){
            if($user->faculty){
                return response("This user is in another faculty",500);
            }
            $faculty->users()->attach($user->id);
            return $user;
        }else {
            return response("This user isn't in Database or removed.",500);
        }

    }

    public function deleteUser($facultyId,$userId){
        /* @var Faculty $faculty */
        $faculty = $this->get($facultyId);
        $user = User::find($userId);

        if($user){
            $faculty->users()->detach([$user->id]);
            return $user;
        }else {
            return null;
        }
    }

}
<?php namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Models\User;
use App\Services\UserService;
use \Auth;
use Illuminate\Http\Response;
use Illuminate\Support\Str;
use \Input;

class AuthApiController extends Controller
{

    public function __construct(UserService $service){
        $this->userService = $service;
    }

    public function authenticate(LoginRequest $loginRequest)
    {
        Auth::logout();

        $email = Input::get('email');
        $password = Input::get('password');
        if (Str::contains($email,'@')) {

            if (Auth::attempt(['email' => $email, 'password' => $password])) {
                $user = Auth::user();
                $user->roles;
                return $user;
            } else {
                return \Response::json([
                    "error" => "E-mail or Password is invalid"
                ], 500);
            }
        } else {
            $username = $email;
            $password = $password;

            $server = "dcup-01.up.local";
            //dc1-nu
            $userlocal = $username . "@up.local";

            // connect to active directory
            $ad = ldap_connect($server);
            if (!$ad) {
                return \Response::json([
                    "error" => "ไม่สามารถติดต่อ server มหาลัยเพื่อตรวจสอบรหัสผ่านได้"
                ], 500);
            } else {

                $b = @ldap_bind($ad, $userlocal, $password);
                if (!$b) {
                    return \Response::json([
                        "error" => "ไม่สามารถเข้าสู่ระบบได้ กรุณาตรวจสอบอีกครั้ง"
                    ], 500);

                } else {
                    //ldap ok
                    $useremail = $username."@up.ac.th";
                    $user = User::with('roles')->where('email','=',$useremail)->first();
                    if($user){
                        Auth::login($user);
                    }else {
                        $user = $this->userService->createUserFromSoap($username,$password);
                        Auth::login($user);
                    }
                    return $user;
                }
            }
        }
    }

    public function unAuthenticate()
    {
        Auth::logout();
        return ["true"];
    }

    public
    function user()
    {
        $user = Auth::user();
        $user->logo;
        return Auth::user();
    }


}

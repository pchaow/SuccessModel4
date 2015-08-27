<?php namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Symfony\Component\Security\Core\User\UserInterface;
use Vinelab\NeoEloquent\Eloquent\SoftDeletes;

class User extends \NeoEloquent implements  AuthenticatableContract, CanResetPasswordContract {

	use Authenticatable, CanResetPassword;
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    /**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'User';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['title','firstname','lastname', 'email'];

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = ['password', 'remember_token'];


	public function logo(){
		return $this->hasOne('App\Models\Logo','HAS');
	}

    public function getAuthIdentifier()
    {
        return $this->id;
    }

    public function getAuthPassword()
    {
        return $this->password;
    }

    public function getRememberToken()
    {
        return $this->remember_token;
    }

    public function setRememberToken($token)
    {
        $this->remember_token = $token;
    }

    public function getRememberTokenName()
    {
        return 'remember_token';
    }

    public function getReminderEmail()
    {
        return $this->email;
    }

    public function roles() {
        return $this->belongsToMany("App\Models\Role","USER_ROLE");
    }


    public function syncRoles(array $roles){
        $ids = [];
        foreach($roles as $role){
            array_push($ids,$role['id']);
        }
        $this->roles()->sync($ids,true);
    }

    public function faculty(){
        return $this->hasOne("App\Models\Faculty","WORK_IN");
    }

    public function createProject(){
        return $this->hasMany("App\Models\Project","CREATE");
    }


    public function isAdmin(){
        $roles = $this->roles;
        foreach($roles as $role){
            if($role->key == 'admin'){
                return true;
            }
        }
        return false;
    }
}

<?php
namespace App\Models;

/**
 * Created by PhpStorm.
 * UserRequest: chaow
 * Date: 4/6/2015
 * Time: 12:59 PM
 */

use Vinelab\NeoEloquent\Eloquent\SoftDeletes;

class Area extends \NeoEloquent
{

    use SoftDeletes;

    protected $label = ['Area'];

    protected $fillable = ['name'];

//    public function cover(){
//        return $this->hasOne('Photo','COVER');
//    }
//
//    public function photos(){
//        return $this->hasMany('Photo','PHOTO');
//    }
//

//
    public function users(){
        return $this->belongsToMany("App\Models\User","WORK_IN");
    }

    public function projects(){
        return $this->hasMany("App\Models\Project","HAS");
    }

}
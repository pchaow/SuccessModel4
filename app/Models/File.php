<?php
namespace App\Models;

/**
 * Created by PhpStorm.
 * UserRequest: chaow
 * Date: 4/6/2015
 * Time: 12:59 PM
 */

use Vinelab\NeoEloquent\Eloquent\SoftDeletes;

class Video extends \NeoEloquent
{
    //use SoftDeletes;

    protected $label = ['Video'];

    protected $fillable = ['url'];

    public function project(){
        return $this->morphTo('App\Models\Project','VIDEO');
    }

}
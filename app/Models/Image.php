<?php
namespace App\Models;

/**
 * Created by PhpStorm.
 * UserRequest: chaow
 * Date: 4/6/2015
 * Time: 12:59 PM
 */

use Vinelab\NeoEloquent\Eloquent\SoftDeletes;

class Image extends \NeoEloquent
{

    protected $label = ['Image'];

    protected $fillable = ['url'];


    public function faculty(){
        return $this->morphTo('App\Models\Faculty','PHOTO');
    }

    public function project(){
        return $this->morphTo('App\Models\Project','PHOTO');
    }

}
<?php
namespace App\Models;

/**
 * Created by PhpStorm.
 * UserRequest: chaow
 * Date: 4/6/2015
 * Time: 12:59 PM
 */

use Vinelab\NeoEloquent\Eloquent\SoftDeletes;

class File extends \NeoEloquent
{
    //use SoftDeletes;

    protected $label = ['File'];

    protected $fillable = ['url'];

    public function project(){
        return $this->morphTo('App\Models\Project','FILE');
    }

}
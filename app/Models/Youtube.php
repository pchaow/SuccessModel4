<?php
namespace App\Models;

/**
 * Created by PhpStorm.
 * UserRequest: chaow
 * Date: 4/6/2015
 * Time: 12:59 PM
 */

use Vinelab\NeoEloquent\Eloquent\SoftDeletes;


class Youtube extends Video
{
    //use SoftDeletes;

    protected $label = ['Youtube','Video'];

    protected $fillable = ['url','title','description','thumbnail_url','vid'];

    public function project(){
        return $this->morphTo('App\Models\Project','VIDEO');
    }

}
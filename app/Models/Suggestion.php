<?php
namespace App\Models;

/**
 * Created by PhpStorm.
 * UserRequest: chaow
 * Date: 4/6/2015
 * Time: 12:59 PM
 */

use Vinelab\NeoEloquent\Eloquent\SoftDeletes;

class Suggestion extends \NeoEloquent
{

    use SoftDeletes;

    protected $label = ['Suggestion'];

    protected $fillable = ['suggestion'];


    public function createdBy(){
        return $this->hasOne("App\Models\User","CREATE_BY");
    }


}
<?php namespace App\Models;

use Vinelab\NeoEloquent\Eloquent\SoftDeletes;

class ApiKey extends \NeoEloquent
{
    use SoftDeletes;

    protected $table = 'apikey';


    protected $connection = 'neo4j';


    protected $fillable = ['key', 'version'];


}
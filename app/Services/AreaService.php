<?php
namespace App\Services;
use App\Models\Area;
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

class AreaService extends Service{


    var $withArr = ['createdBy'];

    public function getAll(){
       return Area::with($this->withArr)->get();
    }

    public function get($id){
        $area = Area::with($this->withArr)->find($id);
        return $area;
    }

    public function store(array $input){
        $area = new Area();
        $area->fill($input);
        $area->save();
        return $area;
    }
    public function save(array $input){
        if (array_has($input,'id')){
            $id = $input['id'];
            /* @var Area $area */
            $area = Area::find($id);
            $area->fill($input);
            $area->save();
            return $area;
        }
    }

    public function delete($id){
        return Area::find($id)->delete();
    }


}
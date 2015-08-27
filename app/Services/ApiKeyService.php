<?php namespace App\Services;
use App\Models\ApiKey;
use Rhumsaa\Uuid\Uuid;

/**
 * Created by PhpStorm.
 * User: chaow
 * Date: 2/12/2015 AD
 * Time: 12:21 PM
 */


class ApiKeyService extends Service
{

    public function all()
    {
        return ApiKey::all();
    }


    public function getById($id)
    {
        return ApiKey::find($id);
    }

    public function create()
    {
        return new ApiKey();
    }

    public function store(array $input)
    {
        return $this->save($input);
    }

    public function generateNewKey(){
        $apikey = new ApiKey();
        $apikey->key = Uuid::uuid4()->toString();
        $apikey->save();
        return $apikey;
    }

    public function save(array $input)
    {


        if (isset($input['id'])) {
            $id = $input['id'];
            /* @var ApiKey $apikey */
            $apikey = ApiKey::find($id);
            $apikey->update($input);
            $apikey->save();

            return $apikey;
        } else {
            $apikey = ApiKey::firstOrNew($input);
            $apikey->save();
            return $apikey;
        }

    }

    public function delete($id)
    {
        /* @var ApiKey $apikey */
        $apikey = ApiKey::find($id);
        $apikey->delete();
        return $apikey;
    }

}
<?php

namespace App\Packages\Logger\Entities;

use App\Packages\Logger\Models\EntityMethod;

class Entity
{
   public function __construct() {}

    public static function get($id)
    {
        $method = EntityMethod::find($id) 
            or new \Exception('Not found', 404);

        return $method;
    }


    public function create(array $data)
    {
        // if will any errors occured
        $res = (new EntityMethod($data))->save();

        if ($res !== true) {
            throw new \Exception('Service Unavailable', 503);
        }

        return $res;
    }

    public static function delete($id)
    {
        $method = self::get($id);
        $method->delete() or new \Exception('', 503);

        return $method;
    }

    public static function execQuery($id)
    {
        $method = EntityMethod::find($id) 
            or new \Exception('Not found', 404);

        $result = $method->execute();

        $method->createQueryLog([
            'time_exec' => $result['time_exec'],
            'data' => json_encode($result)
        ]) or new \Exception('', 503);

        $method->result = $result;
        return $method;
    }
}
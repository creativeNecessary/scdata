<?php
/**
 * Created by PhpStorm.
 * User: zhanglimin
 * Date: 2018/3/13
 * Time: 下午5:58
 */

namespace App\Http\Helpers;


use function PHPSTORM_META\map;

class ResponseHelper
{

    public static function json($data, $msg, $status, $code)
    {

        if(is_array($data)){
            $data = map($data);
        }
        $response = json_encode(array('message' => $msg, 'status' => $status, 'code' => $code, 'data' => $data), true);

        return $response;
    }

}
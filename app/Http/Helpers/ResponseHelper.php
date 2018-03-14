<?php
/**
 * Created by PhpStorm.
 * User: zhanglimin
 * Date: 2018/3/13
 * Time: 下午5:58
 */

namespace App\Http\Helpers;


use stdClass;

class ResponseHelper
{

    public static function json($data, $msg, $status, $code)
    {

        $data = self::handleData($data);
        $response = json_encode(array('message' => $msg, 'status' => $status, 'code' => $code, 'data' => $data));

        return $response;
    }


    private static function handleData($data){
        if(is_array($data)){
           return  "{" . json_encode($data) . "}";
        }
        return $data;
    }

}
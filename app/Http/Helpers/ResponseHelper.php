<?php
/**
 * Created by PhpStorm.
 * User: zhanglimin
 * Date: 2018/3/13
 * Time: 下午5:58
 */

namespace App\Http\Helpers;


class ResponseHelper
{

    public static function json($data, $msg, $status, $code)
    {

        $response = json_encode(array('message' => $msg, '$status' => $status, '$code' => $code, 'data' => $data), true);

        return $response;
    }

}
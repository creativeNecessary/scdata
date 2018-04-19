<?php
/**
 * Created by PhpStorm.
 * User: zhanglimin
 * Date: 2018/4/19
 * Time: 下午5:18
 */

namespace App\Http\Helpers;

use Illuminate\Http\Request;

trait DigitalSignatureHelper
{

    public function checkSignature(Request $request ,$operate)
    {
        $input=$request->only(['timestamp','digital_signature']);
        $timestamp = $input['timestamp'];
        $digital_signature = $input['digital_signature'];

        $operate_length = strlen($operate);
        $timestamp_length = strlen($timestamp);


    }

}
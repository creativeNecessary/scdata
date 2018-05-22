<?php
/**
 * Created by PhpStorm.
 * User: zhanglimin
 * Date: 2018/5/21
 * Time: 下午3:10
 */

namespace App\Http\Controllers\Api;


use App\Http\Helpers\ResponseApi;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use stdClass;

class CheckUpdateController extends Controller

{
    private static $NEED_UPDATE = 100;
    private static $NEED_FORCE_UPDATE = 101;
    private static $NOW_LAST_VERSION = 102;

    private   $nowVersionCode = 2;
    private  $needForceUpdateVersionCode = 0;


    public function checkUpdate(Request $request){

        $data = $request->only(['versionCode']);
        $versionCode = $data['versionCode'];
        $obj = new stdClass();
        if($versionCode < $this->nowVersionCode){
            if($versionCode <= $this->needForceUpdateVersionCode){
                $obj->code = CheckUpdateController::$NEED_FORCE_UPDATE;
            }else{
                $obj->code = CheckUpdateController::$NEED_UPDATE;
                $obj->version_focus ='TestTest';
            }
        }else{
            $obj->code = CheckUpdateController::$NOW_LAST_VERSION;
        }

        return $this->onSuccess($obj);

    }

}
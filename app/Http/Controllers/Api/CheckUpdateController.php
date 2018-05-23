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
use App\Models\ship\AppVersion;
use Illuminate\Http\Request;
use stdClass;

class CheckUpdateController extends Controller

{
    private static $NEED_UPDATE = 100;
    private static $NEED_FORCE_UPDATE = 101;
    private static $NOW_LAST_VERSION = 102;

    private $needForceUpdateVersionCode = 0;


    public function checkUpdate(Request $request)
    {

        $data = $request->only(['versionCode']);
        $versionCode = $data['versionCode'];
        $obj = new stdClass();
        if ($versionCode < $this->nowVersionCode) {
            if ($versionCode <= $this->needForceUpdateVersionCode) {
                $obj->code = CheckUpdateController::$NEED_FORCE_UPDATE;
                $obj->version_focus = 'TestTest';
                $obj->version_name = $this->version_name;
            } else {
                $obj->code = CheckUpdateController::$NEED_UPDATE;
                $obj->version_focus = 'TestTest';
                $obj->version_name = $this->version_name;

            }
        } else {
            $obj->code = CheckUpdateController::$NOW_LAST_VERSION;
        }

        return $this->onSuccess($obj);

    }

    public function getUpdateApkFile()
    {
        $app_last_version = AppVersion::orderBy('id','desc')->take(1)->get();
        $filename = app_last_version['apk_file_name'];

//        $path = resource_path($app_last_version['apk_file_name']);
//        $headers = [
//            'Content-Type' => 'text/html;charset=UTF-8'
//        ];

//        return response()->download($path, $filename, $headers);
        return $this->onSuccess($filename);
    }

}
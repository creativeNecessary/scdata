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
        $app_last_version_results = AppVersion::orderBy('id','desc')->take(1)->get();
        $app_last_version = $app_last_version_results[0];
        $nowVersionCode = $app_last_version->get_version_code();
        $version_name = $app_last_version->get_version_name();
        $version_focus = $app_last_version->get_version_focus();
        $state = $app_last_version->get_state();
        $data = $request->only(['versionCode']);
        $versionCode = $data['versionCode'];
        $obj = new stdClass();
        if ($versionCode < $nowVersionCode && $state == 'release') {
            if ($versionCode <= $this->needForceUpdateVersionCode) {
                $obj->code = CheckUpdateController::$NEED_FORCE_UPDATE;
                $obj->version_focus = $version_focus;
                $obj->version_name = $version_name;
            } else {
                $obj->code = CheckUpdateController::$NEED_UPDATE;
                $obj->version_focus = $version_focus;
                $obj->version_name = $version_name;

            }
        } else {
            $obj->code = CheckUpdateController::$NOW_LAST_VERSION;
        }

        return $this->onSuccess($obj);

    }

    public function getUpdateApkFile()
    {
        $app_last_version_results = AppVersion::orderBy('id','desc')->take(1)->get();
        $app_last_version = $app_last_version_results[0];
        $filename = $app_last_version->get_apk_file_name();

        $path = resource_path('latest_apk/'.$filename);
        $headers = [
            'Content-Type' => 'text/html;charset=UTF-8',
             'ScFileName' => $filename
        ];

        return response()->download($path, $filename, $headers);
    }

}
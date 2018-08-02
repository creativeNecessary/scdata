<?php
/**
 * Created by PhpStorm.
 * User: zhanglimin
 * Date: 2018/3/22
 * Time: 下午2:34
 */

namespace App\Models\ship;

use App\Models\Model;


class AppVersion extends Model
{

    protected $table = "app_version";
    public $timestamps = false;

    public function get_version_code(){
        return $this->attributes['version_code'];
    }

    public function get_version_name(){
        return $this->attributes['version_name'];
    }

    public function get_version_focus(){
        return $this->attributes['version_focus'];
    }

    public function get_apk_file_name(){
        return $this->attributes['apk_file_name'];
    }

    public function get_state(){
        return $this->attributes['state'];
    }

    public function get_apk_download_path(){
        return $this->attributes['apk_download_path'];
    }

}
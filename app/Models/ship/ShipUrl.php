<?php
/**
 * Created by PhpStorm.
 * User: zhanglimin
 * Date: 2018/3/23
 * Time: 下午2:51
 */

namespace App\Models\ship;


class ShipUrl extends Model
{
    protected $table = "ship_url";
    public $timestamps = false;

    public function ship_url()
    {
        return $this->hasOne('App\Models\ship\ShipUrl');
    }

}
<?php
/**
 * Created by PhpStorm.
 * User: zhanglimin
 * Date: 2018/3/22
 * Time: 下午2:34
 */

namespace App\Models\ship;

use App\Models\Model;


class ShipType extends Model
{

    protected $table = "ship_type";

    public function getShipId(){
        return $this->attributes['ship_id'];
    }
}
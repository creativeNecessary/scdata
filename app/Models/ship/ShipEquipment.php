<?php
/**
 * Created by PhpStorm.
 * User: zhanglimin
 * Date: 2018/3/26
 * Time: 上午11:34
 */

namespace App\Models\ship;
use App\Models\Model;

class ShipEquipment extends Model
{
    protected $table = "ship_equipment_en";
    public $timestamps = false;

    public function setEquipment($equipment)
    {
        $this->attributes['$equipment'] = $equipment;
    }
}
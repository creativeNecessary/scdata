<?php
/**
 * Created by PhpStorm.
 * User: zhanglimin
 * Date: 2018/3/22
 * Time: 下午2:34
 */

namespace App\Models\ship;

use App\Models\Model;


class ShipModel extends Model
{

    protected $table = "ship_en";
    public $timestamps = false;


    public function ship()
    {
        return $this->hasOne('App\Models\ship\ShipModel');
    }

    public function getShip($id)
    {

    }

    public function setName($name)
    {
        $this->attributes['name'] = $name;
    }
    public function setImageUrl($urls)
    {
        $this->attributes['pic_url'] = $urls;
    }

    public function setShipEquipment($field_name,$ship_equipments)
    {
        $this->attributes[$field_name] = $ship_equipments;
    }

    public function setManufacturer($manufacturer)
    {
        $this->attributes['manufacturer'] = $manufacturer[0];
    }

}
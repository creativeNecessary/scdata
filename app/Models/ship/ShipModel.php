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

    public function getShip($id){

    }

    public function setImageUrl($urls)
    {
        $urls = json_decode($urls);
        $this->attributes['pic_url'] = strtolower($urls);
    }

}
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
        $this->attributes['equipment'] = $equipment;
    }

    public function queryChType()
    {
        $name =  ConstantTranslate::select('translate_value')->where([['original_text',$this->attributes['type']]])->get('translate_value');
        if(sizeof($name)>0){
            $this->attributes['type'] = $name[0]['translate_value'];
        }
    }
}
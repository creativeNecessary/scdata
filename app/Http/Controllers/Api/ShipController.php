<?php

namespace App\Http\Controllers\Api;

use App\Models\Model;
use App\Models\ship\Equipment;
use App\Models\ship\ManufacturerModel;
use App\Models\ship\ShipEquipment;
use App\Models\ship\ShipModel;
use App\Models\ship\ShipUrl;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use stdClass;

class ShipController extends Controller
{
    //
    public function getShipList(Request $request){

        $input=$request->only(['page_num','per_page']);
        $page_num = $input['page_num'];
        $per_page = $input['per_page'];
        $start = $page_num * $per_page;
        $ships = DB::select('select id,name,url,icon,size,focus,max_crew,length from ship_en LIMIT ? , ?',[$start,$per_page]);
        $ships = json_decode(json_encode($ships));

        return $this->onSuccess($ships);
    }

    //
    public function getShipDetail(Request $request){
        $input=$request->only(['ship_id']);
        $ship_id = $input['ship_id'];
        $ship = ShipModel::find($ship_id);
        $ship_url = ShipUrl::select('url')->where([['ship_id',$ship_id],['type','image']])->get();
        $manufacturer = ManufacturerModel::where('id',$ship->manufacturer)->get();


        $ship->setImageUrl($ship_url);
        $ship->setManufacturer($manufacturer);

        $this->initShipEquipment($ship,$ship_id,'avionics','avionic');
        $this->initShipEquipment($ship,$ship_id,'modular','modular');
        $this->initShipEquipment($ship,$ship_id,'propulsion','propulsion');
        $this->initShipEquipment($ship,$ship_id,'thrusters','thruster');
        $this->initShipEquipment($ship,$ship_id,'weapons','weapon');


        return $this->onSuccess($ship);

    }

    private function initShipEquipment($ship,$ship_id,$ship_field,$tag){
        $ship_equipments =  ShipEquipment::where([['ship_id',$ship_id],['tag',$tag]])->get();
        foreach ($ship_equipments as $ship_equipment => $value){
            $equipment_id =  $value->equipment;
            $equipment = Equipment::find($equipment_id);
            if($equipment != null){
                $ship_equipments[$ship_equipment]->setEquipment($equipment);
            }else{
                $obj = new stdClass();
                $ship_equipments[$ship_equipment]->setEquipment($obj);
            }
        }
        $ship->setShipEquipment($ship_field,$ship_equipments);
    }

}

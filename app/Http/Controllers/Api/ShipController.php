<?php

namespace App\Http\Controllers\Api;

use App\Http\Helpers\ResponseApi;
use App\Models\Model;
use App\Models\ship\ConstantTranslate;
use App\Models\ship\Equipment;
use App\Models\ship\ManufacturerModel;
use App\Models\ship\ShipEquipment;
use App\Models\ship\ShipModel;
use App\Models\ship\ShipUrl;
use Illuminate\Http\File;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use function PHPSTORM_META\type;
use stdClass;

class ShipController extends Controller
{
    //
    public function getShipList(Request $request)
    {

        $input = $request->only(['page_num', 'per_page']);
        $page_num = $input['page_num'];
        $per_page = $input['per_page'];
        $start = $page_num * $per_page;
        $ships = ShipModel::take($per_page)->skip($start)->get(['id','name','url','icon','size','focus','max_crew','length']);
        foreach ($ships as &$ship){
            $ship->queryChName();
        }
//        $ships = DB::select('select id,name,url,icon,size,focus,max_crew,length from ship_en LIMIT ? , ?', [$start, $per_page]);
//        $ships = json_decode(json_encode($ships));
        return $this->onSuccess($ships);
    }

    //
    public function getShipDetail(Request $request)
    {
        $input = $request->only(['ship_id']);
        $ship_id = $input['ship_id'];
        $ship = ShipModel::find($ship_id);
        $ship_url = ShipUrl::select('url')->where([['ship_id', $ship_id], ['type', 'image']])->get();
        $manufacturer = ManufacturerModel::where('id', $ship->manufacturer)->get();

        if(count($ship_url) == 0){
            $ship_url = array('url'=>$ship->getIcon());
        }
        $ship->setImageUrl($ship_url);
        $ship->setManufacturer($manufacturer);
        $ship->queryChName();

        $this->initShipEquipment($ship, $ship_id, 'avionics', 'avionic');
        $this->initShipEquipment($ship, $ship_id, 'modular', 'modular');
        $this->initShipEquipment($ship, $ship_id, 'propulsion', 'propulsion');
        $this->initShipEquipment($ship, $ship_id, 'thrusters', 'thruster');
        $this->initShipEquipment($ship, $ship_id, 'weapons', 'weapon');
//        return $this->onSuccess($ship);
        return json_encode($ship_url);

    }

    private function initShipEquipment($ship, $ship_id, $ship_field, $tag)
    {
        $ship_equipments = ShipEquipment::where([['ship_id', $ship_id], ['tag', $tag]])->get();
        foreach ($ship_equipments as &$ship_equipment) {
            $ship_equipment->queryChType();
//            $equipment_id = $value->equipment;
//            $equipment = Equipment::find($equipment_id);
//            if ($equipment != null) {
//                $ship_equipments[$ship_equipment]->setEquipment($equipment);
//            } else {
//                $obj = new stdClass();
//                $ship_equipments[$ship_equipment]->setEquipment($obj);
//            }
        }
        $ship->setShipEquipment($ship_field, $ship_equipments);
    }


    public function getSTLFile(Request $request)
    {
        $input = $request->only(['ship_id']);
        $ship_id = $input['ship_id'];
        //获取飞船id从数据库查询


        $model_path = ShipModel::where('id', $ship_id)->value('model3d_url');
        $end_str = strrchr($model_path, '/');

        if (strlen($end_str) <= 5) {
            return $this->onFailure(ResponseApi::$SERVICE_ERROR);
        }
        $sub_file_name = substr($end_str, 1, strlen($end_str) - 5);
        $filename = $sub_file_name . '.stl';


        $path = resource_path('media/ctmfiles/' . $filename);
        if ($path == null) {
            return $this->onFailure(ResponseApi::$SERVICE_ERROR);
        }
        if (strlen($path) <= 0) {
            return $this->onFailure(ResponseApi::$SERVICE_ERROR);
        }


        $headers = [
            'Content-Type' => 'application/vnd.ms-pki.stl',
            'ScFileName' => $filename
        ];
        return response()->download($path, $filename, $headers);
    }

    public function getFuncFile($filename)
    {

        $path = resource_path('media/func/' . $filename);
        $headers = [
            'Content-Type' => 'text/html;charset=UTF-8'
        ];

        return response()->download($path, $filename, $headers);
    }

}

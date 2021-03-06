<?php

namespace App\Http\Controllers\Api;

use App\Http\Helpers\ResponseApi;
use App\Models\Model;
use App\Models\ship\ConstantTranslate;
use App\Models\ship\Equipment;
use App\Models\ship\ManufacturerModel;
use App\Models\ship\ShipEquipment;
use App\Models\ship\ShipModel;
use App\Models\ship\ShipType;
use App\Models\ship\ShipTypeConstant;
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

        $input = $request->only(['page_num', 'per_page', 'type_content']);
        $page_num = $input['page_num'];
        $per_page = $input['per_page'];
        $start = $page_num * $per_page;
        $ships = null;
        if ($request->has('type_content') && !empty($input['type_content'])) {
            $type_content = $input['type_content'];
            $ship_types = ShipType::where('type_content', $type_content)->take($per_page)->skip($start)->get();
            $ids = array();
            $index = 0;
            foreach ($ship_types as $ship_type) {
                $ids[$index] = $ship_type->getShipId();
                $index++;
            }
            $ships = ShipModel::whereIn('id', $ids)->get(['id', 'name', 'url', 'store_large', 'size', 'focus', 'max_crew', 'length']);

        } else {
            $ships = ShipModel::orderBy('id', 'desc')->take($per_page)->skip($start)->get(['id', 'name', 'url', 'store_large', 'size', 'focus', 'max_crew', 'length']);

        }
        if ($ships != null) {
            foreach ($ships as &$ship) {
                $ship->queryChName();
            }
        }
//        $ships = DB::select('select id,name,url,icon,size,focus,max_crew,length from ship_en LIMIT ? , ?', [$start, $per_page]);
//        $ships = json_decode(json_encode($ships));
        return $this->onSuccess($ships);
    }

    public function getAllShipName(Request $request)
    {
        $ships = ShipModel::get(['id', 'name']);
        if ($ships != null) {
            foreach ($ships as &$ship) {
                $ship->queryChName();
            }
        }
        return $this->onSuccess($ships);
    }

    public function searchShip(Request $request)
    {

        $input = $request->only(['ship_id']);
        $ships = null;
        if ($request->has('ship_id') && !empty($input['ship_id'])) {
            $ship_id = $input['ship_id'];
            $ships = ShipModel::where('id', $ship_id)->get(['id', 'name', 'url', 'store_large', 'size', 'focus', 'max_crew', 'length']);
        }
        if ($ships != null) {
            foreach ($ships as &$ship) {
                $ship->queryChName();
            }
        }
        return $this->onSuccess($ships);
    }

    //
    public function getShipDetail(Request $request)
    {
        $input = $request->only(['ship_id']);
        $ship_id = $input['ship_id'];
        $ship = ShipModel::find($ship_id);
        $ship_store_large = ShipUrl::select('url')->where([['ship_id', $ship_id], ['type', 'image']])->get();
        $manufacturer = ManufacturerModel::where('code', $ship->manufacturer_code)->get();

        if (count($ship_store_large) == 0) {
            $ship_store_large = array(array('url' => $ship->getStore_Large()));
        }
        $ship->setImageUrl($ship_store_large);
        $ship->setManufacturer($manufacturer);
        $ship->queryChName();

        $this->initShipEquipment($ship, $ship_id);

        return $this->onSuccess($ship);

    }

    private function initShipEquipment($ship, $ship_id)
    {
        $ship_equipments = ShipEquipment::where([['ship_id', $ship_id]])->get();
        foreach ($ship_equipments as &$ship_equipment) {
            $ship_equipment->queryChType();
        }
        $ship->setShipEquipment($ship_equipments);
    }


    public function getFilterData(){
        $types = ShipTypeConstant::all();
        return $this->onSuccess($types);
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


}

<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class ShipController extends Controller
{
    //
    public function getShipList(Request $request){

        $input=$request->only(['page_num','per_page']);
        $page_num = $input['page_num'];
        $per_page = $input['per_page'];
        $start = $page_num * $per_page;
        $ships = DB::select('select name,url,icon,size,focus,max_crew,length from ship_en LIMIT ? , ?',[$start,$per_page]);
        $ships = json_decode(json_encode($ships));

        return $this->onSuccess($ships);
    }

    //
    public function getShipDetail(Request $request){
        $input=$request->only(['ship_id']);
        $ship_id = $input['ship_id'];
        $ship = DB::select('select * from ship_en WHERE id = ?',[$ship_id]);
        $ship = json_decode(json_encode($ship));

        return $this->onSuccess($ship);
    }
}

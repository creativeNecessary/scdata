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
//        foreach ($ships as &$ship){
//            $pic_url = $ship['pic_url'];
//            $pic_urls = DB::select('select * from ship_url WHERE ship_id = ?',[$pic_url]);
//            $ship['pic_url'] = $pic_urls;
//        }
//        unset($ship);
        return $this->onSuccess($ships);
    }
}

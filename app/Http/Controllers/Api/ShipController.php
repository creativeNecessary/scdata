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
        $ships = DB::select('select * from ship_en INNER JOIN ship_url WHERE ship_en.id = ship_url.ship_id LIMIT ? , ?',[$start,$start+$per_page]);

        return $ships;
    }
}

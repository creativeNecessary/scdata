<?php
/**
 * Created by PhpStorm.
 * User: zhanglimin
 * Date: 2018/5/21
 * Time: 下午3:10
 */

namespace App\Http\Controllers\Api;


use App\Http\Helpers\ResponseApi;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ship\CommLink;
use App\Models\ship\CommLinkContent;

class CommLinkController extends Controller

{



    public function getCommLinkList(Request $request)
    {
        $input = $request->only(['type', 'page_num', 'per_page']);
        $type = $input['type'];
        $page_num = $input['page_num'];
        $per_page = $input['per_page'];
        $start = $page_num * $per_page;
        $comm_links = CommLink::take($per_page)->skip($start)->where([['type', $type]])->get(['id','title','background']);
        return $this->onSuccess($comm_links);

    }

    public function getCommLinkDetail(Request $request)
    {
        $input = $request->only(['id']);
        $comm_link_id = $input['id'];
        $comm_link_contents = CommLinkContent::where([['comm_link_id', $comm_link_id]])->get();
        return $this->onSuccess($comm_link_contents);
    }

}
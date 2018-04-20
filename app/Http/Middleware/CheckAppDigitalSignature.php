<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckAppDigitalSignature
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        if(!$this->checkSignature($request)){
            return response('Unauthorized.', 401);
        }
        return $next($request);
    }

    private function checkSignature(Request $request)
    {
        $input = $request->only(['timestamp', 'digital_signature', 'action']);
        $timestamp = $input['timestamp'];
        $action = $input['action'];
        $digital_signature = $input['digital_signature'];

        if ($timestamp == null || $action == null || $digital_signature == null) {
            return false;
        }
        $now_time = microtime(true)*1000;

        if(($now_time - $timestamp)/1000 >=120){

            return false;
        }

        $action_length = strlen($action);
        $timestamp_length = strlen($timestamp);
        $cycle_index = 0;
        if ($action_length > $timestamp_length) {
            $cycle_index = $timestamp_length * 2;
        } else {
            $cycle_index = $action_length * 2;
        }
        if ($cycle_index == 0) {
            return false;
        }
        $index_action = 0;
        $index_timestamp = 0;
        $result_char = [];
        if (intval($timestamp[$timestamp_length - 1]) % 2 == 0) {

            for ($i = 0; $i < $cycle_index; $i++) {
                if ($i % 2 == 0) {
                    $result_char[$i] = $action[$index_action];
                    $index_action++;
                } else {
                    $result_char[$i] = $timestamp[$index_timestamp];
                    $index_timestamp++;
                }
            }

        } else {
            for ($i = 0; $i < $cycle_index; $i++) {
                if ($i % 2 == 0) {
                    $result_char[$i] = $timestamp[$index_timestamp];
                    $index_timestamp++;
                } else {
                    $result_char[$i] = $action[$index_action];
                    $index_action++;
                }
            }
        }
        if (implode("", $result_char) == null) {
            return false;
        }
        $data = implode("", $result_char);
        $result_char = sha1($data);
        if (strcmp($digital_signature, $result_char) != 0) {
            return false;
        }

        return true;
    }
}

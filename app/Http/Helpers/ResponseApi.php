<?php
/**
 * Created by PhpStorm.
 * User: zhanglimin
 * Date: 2018/3/13
 * Time: 下午5:51
 */

namespace App\Http\Helpers;

use Symfony\Component\HttpFoundation\Response as FoundationResponse;
use App\Http\Helpers\ResponseHelper;

trait ResponseApi
{
    protected $statusCode = FoundationResponse::HTTP_OK;


    /**
     * @return int
     */
    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    /**
     * @param int $statusCode
     */
    public function setStatusCode(int $statusCode): void
    {
        $this->statusCode = $statusCode;
    }

    public function onSuccess($data, $message = "success", $status = "allow")
    {
        $this->setStatusCode(FoundationResponse::HTTP_OK);
        return ResponseHelper::json($data, $message, $status, $this->getStatusCode());
    }


}
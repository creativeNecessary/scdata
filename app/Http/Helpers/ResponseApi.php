<?php
/**
 * Created by PhpStorm.
 * User: zhanglimin
 * Date: 2018/3/13
 * Time: 下午5:51
 */

namespace App\Http\Helpers;

use Symfony\Component\HttpFoundation\Response as FoundationResponse;

trait ResponseApi
{
    protected $statusCode = FoundationResponse::HTTP_OK;

    public static $SERVICE_ERROR = 'Service has a unknown error';
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
    public function onFailure($data, $message = "failure", $status = "allow")
    {
        $this->setStatusCode(FoundationResponse::HTTP_OK);
        return ResponseHelper::json($data, $message, $status, $this->getStatusCode());
    }


}
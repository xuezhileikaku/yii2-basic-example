<?php


namespace common\widgets;


use yii\web\HttpException;

class RestHttpException extends HttpException
{
    public function __construct($status, $message = null, $code = 0, \Exception $previous = null)
    {
        $this->statusCode = $status;
        parent::__construct($status, $message, $code, $previous);
    }
}

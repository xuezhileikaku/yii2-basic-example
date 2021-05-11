<?php


namespace api\widgets;


use yii\base\Behavior;
use yii\web\Response;

class BeforeSendBehavior extends Behavior
{
    public $defaultCode = 500;
    public $defaultMsg = 'error';

    public function events()
    {
//        在 EVENT_BEFORE_SEND 事件触发时，调用成员函数 beforeSend
        return [Response::EVENT_BEFORE_SEND => 'beforeSend'];
    }
    // 注意 beforeSend 是行为的成员函数，而不是绑定的类的成员函数。
    // 还要注意，这个函数的签名，要满足事件 handler 的要求。
    public function beforeSend($event)
    {
        try {
            $res = $event->sender;
            if ($res->data !== null) {
                if ($res->isSuccessFul) {
                    /**
                     * $response->isSuccessful 表示是否会抛出异常
                     * 值为 true, 代表返回数据正常，没有抛出异常
                     */
                    $rData = $res->data;

                    $res->data = [
                        'code' => isset($rData['error_code']) ? $rData['error_code'] : 0,
                        'msg' => isset($rData['res_msg']) ? $rData['res_msg'] : $rData,
                    ];
                    $res->statusCode = 200;
                    return true;
                } else {
                    $exception = \Yii::$app->getErrorHandler()->exception;

                    if (is_object($exception) && !$exception instanceof \HttpException) {
                        throw $exception;
                    } else {
                        $rData = $res->data;
                        $res->data = [
                            'code' => empty($rData['status']) ? $this->defaultCode : $rData['status'],
                            'msg' => empty($rData['message']) ? $this->defaultMsg : $rData['message'],
                        ];
                        $res->data = [
                            'code' => $exception->statusCode,
                            'msg' => $exception->getMessage(),
                        ];
                        return true;
                    }
                }
            }
            $res->data = ['code' => $this->defaultCode, 'msg' => 'unset return data!'];
            return true;
        } catch (\Exception $e) {
            $res->data = [
                'code' => $e->statusCode,
                'msg' => $e->getMessage(),
            ];
            return true;
        }
    }
}

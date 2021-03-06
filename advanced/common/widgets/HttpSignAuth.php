<?php


namespace common\widgets;

use Yii;
use yii\base\Behavior;
use yii\web\Controller;

class HttpSignAuth extends Behavior
{
    public $privateKey = 'miniparagram_1502';
    public $signParam = 'sign';

    public function events()
    {
        return [Controller::EVENT_BEFORE_ACTION => 'beforeAction']; // TODO: Change the autogenerated stub
    }

    public function beforeAction($event)
    {
        $sign = Yii::$app->request->get($this->signParam, null);
        $getParams = Yii::$app->request->get();
        $postParams = Yii::$app->request->post();
        $params = array_merge($getParams, $postParams);

        if (empty($sign) || !$this->checkSign($sign, $params)) {
            $error = ErrorCode::getError('auth_error');

            throw new RestHttpException($error['status'], $error['msg'], $error['code']);
        }
        return true;
    }

    public function checkSign($sign, $params)
    {
        unset($params[$this->signParam]);
        ksort($params);

        return md5($this->privateKey . implode(',', $params)) === $sign;
    }
}

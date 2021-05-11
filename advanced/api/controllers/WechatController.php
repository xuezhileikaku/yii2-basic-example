<?php


namespace api\controllers;


use common\models\DiUser;
use yii\filters\auth\HttpBasicAuth;
use yii\helpers\ArrayHelper;
use yii\rest\ActiveController;
use yii\web\Response;
use common\widgets\ErrorCode;
use common\widgets\RestHttpException;
use common\widgets\HttpSignAuth;

class WechatController extends RestController
{

    public $modelClass = 'common\models\DiUser';


    public function actionSearch()
    {

        return ['error_code' => 20, 'res_msg' => 'ok'];
    }

    public function actionRegister()
    {
        var_dump(\Yii::$app->request);
        exit();
        if (!\Yii::$app->request->isPost) {
            $error = ErrorCode::getError('params_error');
            throw new RestHttpException($error['status'], $error['msg'], $error['code']);
        }
        $params = \Yii::$app->request->post();
        if (empty($params['name']) || empty($params['pwd']) || empty($params['email'])) {
            $error = ErrorCode::getError('params_error');
            throw new RestHttpException($error['status'], $error['msg'], $error['code']);
        }
        $user = new DiUser();
        $user->account = $params['name'];
        $user->email = $params['email'];
        $user->generatePassword($params['pwd']);
        $user->generateAuthKey();
        var_dump($user);
        exit();
    }
}

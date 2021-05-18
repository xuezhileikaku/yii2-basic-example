<?php


namespace api\controllers;

use common\widgets\ErrorCode;
use common\widgets\RestHttpException;
use common\models\User;
use Yii;

class UserController extends RestController
{
    public $modelClass = 'common\models\User';

    public function actionRegister()
    {
        if (!\Yii::$app->request->isPost) {
            $error = ErrorCode::getError('params_error');
            throw new RestHttpException($error['status'], $error['msg'], $error['code']);
        }
        $params = \Yii::$app->request->post();
        if (empty($params['name']) || empty($params['pwd']) || empty($params['email'])) {
            $error = ErrorCode::getError('params_error');
            throw new RestHttpException($error['status'], $error['msg'], $error['code']);
        }
        //用户注册
        $user = new User();
        $user->username = $params['name'];
        $user->email = $params['email'];
        $user->setPassword($params['pwd']);

        $user->generateAuthKey();
        $user->save(false);
        return [
            'error_code' => 0,
            'res_msg' => [
                'uid' => $user->primaryKey,
                'token' => $user->getAuthKey(),
            ]
        ];
    }

    public function actionLogin()
    {
        if (!\Yii::$app->request->isPost) {
            $error = ErrorCode::getError('params_error');
            throw new RestHttpException($error['status'], $error['msg'], $error['code']);
        }
        $params = Yii::$app->request->post();
        if (empty($params['name']) || empty($params['pwd']) || empty($params['app_id'])) {
            $error = ErrorCode::getError('params_error');
            throw new RestHttpException($error['status'], $error['msg'], $error['code']);
        }
        $user = User::findByUsername(['account' => $params['name']]);
        if (!$user || !$user->validatePassword($params['pwd'])) {
            $error = ErrorCode::getError('auth_error');
            throw new RestHttpException($error['status'], $error['msg'], $error['code']);
        }
        $token = $user->getAccessToken($user->user_id);
        return [
            'error_code' => 0,
            'res_msg' => [
                'uid' => $user->primaryKey,
                'token' =>($token!==null)?$token: $user->refreshAccessToken($user->primaryKey, 2),
            ]
        ];
    }
}
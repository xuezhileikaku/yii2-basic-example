<?php


namespace api\controllers;
/**
 * 一个 rest controller 基类，
 * \api\controllers\RestApiBaseController，
 * 不用自带的 \yii\rest\ActiveController，大体上和 \yii\rest\ActiveController 差不多
 *
 */

use common\widgets\HttpSignAuth;
use yii\base\InvalidConfigException;
use yii\base\Model;
use yii\filters\auth\HttpBasicAuth;
use yii\rest\Controller;

class RestController extends Controller
{
    public $modelClass;
    /**
     * @var string the scenario used for updating a model.
     * @see \yii\base\Model::scenarios()
     */
    public $updateScenario = Model::SCENARIO_DEFAULT;
    /**
     * @var string the scenario used for creating a model.
     * @see \yii\base\Model::scenarios()
     */
    public $createScenario = Model::SCENARIO_DEFAULT;

    public function init()
    {
        parent::init(); // TODO: Change the autogenerated stub
        if ($this->modelClass === null) {
            throw new InvalidConfigException('The "ModelClass" property must be set!');
        }
    }

    /**
     * 重写 behaviors
     * @return array[]
     */

    public function behaviors()
    {
        return [
//            如果需要验证用户名和密码，HttpBasicAuth 中的注释中也说明了配置方法
//            'basicAuth' => [
//                'class' => \yii\filters\auth\HttpBasicAuth::className(),
//                'auth' => function ($username, $password) {
//                    $user = User::find()->where(['username' => $username])->one();
//                    if ($user->verifyPassword($password)) {
//                        return $user;
//                    }
//                    return null;
//                },
//            ],
            //增加新的接口验证类，参数加密的sign
            'tokenValidate' => [
                //参数加密的sign所有接口都需要验证
                'class' => HttpSignAuth::className()
            ],
            'authValidate' => [
                'class' => HttpBasicAuth::className(),
                //access-token 部分接口需要验证，需要排除比如 login register 这样的接口
                'optional' => ['register', 'login'],
            ]
        ];
    }

    public function actions()
    {
        return [
            'index' => [
                'class' => 'yii\rest\IndexAction',
                'modelClass' => $this->modelClass,
                'checkAccess' => [$this, 'checkAccess'],
            ],
            'view' => [
                'class' => 'yii\rest\ViewAction',
                'modelClass' => $this->modelClass,
                'checkAccess' => [$this, 'checkAccess'],
            ],
            'create' => [
                'class' => 'yii\rest\CreateAction',
                'modelClass' => $this->modelClass,
                'checkAccess' => [$this, 'checkAccess'],
                'scenario' => $this->createScenario,
            ],
            'update' => [
                'class' => 'yii\rest\UpdateAction',
                'modelClass' => $this->modelClass,
                'checkAccess' => [$this, 'checkAccess'],
                'scenario' => $this->updateScenario,
            ],
            'delete' => [
                'class' => 'yii\rest\DeleteAction',
                'modelClass' => $this->modelClass,
                'checkAccess' => [$this, 'checkAccess'],
            ],
            'options' => [
                'class' => 'yii\rest\OptionsAction',
            ],
        ];
    }

    public function verbs()
    {
        return [
            'index' => ['GET', 'HEAD'],
            'view' => ['GET', 'HEAD'],
            'create' => ['POST'],
            'update' => ['PUT', 'PATCH'],
            'delete' => ['DELETE'],
        ];
    }

    public function checkAccess($action, $model = null, $params = [])
    {
    }
}

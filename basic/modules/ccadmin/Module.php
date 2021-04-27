<?php

namespace app\modules\ccadmin;

/**
 * ccadmin module definition class
 */
class Module extends \yii\base\Module
{
    public $layout='main';
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'app\modules\ccadmin\controllers';

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();
        // 从config.php 加载配置来初始化模块
        \Yii::configure($this, require __DIR__ . '/config/config.php');

    }
}

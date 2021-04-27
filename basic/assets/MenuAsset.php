<?php


namespace app\assets;


use yii\web\AssetBundle;

class MenuAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    /**
     * @inheritdoc
     */
    public $sourcePath = '@web';
    /**
     * @inheritdoc
     */
    public $css = [
        'css/admin/jquery-ui/jquery-ui.css',
    ];
    /**
     * @inheritdoc
     */
    public $js = [
        'css/admin/jquery-ui/jquery-ui.js',
    ];
    /**
     * @inheritdoc
     */
    public $depends = [
        'yii\web\JqueryAsset',
    ];
}

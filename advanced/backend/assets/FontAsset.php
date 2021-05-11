<?php


namespace backend\assets;


use yii\web\AssetBundle;

class FontAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';

    public $css = [
        'adminlte/plugins/fontawesome-free/css/all.min.css',
    ];
}
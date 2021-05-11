<?php


namespace backend\assets;


use yii\web\AssetBundle;
use yii\web\View;

class AdminAsset extends AssetBundle
{

    public $basePath = '@webroot';
    public $baseUrl = '@web';

    public $css = [
        //Font Awesome
        'adminlte/plugins/fontawesome-free/css/all.min.css',
        //Ionicons
        'adminlte/ionic-framework-2.0.1/ionicons.min.css',
        //Tempusdominus Bootstrap 4
        'adminlte/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css',
        //iCheck
        'adminlte/plugins/icheck-bootstrap/icheck-bootstrap.min.css',
        //JQVMap
        'adminlte/plugins/jqvmap/jqvmap.min.css',
        //Theme style
        'adminlte/dist/css/adminlte.min.css',
        //overlayScrollbars
        'adminlte/plugins/overlayScrollbars/css/OverlayScrollbars.min.css',
        //Daterange picker
        'adminlte/plugins/daterangepicker/daterangepicker.css',
        //summernote
        'adminlte/plugins/summernote/summernote-bs4.min.css',
    ];
    public $js = [
//jQuery
        'adminlte/plugins/jquery/jquery.min.js',
//jQuery UI 1.11.4
        'adminlte/plugins/jquery-ui/jquery-ui.min.js',
//Bootstrap 4
        'adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js',
//ChartJS
        'adminlte/plugins/chart.js/Chart.min.js',
//Sparkline
        'adminlte/plugins/sparklines/sparkline.js',
//JQVMap
        'adminlte/plugins/jqvmap/jquery.vmap.min.js',
        'adminlte/plugins/jqvmap/maps/jquery.vmap.usa.js',
//jQuery Knob Chart
        'adminlte/plugins/jquery-knob/jquery.knob.min.js',
//daterangepicker
        'adminlte/plugins/moment/moment.min.js',
        'adminlte/plugins/daterangepicker/daterangepicker.js',
//Tempusdominus Bootstrap 4
        'adminlte/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js',
//Summernote
        'adminlte/plugins/summernote/summernote-bs4.min.js',
//overlayScrollbars
        'adminlte/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js',
//AdminLTE App
        'adminlte/dist/js/adminlte.js',

    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap4\BootstrapAsset',
        'yii\bootstrap4\BootstrapPluginAsset',
    ];
    public $jsOptions = ['position' => View::POS_HEAD];
}
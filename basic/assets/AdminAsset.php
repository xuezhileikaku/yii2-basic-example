<?php


namespace app\assets;


use yii\web\AssetBundle;
use yii\web\View;

class AdminAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        //Google Font: Source Sans Pro
        'admin/font-google.css',
        //Font Awesome
        'admin/fontawesome-free/css/all.min.css',
        //Ionicons
        'admin/ionicons/css/ionicons.min.css',
        //Tempusdominus Bootstrap 4
        'admin/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css',
        //iCheck
        'admin/icheck-bootstrap/icheck-bootstrap.min.css',
        //JQVMap
        'admin/jqvmap/jqvmap.min.css',
        //Theme style
        'admin/dist/css/adminlte.min.css',
        //overlayScrollbars
        'admin/overlayScrollbars/css/OverlayScrollbars.min.css',
        //Daterange picker
        'admin/daterangepicker/daterangepicker.css',
        //summernote
        'admin/summernote/summernote-bs4.min.css',

    ];
    public $js = [
//jQuery
        'admin/jquery/jquery.min.js',
//jQuery UI 1.11.4
        'admin/jquery-ui/jquery-ui.min.js',
//Bootstrap 4
        'admin/bootstrap/js/bootstrap.bundle.min.js',
//ChartJS
        'admin/chart.js/Chart.min.js',
//Sparkline
        'admin/sparklines/sparkline.js',
//JQVMap
        'admin/jqvmap/jquery.vmap.min.js',
        'admin/jqvmap/maps/jquery.vmap.usa.js',
//jQuery Knob Chart
        'admin/jquery-knob/jquery.knob.min.js',
//daterangepicker
        'admin/moment/moment.min.js',
        'admin/daterangepicker/daterangepicker.js',
//Tempusdominus Bootstrap 4
        'admin/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js',
//Summernote
        'admin/summernote/summernote-bs4.min.js',
//overlayScrollbars
        'admin/overlayScrollbars/js/jquery.overlayScrollbars.min.js',
//AdminLTE App
        'admin/dist/js/adminlte.js',
//AdminLTE for demo purposes
        'admin/dist/js/demo.js',
//AdminLTE dashboard demo (This is only for demo purposes)
        'admin/dist/js/pages/dashboard.js',
    ];
    public $depends = [
//        'yii\web\YiiAsset',
//        'yii\bootstrap4\BootstrapAsset', // this line
    ];
    public $jsOptions = ['position' => View::POS_HEAD];
}

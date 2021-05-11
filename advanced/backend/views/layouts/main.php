<?php

use yii\helpers\Html;
use backend\assets\AdminAsset;
use backend\assets\FontAsset;

/** @var \yii\web\View $this */
/** @var string $content */

$this->registerCssFile('https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700');
if (Yii::$app->controller->action->id === 'login') {
    /**
     * Do not use this code in your template. Remove it.
     * Instead, use the code  $this->layout = '//main-login'; in your controller.
     */
    echo $this->render(
        'main-login',
        ['content' => $content]
    );
} else {
    AdminAsset::register($this);
    FontAsset::register($this);
    //AdminLTE for demo purposes
    $this->registerJsFile('@web/adminlte/dist/js/demo.js', ['depends' => 'backend\assets\AdminAsset', 'position' => $this::POS_END]);
//AdminLTE dashboard demo (This is only for demo purposes)
    $this->registerJsFile('@web/adminlte/dist/js/pages/dashboard.js', ['depends' => 'backend\assets\AdminAsset', 'position' => $this::POS_END]);

    $directoryUrl = Yii::getAlias('@backend/web/adminlte/dist'); ?>
    <?php $this->beginPage() ?>
    <!DOCTYPE html>
    <html lang="<?= Yii::$app->language ?>">

    <head>
        <meta charset="<?= Yii::$app->charset ?>"/>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?= Html::csrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>
    </head>

    <body class="hold-transition skin-blue sidebar-mini">
    <?php $this->beginBody() ?>
    <div class="wrapper">

        <?= $this->render(
            'head.php',
            ['directoryAsset' => $directoryUrl]
        ) ?>

        <?= $this->render(
            'left.php',
            ['directoryAsset' => $directoryUrl]
        )
        ?>

        <?= $this->render(
            'conten.php',
            ['content' => $content, 'directoryAsset' => $directoryUrl]
        ) ?>

    </div>

    <script>
        //Resolve conflict in jQuery UI tooltip with Bootstrap tooltip
        $.widget.bridge('uibutton', $.ui.button)
    </script>
    <?php $this->endBody() ?>
    </body>

    </html>
    <?php $this->endPage() ?>
<?php } ?>
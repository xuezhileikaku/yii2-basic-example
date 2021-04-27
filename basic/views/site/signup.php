<?php

use yii\bootstrap4\Html;
use yii\bootstrap\ActiveForm;

$this->title = '注册'

?>
<div class="site-signup" style="margin-top:54px;">
    <div class="container" style="background-color: #fff;">
        <h1><?= Html::encode($this->title) ?></h1>

        <p>注册:</p>

        <div class="row">
            <div class="col-lg-5">
                <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>

                <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>

                <?= $form->field($model, 'email') ?>

                <?= $form->field($model, 'password')->passwordInput() ?>

                <div class="form-group">
                    <?= Html::submitButton('Signup', ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
                </div>

                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>

</div>

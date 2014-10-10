<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Users */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="users-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'levelid')->textInput() ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'username')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'password')->passwordInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'fullname')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'birthday')->textInput(['maxlength' => 10]) ?>

    <?= $form->field($model, 'sex')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'phonenumber')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'city')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'avatar')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'vang')->textInput() ?>

    <?= $form->field($model, 'xu')->textInput() ?>

    <?= $form->field($model, 'statu')->textInput() ?>

    <?= $form->field($model, 'code')->textInput(['maxlength' => 65]) ?>

    <?= $form->field($model, 'datecreated')->textInput() ?>

    <?= $form->field($model, 'openID')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'openType')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'displayname')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'codemail')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'exp')->textInput() ?>

    <?= $form->field($model, 'friends')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'lastLogin')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'ticket')->textInput() ?>

    <?= $form->field($model, 'onlineDay')->textInput() ?>

    <?= $form->field($model, 'constrainMoney')->textInput() ?>

    <?= $form->field($model, 'eventPoint')->textInput() ?>

    <?= $form->field($model, 'eventTime')->textInput() ?>

    <?= $form->field($model, 'published')->textInput() ?>

    <?= $form->field($model, 'party_id')->textInput() ?>

    <?= $form->field($model, 'stt_check')->textInput() ?>

    <?= $form->field($model, 'link_user_create')->textInput(['maxlength' => 100]) ?>

    <?= $form->field($model, 'hash_code')->textInput(['maxlength' => 50]) ?>

    <?= $form->field($model, 'new_encryption_method')->textInput(['maxlength' => 10]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

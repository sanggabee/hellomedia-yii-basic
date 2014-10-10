<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Users */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="users-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'levelid',
            'email:email',
            'username',
            'password',
            'fullname',
            'birthday',
            'sex',
            'phonenumber',
            'city',
            'avatar',
            'vang',
            'xu',
            'statu',
            'code',
            'datecreated',
            'openID',
            'openType',
            'displayname',
            'codemail:email',
            'exp',
            'friends:ntext',
            'lastLogin',
            'ticket',
            'onlineDay',
            'constrainMoney',
            'eventPoint',
            'eventTime:datetime',
            'published',
            'party_id',
            'stt_check',
            'link_user_create',
            'hash_code',
            'new_encryption_method',
        ],
    ]) ?>

</div>

<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Users';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="users-index">
    <h1><?= Html::encode($this->title) ?></h1>
    <p>
        <?= Html::a('Create Users', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?php \yii\widgets\Pjax::begin(); ?>
    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'id',
            'levelid',
            'email:email',
            'username',
            'password',
            // 'fullname',
            // 'birthday',
            // 'sex',
            // 'phonenumber',
            // 'city',
            // 'avatar',
            // 'vang',
            // 'xu',
            // 'statu',
            // 'code',
            // 'datecreated',
            // 'openID',
            // 'openType',
            // 'displayname',
            // 'codemail:email',
            // 'exp',
            // 'friends:ntext',
            // 'lastLogin',
            // 'ticket',
            // 'onlineDay',
            // 'constrainMoney',
            // 'eventPoint',
            // 'eventTime:datetime',
            // 'published',
            // 'party_id',
            // 'stt_check',
            // 'link_user_create',
            // 'hash_code',
            // 'new_encryption_method',
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]);
    ?>
    <?php \yii\widgets\Pjax::end(); ?>
    <script>
        // on your javascript
        // I highly recommend that you setup the id of your PJax widget
//        $.pjax.reload({container: '#idofyourpjaxwidget'});
    </script>
</div>

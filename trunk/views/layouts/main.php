<?php

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

/* @var $this \yii\web\View */
/* @var $content string */

AppAsset::register($this);
?>
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
    <body>
        <?php $this->beginBody() ?>
        <div class="container-fluid">
            <div class="row" id="header">
                <div class="navbar-header">
                    <button data-target=".bs-example-js-navbar-collapse" data-toggle="collapse" type="button" class="navbar-toggle collapsed">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a href="#" class="navbar-brand" id="text-logo">Hello Media</a>
                </div>
                <div class="collapse navbar-collapse bs-example-js-navbar-collapse">
                    <ul class="nav navbar-nav navbar-right">
                        <li class="dropdown" id="fat-menu">
                            <a data-toggle="dropdown" class="dropdown-toggle" role="button" id="drop3" href="#">
                                Tùy chọn
                                <span class="caret"></span></a>
                            <ul aria-labelledby="drop3" role="menu" class="dropdown-menu">
                                <li role="presentation"><a href="#" tabindex="-1" role="menuitem">Cài đặt</a></li>
                                <li role="presentation"><a href="#" tabindex="-1" role="menuitem">Thoát</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="row">
                <!--                <ol class="breadcrumb">
                                    <li><a href="#">Home</a></li>
                                    <li><a href="#">Library</a></li>
                                    <li class="active">Data</li>
                                </ol>-->
                <?=
                Breadcrumbs::widget([
                    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                ])
                ?>
            </div>
            <div class="row">
                <div class="col-md-2 border-right">
                    <ul style="max-width: 300px;" class="nav nav-pills nav-stacked">
                        <li class="active"><a href="#">Tổng Quan</a></li>
                        <li><a href="#">Thống kê</a></li>
                        <li><a href="#">Dữ liệu</a></li>
                    </ul>
                </div>
                <div class="col-md-10 border-left">
                    <div class="main">
                        <?= $content ?>
                    </div>
                </div>
            </div>
            <div class="row" id="footer">
                <label>
                    © Copyright 2014 Hello Media, All rights reserved  
                </label>
            </div>
        </div>
        <?php $this->endBody() ?>
    </body>
</html>
<?php $this->endPage() ?>

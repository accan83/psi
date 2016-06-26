<?php

/* @var $this yii\web\View */

$this->title = 'Sakura Painting';
?>
<div class="site-index">

    <div class="jumbotron">
        <h1>Wellcome!</h1>

        <p class="lead">You have successfully login as <?= Yii::$app->user->identity->username ?> .</p>
    </div>
</div>

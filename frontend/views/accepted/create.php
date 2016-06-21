<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\MaterialAccepted */

$this->title = 'Create Material Accepted';
$this->params['breadcrumbs'][] = ['label' => 'Material Accepteds', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="material-accepted-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

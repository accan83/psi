<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\ReservedMaterial */

$this->title = 'Update Reserved Material: ' . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Reserved Materials', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="reserved-material-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

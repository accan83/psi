<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\ReservedMaterial */

$this->title = 'Reserved ' . date('d M Y', $model->reservedMaterial->created_at) . ': Add Product';
$this->params['breadcrumbs'][] = ['label' => 'Reserved Materials', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => 'Reserved ' . date('d M Y', $model->reservedMaterial->created_at), 'url' => ['view', 'id' => $model->reservedMaterial->id]];
$this->params['breadcrumbs'][] = 'Add Product';
?>
<div class="reserved-material-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

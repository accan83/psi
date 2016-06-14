<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\WastedMaterial */

$this->title = 'Wasted ' . date('d M Y', $wastedMaterial->created_at) . ': Approve Material';
$this->params['breadcrumbs'][] = ['label' => 'Wasted Materials', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => 'Wasted ' . date('d M Y', $wastedMaterial->created_at), 'url' => ['view', 'id' => $wastedMaterial->id, 'material_expenditure_id' => $wastedMaterial->material_expenditure_id]];
$this->params['breadcrumbs'][] = 'Approve Material';
?>
<div class="wasted-material-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_formDetail', [
        'model' => $model,
        'material' => $material,
    ]) ?>

</div>

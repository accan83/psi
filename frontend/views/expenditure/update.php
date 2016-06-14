<?php

use common\models\MaterialExpenditure;
use yii\data\ActiveDataProvider;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\MaterialExpenditure */

$this->title = 'Expenditure ' . date('d M Y', $materialExpenditure->created_at) . ': Approve Material';
$this->params['breadcrumbs'][] = ['label' => 'Material Expenditures', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => 'Expenditure ' . date('d M Y', $materialExpenditure->created_at), 'url' => ['view', 'id' => $materialExpenditure->id, 'requested_material_id' => $materialExpenditure->requested_material_id]];
$this->params['breadcrumbs'][] = 'Approve Material';
?>
<div class="material-expenditure-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_formDetail', [
            'model' => $model,
            'material' => $material,
    ]) ?>

</div>

<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\MaterialAccepted */

$this->title = 'Accepted ' . date('d M Y', $materialAccepted->created_at) . ': Accept Material';
$this->params['breadcrumbs'][] = ['label' => 'Materials Accepted', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => 'Accepted ' . date('d M Y', $materialAccepted->created_at), 'url' => ['view', 'id' => $materialAccepted->id, 'reserved_material_id' => $materialAccepted->reserved_material_id]];
$this->params['breadcrumbs'][] = 'Approve Material';
?>
<div class="material-accepted-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_formDetail', [
        'model' => $model,
        'material' => $material,
    ]) ?>

</div>

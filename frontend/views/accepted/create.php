<?php

use common\models\ReservedMaterialDetail;
use yii\data\ActiveDataProvider;
use yii\grid\GridView;
use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\MaterialAccepted */

$this->title = 'Create Accepted';
$this->params['breadcrumbs'][] = ['label' => 'Materials Accepted', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Reserved ' . date('d M Y', $reserved->created_at);
$this->params['breadcrumbs'][] = $this->title;
$model->reserved_material_id = $reserved->id;

$dataProvider = new ActiveDataProvider([
    'query' => ReservedMaterialDetail::find()->where(['reserved_material_id' => $reserved->id]),
]);
?>
<div class="material-accepted-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'material.code',
            'qty',
        ],
    ]); ?>

    <?= $this->render('_form', [
        'dataProvider' => $dataProvider,
        'model' => $model,
    ]) ?>

</div>

<?php

use common\models\MaterialExpenditureDetail;
use yii\data\ActiveDataProvider;
use yii\helpers\Html;
use yii\grid\GridView;


/* @var $this yii\web\View */
/* @var $model common\models\WastedMaterial */

$this->title = 'Create Wasted Material';
$this->params['breadcrumbs'][] = ['label' => 'Wasted Materials', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Expenditure ' . date('d M Y', $requested->created_at);
$this->params['breadcrumbs'][] = $this->title;
$model->material_expenditure_id = $requested->id;

$dataProvider = new ActiveDataProvider([
    'query' => MaterialExpenditureDetail::find()->where(['material_expenditure_id' => $requested->id]),
]);
?>
<div class="wasted-material-create">

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

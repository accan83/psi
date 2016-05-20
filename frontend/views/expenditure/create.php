<?php

use common\models\RequestedMaterial;
use common\models\RequestedMaterialDetail;
use yii\data\ActiveDataProvider;
use yii\grid\GridView;
use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\MaterialExpenditure */

$requested_id = Yii::$app->request->get('requested_material_id');
$model->requested_material_id = $requested_id;
$requested = RequestedMaterial::find($requested_id)->one();
$this->title = 'Create Expenditure';
$this->params['breadcrumbs'][] = ['label' => 'Material Expenditures', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Request ' . date('d M Y', $requested->created_at);
$this->params['breadcrumbs'][] = $this->title;

$dataProvider = new ActiveDataProvider([
    'query' => RequestedMaterialDetail::find()->where(['requested_material_id' => $requested_id]),
]);
?>
<div class="material-expenditure-create">

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

<?php

use common\models\Product;
use common\models\RequestedMaterialDetail;
use yii\data\ActiveDataProvider;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\RequestedMaterial */

$order_id = Yii::$app->request->get('order_id');
$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Requested Materials', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$dataProvider = new ActiveDataProvider([
    'query' => Product::find()->where(['order_id' => $order_id]),
]);

$dataProvider2 = new ActiveDataProvider([
    'query' => RequestedMaterialDetail::find()->where(['requested_material_id' => $model->id]),
]);
?>
<div class="requested-material-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'material.code',
            'name',
            'qty',
        ],
    ]); ?>

    <p>
        <?= Html::a('Add Material', ['update', 'id' => $model->id, 'order_id' => $model->order_id], ['class' => 'btn btn-primary']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider2,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'material.code',
            'qty',
        ],
    ]); ?>

</div>

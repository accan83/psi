<?php

use common\models\Product;
use yii\data\ActiveDataProvider;
use yii\grid\GridView;
use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\RequestedMaterial */

$order_id = Yii::$app->request->get('order_id');
$model->order_id = $order_id;
$this->title = 'Create Request';
$this->params['breadcrumbs'][] = ['label' => 'Requested Materials', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Order #' . $order_id;
$this->params['breadcrumbs'][] = $this->title;

$dataProvider = new ActiveDataProvider([
    'query' => Product::find()->where(['order_id' => $order_id]),
]);
?>
<div class="requested-material-create">

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

    <?= $this->render('_form', [
        'dataProvider' => $dataProvider,
        'model' => $model,
    ]) ?>

</div>

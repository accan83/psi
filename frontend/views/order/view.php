<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $model backend\models\Order */

$this->title = 'Order ' . '#' . $model->id . ' by ' . $model->customer;
$this->params['breadcrumbs'][] = ['label' => 'Orders', 'url' => ['index']];
$this->params['breadcrumbs'][] = '#' . $model->id;
?>
<div class="order-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'customer',
            [
                'attribute' => 'created_at',
                'format' => ['date', 'php:d/m/Y']
            ],
        ],
    ]) ?>

    <p>
        <?= Html::a('Add Product', ['product/add', 'order_id' => $model->id], ['class' => 'btn btn-primary']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'material.code',
            'name',
            'qty',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>

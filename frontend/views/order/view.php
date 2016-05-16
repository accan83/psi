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

    <p>
        <?= Html::a('Edit Customer', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
    </p>

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

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update} {delete}',
                'buttons' => [
                    'update' => function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-pencil"></span>', [
                            'product/update',
                            'order_id' => $model->order_id,
                            'material_id' => $model->material_id,
                            'name' => $model->name
                        ], [
                            'title' => Yii::t('yii', 'Edit Product'),
                        ]);

                    },
                    'delete' => function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-trash"></span>', [
                            'product/delete',
                            'order_id' => $model->order_id,
                            'material_id' => $model->material_id,
                            'name' => $model->name,
                        ], [
                            'title' => Yii::t('yii', 'Edit Product'),
//                            'data-method'=>'post',
                            'data' => [
                                'confirm' => 'Are you sure want to delete "' . $model->name . '"?',
                                'method' => 'post',
                            ],
                        ]);

                    }
                ]
            ],
        ],
    ]); ?>

</div>

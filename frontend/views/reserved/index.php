<?php

use frontend\controllers\ExpenditureController;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Reserved Materials';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="reserved-material-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="row">
        <div class="col-md-5">
            <?= GridView::widget([
                'dataProvider' => $dataProvider2,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],

                    'code',

                    [
                        'label' => 'Safety Stock',
                        'attribute' => 'safety_stock',
                        'value' => function ($model, $key, $index, $column) {
                            return $model->safety_stock . 'kg';
                        },
                    ],

                    [
                        'label' => 'Stock',
                        'attribute' => 'stock.qty',
                        'value' => function ($model, $key, $index, $column) {
                            return $model->stock->qty . 'kg';
                        },
                    ],

                    [
                        'label' => 'ROP',
                        'value' => function ($model, $key, $index, $column) {
                            return ExpenditureController::getReOrderPoint($model->id) . 'kg';
                        },
                    ]
                ],
            ]); ?>
        </div>
        <div class="col-md-7">
            <p>
                <?= Html::a('Create Reserved Material', ['create'], ['class' => 'btn btn-success']) ?>
            </p>

            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],

                    [
                        'label' => 'Reserved Created',
                        'attribute' => 'created_at',
                        'format' => ['date', 'php:d M Y [H:i:s]']
                    ],

                    ['class' => 'yii\grid\ActionColumn'],
                ],
            ]); ?>
        </div>
    </div>

</div>

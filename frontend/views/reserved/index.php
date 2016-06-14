<?php

use common\models\ReservedMaterialDetail;
use frontend\controllers\ExpenditureController;
use yii\data\ActiveDataProvider;
use yii\helpers\Html;
//use yii\grid\GridView;
use kartik\grid\GridView;

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
                'export' => false,
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
                'export' => false,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],

                    [
                        'label' => 'Reserved Created',
                        'attribute' => 'created_at',
                        'format' => ['date', 'php:d M Y [H:i:s]']
                    ],

                    [
                        'class' => 'kartik\grid\ExpandRowColumn',
                        'expandIcon' => '<span class="glyphicon glyphicon-chevron-down"></span>',
                        'collapseIcon' => '<span class="glyphicon glyphicon-chevron-up"></span>',
                        'expandTitle' => 'Show All Requested Material',
                        'collapseTitle' => 'Hide All Requested Material',
                        'value' => function ($model, $key, $index, $column) {
                            return GridView::ROW_COLLAPSED;
                        },
                        'detail' => function ($model, $key, $index, $column) {
                            $dataProvider = new ActiveDataProvider([
                                'query' => ReservedMaterialDetail::find()->where(['reserved_material_id' => $model->id]),
                            ]);

                            return Yii::$app->controller->renderPartial('_allReserved', [
//                        'dataProvider' => $dataProvider,
                                'dataProvider' => $dataProvider,
                            ]);
                        }
                    ],
                ],
            ]); ?>
        </div>
    </div>

</div>

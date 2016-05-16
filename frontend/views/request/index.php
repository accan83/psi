<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Requested Materials';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="requested-material-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Requested Material', ['create'], ['class' => 'btn btn-success']) ?>
    </p>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'export' => false,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute' => 'created_at',
                'format' => ['date', 'php:d/m/Y']
            ],

            'customer',

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

                }
            ],

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{create}',
                'buttons' => [
                    'create' => function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-new-window"></span>', [
                            'request/create',
                            'order_id' => $model->id,
                        ], [
                            'title' => Yii::t('yii', 'Create Request Material'),
                        ]);
                    }
                ]
            ],
        ],
    ]); ?>

</div>

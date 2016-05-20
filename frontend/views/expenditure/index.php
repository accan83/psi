<?php

use common\models\MaterialExpenditure;
use common\models\RequestedMaterial;
use common\models\RequestedMaterialDetail;
use kartik\grid\GridView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Material Expenditures';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="material-expenditure-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'export' => false,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'label' => 'Request Created',
                'attribute' => 'created_at',
                'format' => ['date', 'php:d M Y [H:i:s]']
            ],

            [
                'label' => 'Total Requested',
                'value' => function ($model, $key) {
                    $detail = RequestedMaterialDetail::find($model->id)->all();
                    $result = '';
                    foreach ($detail as $idx => $data) {
                        if ($idx != 0) {
                            $result .= '; ';
                        }
                        $result .= $data->material->code;
                        $result .= ' (';
                        $result .= $data->qty;
                        $result .= 'kg)';
                    }

                    return $result;
                }
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
                    $materialExpenditure = MaterialExpenditure::find()->where(['requested_material_id' => $model->id])->orderBy(['created_at' => SORT_DESC])->all();

                    return Yii::$app->controller->renderPartial('_allExpenditure', [
//                        'dataProvider' => $dataProvider,
                        'dataProvider' => $materialExpenditure,
                        'order_id' => $model->id,
                    ]);
                }
            ],

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{create}',
                'buttons' => [
                    'create' => function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-new-window"></span>', [
                            'expenditure/create',
                            'requested_material_id' => $model->id,
                        ], [
                            'title' => Yii::t('yii', 'Create Request Material'),
                        ]);
                    }
                ]
            ],
        ],
    ]); ?>

</div>

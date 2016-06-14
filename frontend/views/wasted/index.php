<?php

use common\models\MaterialExpenditureDetail;
use common\models\WastedMaterial;
use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Wasted Materials';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="wasted-material-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'export' => false,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'label' => 'Expenditure Created',
                'attribute' => 'created_at',
                'format' => ['date', 'php:d M Y [H:i:s]']
            ],

            [
                'label' => 'Total Expenditure',
                'value' => function ($model, $key) {
                    $detail = MaterialExpenditureDetail::find()->where(['material_expenditure_id' => $model->id])->all();
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
                    $materialWasted = WastedMaterial::find()->where(['material_expenditure_id' => $model->id])->orderBy(['created_at' => SORT_DESC])->all();

                    return Yii::$app->controller->renderPartial('_allWasted', [
//                        'dataProvider' => $dataProvider,
                        'dataProvider' => $materialWasted,
                        'material_expenditure_id' => $model->id,
                    ]);
                }
            ],

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{create}',
                'buttons' => [
                    'create' => function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-new-window"></span>', [
                            'wasted/create',
                            'material_expenditure_id' => $model->id,
                        ], [
                            'title' => Yii::t('yii', 'Create Wasted Material'),
                        ]);
                    }
                ]
            ],
        ],
    ]); ?>

</div>

<?php

use common\models\MaterialExpenditureDetail;
use common\models\WastedMaterialDetail;
use yii\data\ActiveDataProvider;
use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $model common\models\WastedMaterial */

$this->title = 'Wasted ' . date('d M Y', $model->created_at);
$this->params['breadcrumbs'][] = ['label' => 'Wasted Materials', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$dataProvider = new ActiveDataProvider([
    'query' => MaterialExpenditureDetail::find()->where(['material_expenditure_id' => $material_expenditure_id]),
]);

$dataProvider2 = new ActiveDataProvider([
    'query' => WastedMaterialDetail::find()->where(['wasted_material_id' => $model->id]),
]);
?>
<div class="wasted-material-view">

    <h1>Material Expenditure</h1>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'material.code',
            'qty',

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{create}',
                'buttons' => [
                    'create' => function ($url, $model) {
                        $id = Yii::$app->request->get('id');
                        $approved = WastedMaterialDetail::find()->where(['wasted_material_id' => $id, 'material_id' => $model->material_id])->one();
                        if (count($approved) == 0) {
                            return Html::a('<span class="glyphicon glyphicon-ok"></span>', [
                                'wasted/update',
                                'id' => $id,
                                'material_id' => $model->material_id,
                            ], [
                                'title' => Yii::t('yii', 'Accept Wasted'),
                            ]);
                        }
                        else {
                            return '';
                        }
                    }
                ]
            ],
        ],
    ]); ?>

    <h1>Wasted Material</h1>

    <?= GridView::widget([
        'dataProvider' => $dataProvider2,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'material.code',
            'qty',
        ],
    ]); ?>

</div>

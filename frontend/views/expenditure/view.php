<?php

use common\models\MaterialExpenditureDetail;
use common\models\RequestedMaterialDetail;
use yii\data\ActiveDataProvider;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\MaterialExpenditure */

$this->title = 'Expenditure ' . date('d M Y', $model->created_at);
$this->params['breadcrumbs'][] = ['label' => 'Material Expenditures', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$dataProvider = new ActiveDataProvider([
    'query' => RequestedMaterialDetail::find()->where(['requested_material_id' => $requested_material_id]),
]);

$dataProvider2 = new ActiveDataProvider([
    'query' => MaterialExpenditureDetail::find()->where(['material_expenditure_id' => $model->id]),
]);
?>
<div class="material-expenditure-view">

    <h1>Requested Material</h1>

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
                        $approved = MaterialExpenditureDetail::find()->where(['material_expenditure_id' => $id, 'material_id' => $model->material_id])->one();
                        if (count($approved) == 0) {
                            return Html::a('<span class="glyphicon glyphicon-ok"></span>', [
                                'expenditure/update',
                                'id' => $id,
                                'material_id' => $model->material_id,
                            ], [
                                'title' => Yii::t('yii', 'Approve Expenditure'),
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

    <h1>Approved Material</h1>

    <?= GridView::widget([
        'dataProvider' => $dataProvider2,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'material.code',
            'qty',
        ],
    ]); ?>

</div>

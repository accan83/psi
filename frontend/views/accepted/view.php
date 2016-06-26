<?php

use common\models\MaterialAcceptedDetail;
use common\models\ReservedMaterialDetail;
use yii\data\ActiveDataProvider;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\MaterialAccepted */

$this->title = 'Accepted ' . date('d M Y', $model->created_at);
$this->params['breadcrumbs'][] = ['label' => 'Materials Accepted', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$dataProvider = new ActiveDataProvider([
    'query' => ReservedMaterialDetail::find()->where(['reserved_material_id' => $reserved_material_id]),
]);

$dataProvider2 = new ActiveDataProvider([
    'query' => MaterialAcceptedDetail::find()->where(['material_accepted_id' => $model->id]),
]);
?>
<div class="material-accepted-view">

    <h1>Reserved Material</h1>

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
                        $approved = MaterialAcceptedDetail::find()->where(['material_accepted_id' => $id, 'material_id' => $model->material_id])->one();
                        if (count($approved) == 0) {
                            return Html::a('<span class="glyphicon glyphicon-ok"></span>', [
                                'accepted/update',
                                'id' => $id,
                                'material_id' => $model->material_id,
                            ], [
                                'title' => Yii::t('yii', 'Accept Material'),
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

    <h1>Accepted Material</h1>

    <?= GridView::widget([
        'dataProvider' => $dataProvider2,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'material.code',
            'qty',
        ],
    ]); ?>

</div>

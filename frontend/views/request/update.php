<?php

use common\models\Product;
use common\models\RequestedMaterialDetail;
use yii\data\ActiveDataProvider;
use yii\grid\GridView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\RequestedMaterial */

$order_id = Yii::$app->request->get('order_id');
$id = Yii::$app->request->get('id');
$this->title = 'Update Requested Material: ' . ' ' . $id;
$this->params['breadcrumbs'][] = ['label' => 'Requested Materials', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $id, 'url' => ['view', 'id' => $id, 'order_id' => $order_id]];
$this->params['breadcrumbs'][] = 'Update';

$model->requested_material_id = $id;
$dataProvider = new ActiveDataProvider([
    'query' => Product::find(['order_id' => $order_id]),
]);
?>
<div class="requested-material-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_formDetail', [
        'dataProvider' => $dataProvider,
        'model' => $model,
    ]) ?>
    
</div>

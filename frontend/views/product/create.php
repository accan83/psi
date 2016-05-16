<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Product */

$order_id = Yii::$app->request->get('order_id');
$this->title = 'Add Product';
$this->params['breadcrumbs'][] = ['label' => 'Orders', 'url' => ['order/index']];
$this->params['breadcrumbs'][] = ['label' => '#' . $order_id, 'url' => ['order/view', 'id' => $order_id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-create">

    <h1><?= Html::encode('Order #' . $order_id . ': ' . $this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

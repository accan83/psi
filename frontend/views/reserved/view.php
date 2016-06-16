<?php

use common\models\Material;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\ReservedMaterial */

$this->title = 'Reserved ' . date('d M Y', $model->created_at);
$this->params['breadcrumbs'][] = ['label' => 'Reserved Materials', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="reserved-material-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php $count = count(Material::getTouchROP());?>
    <?php $data = count($dataProvider);?>

    <p>
        <?= $count > $data ? Html::a('Add Product', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) : '' ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'material.code',
            'qty',
        ],
    ]); ?>

</div>

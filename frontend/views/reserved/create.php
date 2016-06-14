<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\ReservedMaterial */

$this->title = 'Create Reserved Material';
$this->params['breadcrumbs'][] = ['label' => 'Reserved Materials', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="reserved-material-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

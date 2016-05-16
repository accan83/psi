<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\RequestedMaterial */

$this->title = 'Create Requested Material';
$this->params['breadcrumbs'][] = ['label' => 'Requested Materials', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="requested-material-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

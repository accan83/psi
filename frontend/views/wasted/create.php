<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\WastedMaterial */

$this->title = 'Create Wasted Material';
$this->params['breadcrumbs'][] = ['label' => 'Wasted Materials', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="wasted-material-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

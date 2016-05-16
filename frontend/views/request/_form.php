<?php

use common\models\Material;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\RequestedMaterial */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="requested-material-form">
    
    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'order_id')->hiddenInput()->label('') ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create Request' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

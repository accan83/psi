<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\MaterialAccepted */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="material-accepted-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'reserved_material_id')->hiddenInput()->label('') ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

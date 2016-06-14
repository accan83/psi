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
    
    <div class="form-group">
        <label class="control-label">Material Code</label>
        <input type="text" class="form-control" value="<?= $material->code ?>" disabled />
    </div>

    <?= $form->field($model, 'qty')->textInput(['type' => 'number', 'max' => $model->qty, 'min' => 1]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Approve' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?= $form->field($model, 'wasted_material_id')->hiddenInput()->label(false) ?>

    <?= $form->field($model, 'material_id')->hiddenInput()->label(false) ?>

    <?php ActiveForm::end(); ?>

</div>

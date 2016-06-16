<?php

use common\models\Material;
use frontend\controllers\ExpenditureController;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\ReservedMaterial */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="reserved-material-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'material_id')->dropDownList(ArrayHelper::map(Material::getTouchROP(), 'id', 'code')) ?>

    <?= $form->field($model, 'qty')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

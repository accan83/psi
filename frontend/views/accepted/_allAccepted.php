<?php
/**
 * Created by PhpStorm.
 * User: accan
 * Date: 18/05/16
 * Time: 17:15
 */

use common\models\MaterialAcceptedDetail;
use common\models\MaterialExpenditureDetail;
use common\models\RequestedMaterialDetail;
use yii\data\ActiveDataProvider;
use yii\grid\GridView;
use yii\helpers\Html;

?>
<div class="all-request">
    <?php
//    print_r($dataProvider);
    foreach ($dataProvider as $data) {
    ?>
        <?= Html::a('Edit Expenditure', ['expenditure/view', 'id' => $data->id, 'requested_material_id' => $requested_material_id], ['class'=>'btn btn-primary btn-sm pull-right']) ?>
        <h3><?= date("d M Y [H:i:s]", $data->created_at); ?></h3>
        <?php
        $dataProvider2 = new ActiveDataProvider([
            'query' => MaterialAcceptedDetail::find()->where(['material_accepted_id' => $data->id]),
        ]);
        echo GridView::widget([
            'dataProvider' => $dataProvider2,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                'material.code',
                'qty',
            ],
        ]);
    }

    if (count($dataProvider) == 0) {
        echo "No result found";
    }
    ?>
</div>

<?php
/**
 * Created by PhpStorm.
 * User: accan
 * Date: 18/05/16
 * Time: 17:15
 */

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
        <h3><?= date("d M Y [H:i:s]", $data->created_at); ?></h3>
        <?php
        $dataProvider2 = new ActiveDataProvider([
            'query' => MaterialExpenditureDetail::find()->where(['material_expenditure_id' => $data->id]),
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

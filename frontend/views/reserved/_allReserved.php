<?php
/**
 * Created by PhpStorm.
 * User: accan
 * Date: 18/05/16
 * Time: 17:15
 */

use common\models\RequestedMaterialDetail;
use yii\data\ActiveDataProvider;
use yii\grid\GridView;
use yii\helpers\Html;

?>
<div class="all-request">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'material.code',
            'qty',
        ],
    ]); ?>
</div>

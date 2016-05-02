<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "requested_material".
 *
 * @property integer $id
 * @property integer $order_id
 * @property integer $created_at
 *
 * @property Order $order
 * @property RequestedMaterialDetail[] $requestedMaterialDetails
 * @property Material[] $materials
 */
class RequestedMaterial extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'requested_material';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'order_id', 'created_at'], 'required'],
            [['id', 'order_id', 'created_at'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'order_id' => 'Order ID',
            'created_at' => 'Created At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrder()
    {
        return $this->hasOne(Order::className(), ['id' => 'order_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRequestedMaterialDetails()
    {
        return $this->hasMany(RequestedMaterialDetail::className(), ['requested_material_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMaterials()
    {
        return $this->hasMany(Material::className(), ['id' => 'material_id'])->viaTable('requested_material_detail', ['requested_material_id' => 'id']);
    }
}

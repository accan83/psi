<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "material_usage".
 *
 * @property integer $id
 * @property integer $order_id
 * @property integer $wasted_material_id
 * @property integer $created_at
 *
 * @property Order $order
 * @property WastedMaterial $wastedMaterial
 * @property MaterialUsageDetail[] $materialUsageDetails
 * @property Material[] $materials
 * @property WastedMaterial[] $wastedMaterials
 */
class MaterialUsage extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'material_usage';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'order_id', 'wasted_material_id', 'created_at'], 'required'],
            [['id', 'order_id', 'wasted_material_id', 'created_at'], 'integer']
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
            'wasted_material_id' => 'Wasted Material ID',
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
    public function getWastedMaterial()
    {
        return $this->hasOne(WastedMaterial::className(), ['id' => 'wasted_material_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMaterialUsageDetails()
    {
        return $this->hasMany(MaterialUsageDetail::className(), ['material_usage_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMaterials()
    {
        return $this->hasMany(Material::className(), ['id' => 'material_id'])->viaTable('material_usage_detail', ['material_usage_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getWastedMaterials()
    {
        return $this->hasMany(WastedMaterial::className(), ['material_usage_id' => 'id']);
    }
}

<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "material".
 *
 * @property integer $id
 * @property string $code
 * @property integer $safety_stock
 *
 * @property Stock $id0
 * @property MaterialAcceptedDetail[] $materialAcceptedDetails
 * @property MaterialAccepted[] $materialAccepteds
 * @property MaterialUsageDetail[] $materialUsageDetails
 * @property MaterialUsage[] $materialUsages
 * @property Product[] $products
 * @property RequestedMaterialDetail[] $requestedMaterialDetails
 * @property RequestedMaterial[] $requestedMaterials
 * @property ReservedMaterialDetail[] $reservedMaterialDetails
 * @property ReservedMaterial[] $reservedMaterials
 * @property Stock $stock
 * @property WastedMaterialDetail[] $wastedMaterialDetails
 * @property WastedMaterial[] $wastedMaterials
 */
class Material extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'material';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['code', 'safety_stock'], 'required'],
            [['safety_stock'], 'integer'],
            [['code'], 'string', 'max' => 255],
            [['code'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'code' => 'Code',
            'safety_stock' => 'Safety Stock',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStock()
    {
        return $this->hasOne(Stock::className(), ['material_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMaterialAcceptedDetails()
    {
        return $this->hasMany(MaterialAcceptedDetail::className(), ['material_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMaterialAccepteds()
    {
        return $this->hasMany(MaterialAccepted::className(), ['id' => 'material_accepted_id'])->viaTable('material_accepted_detail', ['material_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMaterialUsageDetails()
    {
        return $this->hasMany(MaterialUsageDetail::className(), ['material_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMaterialUsages()
    {
        return $this->hasMany(MaterialUsage::className(), ['id' => 'material_usage_id'])->viaTable('material_usage_detail', ['material_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProducts()
    {
        return $this->hasMany(Product::className(), ['material_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRequestedMaterialDetails()
    {
        return $this->hasMany(RequestedMaterialDetail::className(), ['material_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRequestedMaterials()
    {
        return $this->hasMany(RequestedMaterial::className(), ['id' => 'requested_material_id'])->viaTable('requested_material_detail', ['material_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReservedMaterialDetails()
    {
        return $this->hasMany(ReservedMaterialDetail::className(), ['material_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReservedMaterials()
    {
        return $this->hasMany(ReservedMaterial::className(), ['id' => 'reserved_material_id'])->viaTable('reserved_material_detail', ['material_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getWastedMaterialDetails()
    {
        return $this->hasMany(WastedMaterialDetail::className(), ['material_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getWastedMaterials()
    {
        return $this->hasMany(WastedMaterial::className(), ['id' => 'wasted_material_id'])->viaTable('wasted_material_detail', ['material_id' => 'id']);
    }
}

<?php

namespace common\models;

use frontend\controllers\ExpenditureController;
use Yii;
use yii\db\ActiveRecord;

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
 * @property MaterialExpenditureDetail[] $materialUsageDetails
 * @property MaterialExpenditure[] $materialUsages
 * @property Product[] $products
 * @property RequestedMaterialDetail[] $requestedMaterialDetails
 * @property RequestedMaterial[] $requestedMaterials
 * @property ReservedMaterialDetail[] $reservedMaterialDetails
 * @property ReservedMaterial[] $reservedMaterials
 * @property Stock $stock
 * @property WastedMaterialDetail[] $wastedMaterialDetails
 * @property WastedMaterial[] $wastedMaterials
 */
class Material extends ActiveRecord
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
    public function getMaterialExpenditureDetails()
    {
        return $this->hasMany(MaterialExpenditureDetail::className(), ['material_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMaterialExpenditures()
    {
        return $this->hasMany(MaterialExpenditure::className(), ['id' => 'material_expenditure_id'])->viaTable('material_expenditure_detail', ['material_id' => 'id']);
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
    
    public static function getTouchROP() {
        $material = Material::find()->all();
        $ids = array();
        
        foreach ($material as $m) {
            $rop = ExpenditureController::getReOrderPoint($m->id);
            if ($m->stock->qty <= $rop) {
                array_push($ids, $m->id);
            }
        }

        return Material::find()->where(['id' => $ids])->all();
    }
}

<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "wasted_material".
 *
 * @property integer $id
 * @property integer $material_usage_id
 * @property integer $created_at
 *
 * @property MaterialUsage[] $materialUsages
 * @property MaterialUsage $materialUsage
 * @property WastedMaterialDetail[] $wastedMaterialDetails
 * @property Material[] $materials
 */
class WastedMaterial extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'wasted_material';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['material_usage_id', 'created_at'], 'required'],
            [['material_usage_id', 'created_at'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'material_usage_id' => 'Material Usage ID',
            'created_at' => 'Created At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMaterialUsages()
    {
        return $this->hasMany(MaterialUsage::className(), ['wasted_material_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMaterialUsage()
    {
        return $this->hasOne(MaterialUsage::className(), ['id' => 'material_usage_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getWastedMaterialDetails()
    {
        return $this->hasMany(WastedMaterialDetail::className(), ['wasted_material_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMaterials()
    {
        return $this->hasMany(Material::className(), ['id' => 'material_id'])->viaTable('wasted_material_detail', ['wasted_material_id' => 'id']);
    }
}

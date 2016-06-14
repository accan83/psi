<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "wasted_material".
 *
 * @property integer $id
 * @property integer $material_usage_id
 * @property integer $created_at
 *
 * @property MaterialExpenditure[] $materialUsages
 * @property MaterialExpenditure $materialUsage
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
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => 'created_at',
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['material_expenditure_id'], 'required'],
            [['material_expenditure_id'], 'integer']
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
        return $this->hasMany(MaterialExpenditure::className(), ['wasted_material_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMaterialUsage()
    {
        return $this->hasOne(MaterialExpenditure::className(), ['id' => 'material_usage_id']);
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

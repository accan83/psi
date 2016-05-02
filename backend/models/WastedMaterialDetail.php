<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "wasted_material_detail".
 *
 * @property integer $wasted_material_id
 * @property integer $material_id
 * @property integer $qty
 *
 * @property Material $material
 * @property WastedMaterial $wastedMaterial
 */
class WastedMaterialDetail extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'wasted_material_detail';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['wasted_material_id', 'material_id', 'qty'], 'required'],
            [['wasted_material_id', 'material_id', 'qty'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'wasted_material_id' => 'Wasted Material ID',
            'material_id' => 'Material ID',
            'qty' => 'Qty',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMaterial()
    {
        return $this->hasOne(Material::className(), ['id' => 'material_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getWastedMaterial()
    {
        return $this->hasOne(WastedMaterial::className(), ['id' => 'wasted_material_id']);
    }
}

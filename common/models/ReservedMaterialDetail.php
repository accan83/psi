<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "reserved_material_detail".
 *
 * @property integer $reserved_material_id
 * @property integer $material_id
 * @property integer $qty
 *
 * @property Material $material
 * @property ReservedMaterial $reservedMaterial
 */
class ReservedMaterialDetail extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'reserved_material_detail';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['material_id', 'qty'], 'required'],
            [['reserved_material_id', 'material_id', 'qty'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'reserved_material_id' => 'Reserved Material ID',
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
    public function getReservedMaterial()
    {
        return $this->hasOne(ReservedMaterial::className(), ['id' => 'reserved_material_id']);
    }
}

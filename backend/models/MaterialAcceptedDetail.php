<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "material_accepted_detail".
 *
 * @property integer $material_accepted_id
 * @property integer $material_id
 * @property integer $qty
 * @property integer $price
 *
 * @property MaterialAccepted $materialAccepted
 * @property Material $material
 */
class MaterialAcceptedDetail extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'material_accepted_detail';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['material_accepted_id', 'material_id', 'qty', 'price'], 'required'],
            [['material_accepted_id', 'material_id', 'qty', 'price'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'material_accepted_id' => 'Material Accepted ID',
            'material_id' => 'Material ID',
            'qty' => 'Qty',
            'price' => 'Price',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMaterialAccepted()
    {
        return $this->hasOne(MaterialAccepted::className(), ['id' => 'material_accepted_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMaterial()
    {
        return $this->hasOne(Material::className(), ['id' => 'material_id']);
    }
}

<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "material_usage_detail".
 *
 * @property integer $material_usage_id
 * @property integer $material_id
 * @property integer $qty
 *
 * @property Material $material
 * @property MaterialUsage $materialUsage
 */
class MaterialUsageDetail extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'material_usage_detail';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['material_usage_id', 'material_id', 'qty'], 'required'],
            [['material_usage_id', 'material_id', 'qty'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'material_usage_id' => 'Material Usage ID',
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
    public function getMaterialUsage()
    {
        return $this->hasOne(MaterialUsage::className(), ['id' => 'material_usage_id']);
    }
}

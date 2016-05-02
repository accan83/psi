<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "requested_material_detail".
 *
 * @property integer $requested_material_id
 * @property integer $material_id
 * @property integer $qty
 *
 * @property Material $material
 * @property RequestedMaterial $requestedMaterial
 */
class RequestedMaterialDetail extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'requested_material_detail';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['requested_material_id', 'material_id', 'qty'], 'required'],
            [['requested_material_id', 'material_id', 'qty'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'requested_material_id' => 'Requested Material ID',
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
    public function getRequestedMaterial()
    {
        return $this->hasOne(RequestedMaterial::className(), ['id' => 'requested_material_id']);
    }
}

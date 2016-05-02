<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "stock".
 *
 * @property integer $material_id
 * @property integer $qty
 *
 * @property Material $material
 * @property Material $material0
 */
class Stock extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'stock';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['qty'], 'required'],
            [['qty'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
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
    public function getMaterial0()
    {
        return $this->hasOne(Material::className(), ['id' => 'material_id']);
    }
}

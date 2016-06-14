<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "material_expenditure_detail".
 *
 * @property integer $material_expenditure_id
 * @property integer $material_id
 * @property integer $qty
 *
 * @property Material $material
 * @property MaterialExpenditure $materialExpenditure
 */
class MaterialExpenditureDetail extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'material_expenditure_detail';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['material_expenditure_id', 'material_id', 'qty'], 'required'],
            [['material_expenditure_id', 'material_id', 'qty'], 'integer']
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
    public function getMaterialExpenditure()
    {
        return $this->hasOne(MaterialExpenditure::className(), ['id' => 'material_expenditure_id']);
    }
}

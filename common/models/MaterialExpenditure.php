<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "material_expenditure".
 *
 * @property integer $id
 * @property integer $order_id
 * @property integer $created_at
 *
 * @property Order $order
 * @property WastedMaterial $wastedMaterial
 * @property MaterialExpenditureDetail[] $materialUsageDetails
 * @property Material[] $materials
 * @property WastedMaterial[] $wastedMaterials
 */
class MaterialExpenditure extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'material_expenditure';
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
            [['order_id'], 'required'],
            [['order_id'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'order_id' => 'Order ID',
            'created_at' => 'Created At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrder()
    {
        return $this->hasOne(Order::className(), ['id' => 'order_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getWastedMaterial()
    {
        return $this->hasOne(WastedMaterial::className(), ['material_expenditure_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMaterialExpenditureDetails()
    {
        return $this->hasMany(MaterialExpenditureDetail::className(), ['material_expenditure_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMaterials()
    {
        return $this->hasMany(Material::className(), ['id' => 'material_id'])->viaTable('material_expenditure_detail', ['material_expenditure_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getWastedMaterials()
    {
        return $this->hasMany(WastedMaterial::className(), ['material_expenditure_id' => 'id']);
    }
}

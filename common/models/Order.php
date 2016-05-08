<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "order".
 *
 * @property integer $id
 * @property string $customer
 * @property integer $created_at
 *
 * @property MaterialUsage[] $materialUsages
 * @property Product[] $products
 * @property RequestedMaterial[] $requestedMaterials
 */
class Order extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'order';
    }

    /**
     * @inheritdoc
     */
     public function behaviors()
     {
         return [
             TimestampBehavior::className(),
         ];
     }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['customer', 'created_at'], 'required'],
            [['customer'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'customer' => 'Customer',
            'created_at' => 'Created At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMaterialUsages()
    {
        return $this->hasMany(MaterialUsage::className(), ['order_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProducts()
    {
        return $this->hasMany(Product::className(), ['order_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRequestedMaterials()
    {
        return $this->hasMany(RequestedMaterial::className(), ['order_id' => 'id']);
    }
}

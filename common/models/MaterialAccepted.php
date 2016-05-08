<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "material_accepted".
 *
 * @property integer $id
 * @property integer $created_at
 *
 * @property MaterialAcceptedDetail[] $materialAcceptedDetails
 * @property Material[] $materials
 */
class MaterialAccepted extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'material_accepted';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['created_at'], 'required'],
            [['created_at'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'created_at' => 'Created At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMaterialAcceptedDetails()
    {
        return $this->hasMany(MaterialAcceptedDetail::className(), ['material_accepted_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMaterials()
    {
        return $this->hasMany(Material::className(), ['id' => 'material_id'])->viaTable('material_accepted_detail', ['material_accepted_id' => 'id']);
    }
}

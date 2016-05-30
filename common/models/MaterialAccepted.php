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
            [['reserved_material_id', 'created_at'], 'required'],
            [['reserved_material_id', 'created_at'], 'integer']
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

    public function getReOrderPoint($material_id)
    {
        $material_accepted_detail = MaterialAcceptedDetail::find()->where(['material_id', $material_id])->all();
        $item_count = 0;
        $leadtime = 0;
        $demand = 0;
        foreach ($material_accepted_detail as $data) {
            $material_accepted = MaterialAccepted::find()->where(['id', $data->material_accepted_id])->one();
            $reserved_material = ReservedMaterial::find()->where(['id', $material_accepted->reserved_material_id])->one();
            $reserved_material_detail = ReservedMaterialDetail::find()->where(['reserved_material_id', $reserved_material->id])->andWhere(['material_id', $material_id])->one();
            $accepted_at = $material_accepted->created_at;
            $reserved_at = $reserved_material->created_at;
            $qty = $reserved_material_detail->qty;

            $leadtime += $accepted_at - $reserved_at;
            $demand += $qty;
            $item_count++;
        }

        $material = Material::find()->where(['id', $material_id])->one();
        $safety_stock = $material->safety_stock;
        $rop = $safety_stock;
        if ($item_count > 0) {
            $leadtime_rate = $leadtime / $item_count;
            $demand_rate = $demand / $item_count;

            $rop = $safety_stock + ($demand_rate * $leadtime_rate);
        }
        return $this->hasOne(ReservedMaterial::className(), ['id' => 'reserved_material_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReservedMaterial()
    {
        return $this->hasOne(ReservedMaterial::className(), ['id' => 'reserved_material_id']);
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

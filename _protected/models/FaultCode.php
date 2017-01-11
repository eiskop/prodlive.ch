<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "fault_code".
 *
 * @property integer $id
 * @property integer $fault_code_group_id
 * @property string $name
 * @property string $description
 * @property integer $created_by
 * @property integer $created_at
 * @property integer $updated_by
 * @property integer $updated_at
 */
class FaultCode extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'fault_code';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['fault_code_group_id', 'name', 'description'], 'required'],
            [['fault_code_group_id', 'created_by', 'created_at', 'updated_by', 'updated_at'], 'integer'],
            [['name', 'description'], 'string', 'max' => 255],
            [['fault_code_group_id'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'fault_code_group_id' => Yii::t('app', 'Fault Code Group ID'),
            'name' => Yii::t('app', 'Name'),
            'description' => Yii::t('app', 'Description'),
            'created_by' => Yii::t('app', 'Created By'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_by' => Yii::t('app', 'Updated By'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }
}

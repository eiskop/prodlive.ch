<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "availability".
 *
 * @property integer $id
 * @property integer $start_time
 * @property integer $end_time
 * @property integer $duration_sec
 * @property integer $fault_code_id
 * @property integer $work_centre_id
 * @property string $comment
 * @property integer $created_at
 * @property integer $created_by
 * @property integer $updated_at
 * @property integer $updated_by
 *
 * @property FaultCode $faultCode
 * @property WorkCentre $workCentre
 * @property User $createdBy
 * @property User $updatedBy
 */
class Availability extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'availability';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['start_time', 'end_time', 'fault_code_id', 'work_centre_id', 'created_at', 'created_by'], 'required'],
            [[ 'duration_sec', 'fault_code_id', 'work_centre_id', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
            [['comment'], 'string', 'max' => 255],
            [['start_time', 'start_time'], 'safe'],
            [['fault_code_id'], 'exist', 'skipOnError' => true, 'targetClass' => FaultCode::className(), 'targetAttribute' => ['fault_code_id' => 'id']],
            [['work_centre_id'], 'exist', 'skipOnError' => true, 'targetClass' => WorkCentre::className(), 'targetAttribute' => ['work_centre_id' => 'id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['created_by' => 'id']],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['updated_by' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'start_time' => Yii::t('app', 'Anfang'),
            'end_time' => Yii::t('app', 'Ende'),
            'duration_sec' => Yii::t('app', 'Dauer Sec'),
            'fault_code_id' => Yii::t('app', 'Störung'),
            'work_centre_id' => Yii::t('app', 'Arbeitsplatz'),
            'comment' => Yii::t('app', 'Kommentar'),
            'created_at' => Yii::t('app', 'Erstellt am'),
            'created_by' => Yii::t('app', 'Erstellt von'),
            'updated_at' => Yii::t('app', 'Geändert am'),
            'updated_by' => Yii::t('app', 'Geändert von'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFaultCode()
    {
        return $this->hasOne(FaultCode::className(), ['id' => 'fault_code_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getWorkCentre()
    {
        return $this->hasOne(WorkCentre::className(), ['id' => 'work_centre_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'created_by']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUpdatedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'updated_by']);
    }
}

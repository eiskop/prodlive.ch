<?php

namespace app\models;

use Yii;
use app\models\FaultCode;
use app\models\FaultCodeGroup;

/**
 * This is the model class for table "availability".
 *
 * @property integer $id
 * @property integer $start_time
 * @property integer $end_time
 * @property integer $duration_sec
 * @property integer $fault_code_id
 * @property integer $work_centre_id
 * @property integer $created_at
 * @property integer $created_by
 * @property integer $updated_at
 * @property integer $updated_by
 *
 * @property User $updatedBy
 * @property FaultCode $faultCode
 * @property WorkCentre $workCentre
 * @property User $createdBy
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
            [['start_time', 'end_time', 'fault_code_id'], 'required',  'message'=>'{attribute} muss ausgewählt werden'],
            [['fault_code_id'], 'integer'],
            [['start_time', 'end_time', 'work_centre_id', 'created_at', 'created_by', 'updated_at', 'updated_by', 'duration_sec'], 'safe'],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['updated_by' => 'id']],
            [['fault_code_id'], 'exist', 'skipOnError' => true, 'targetClass' => FaultCode::className(), 'targetAttribute' => ['fault_code_id' => 'id']],
            [['work_centre_id'], 'exist', 'skipOnError' => true, 'targetClass' => WorkCentre::className(), 'targetAttribute' => ['work_centre_id' => 'id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['created_by' => 'id']],
            ['end_time','compare','compareAttribute'=>'start_time','operator'=>'>=', 'message'=>'Anfang muss bevor Ende sein'],
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
            'duration_sec' => Yii::t('app', 'Dauer in Sekunden'),
            'fault_code_id' => Yii::t('app', 'Störung'),
            'work_centre_id' => Yii::t('app', 'Arbeitsplatz'),
            'created_at' => Yii::t('app', 'Erstellt am'),
            'created_by' => Yii::t('app', 'Erstellt von'),
            'updated_at' => Yii::t('app', 'Geändert am'),
            'updated_by' => Yii::t('app', 'Geändert von'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUpdatedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'updated_by']);
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
    public function getFaultCodeGroup()
    {
        $fault_code_group_id =  $this->hasOne(FaultCode::className(), ['id' => 'fault_code_id'])->fault_code_group_id;
        return $this->hasOne(FaultCodeGroup::className(), ['id' => $fault_code_group_id]);
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

}

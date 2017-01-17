<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use app\models\Availability;
use app\models\AvailabilitySearch;
use app\models\FaultCode;
use app\models\FaultCodeGroup;
use app\models\WorkCentre;
use yii\widgets\ActiveForm;
use kartik\datecontrol\Module;
use kartik\datecontrol\DateControl;
use kartik\time\TimePicker;
use yii\grid\GridView;
use yii\widgets\Pjax;


/* @var $this yii\web\View */
/* @var $model app\models\Availability */
/* @var $form yii\widgets\ActiveForm */
/* @var $searchModel backend\models\OfferSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$searchModel = new AvailabilitySearch();
$dataProvider = $searchModel->search(Yii::$app->request->queryParams);
$dataProvider->query->where(['availability.work_centre_id' => Yii::$app->user->identity->work_centre_id])->andWhere(['DATE( FROM_UNIXTIME( start_time ) )' => date('Y-m-d', time())])->orderBy(['id'=>SORT_DESC]);
$dataProvider->sort->sortParam = false;
$connection = Yii::$app->getDb();
$command = $connection->createCommand('
    SELECT SUM( duration_sec ) AS duration_sec
    FROM  `availability` 
    WHERE  `start_time` 
    BETWEEN "'.strtotime(date('Y-m-d', time())).'" 
    AND "'.strtotime(date('Y-m-d', time()).' 23:59:59').'" AND DATE( FROM_UNIXTIME( start_time ) ) = DATE(NOW())
    GROUP BY DATE( FROM_UNIXTIME( start_time ) )');

$res = $command->queryAll();
$total_standstill_sec = 0;
if ($res != FALSE) {
    $total_standstill_sec = $res[0]['duration_sec'];    
}


?>


<div class="availability-form">
    <?php $form = ActiveForm::begin(); ?>
    <div class="table">
        <div class="row">
            <div class="col-md-2" style="margin-bottom:1vh;">

                <?php 
                    if ($_GET['r'] == 'availability/create') {
                        echo Html::a(Yii::t('app', 'Zeit<br>erneuern'), ['availability/create'], ['class' => 'btn btn-success btn', 'style'=>'font-size: 1.9em;']);
                    }
                    
                ?>

            </div>
            <div class="col-md-2">
               <?= $form->field($model, 'start_time')->widget(TimePicker::className(),  
                     [
                        'readonly' => false,                     
                        'pluginOptions' => [
                                'minuteStep' => 5,
                                'showMeridian' => false,
                                'defaultTime' => date('H:i', time()),
                        ],
                        'options'=>[
                            'class'=>'form-control',
                            'style'=> 'height: 7vh; font-size:2em;',                            
                        ],
                ]); ?>
            </div>    
            <div class="col-md-2">
                <?= $form->field($model, 'end_time')->widget(TimePicker::className(),  
                     [
                        'readonly' => false,                   
                        'pluginOptions' => [
                                'minuteStep' => 1,
                                'showMeridian' => false,
                                'defaultTime' => date('H:i', time()),
                        ],
                        'options'=>[
                            'class'=>'form-control',
                            'style'=> 'height: 7vh; font-size:2em;',
                        ],
                ]); ?>
            </div>
            <div class="col-md-4">    
                <?= $form->field($model, 'fault_code_id')->dropDownList(ArrayHelper::map(FaultCode::find()->where(['work_centre_id'=>Yii::$app->user->identity->work_centre_id])->orderBy(['name' => SORT_ASC])->all(), 'id', 'name'), [
                    'prompt'=>' -> Auswählen <- ',
                    'style'=> 'height: 7vh; font-size:2em;',
                    'onchange'=>'
                    $.post("index.php?r=user/index&id='.'"+$(this).val(), function (data) {
                        $("select#fault-code-id").html(data);
                    });'

                ]) ?>  
            </div>
                <div class="col-md-2 v-col">
                    <div class="form-group" style="vetrtical-align: bottom;">
                        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Melden') : Yii::t('app', 'Ändern'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary btn-lg', 'style'=>'font-size: 3.5em;']) ?>
                    </div>
                </div>             
        </div>
        <div class="row">
            <div class="col-md-10">

                    <?php

                        if ($_GET['r'] == 'availability/create') {
                            echo '<h3>Störungen heute: '.round($total_standstill_sec/60).' min</h3><p>';

                            Pjax::begin();
                            echo GridView::widget(

                                [
                                    'dataProvider' => $dataProvider,
                                  //  'filterModel' => $searchModel,
                                    'formatter' => [
                                           'class' => 'yii\i18n\Formatter',
                                           'dateFormat' => 'php:d.m.Y',
                                           'datetimeFormat' => 'php:d.m.Y H:i:s',
                                           'timeFormat' => 'H:i', 
                                    ],        
                                    'columns' => [
                                        ['class' => 'yii\grid\SerialColumn'],

                                        'id',
                                        [
                                            'attribute'=>'fault_code_id',
                                            'value'=>'faultCode.name',
                                        ],
                                        [
                                            'attribute'=>'start_time',
                                            'value' => 'start_time',
                                            'format' => 'time',
                                            'contentOptions' => ['style' => 'text-align: right;'],
                                        ],
                                        [
                                            'attribute'=>'end_time',
                                            'value' => 'end_time',
                                            'format' => 'time',
                                            'contentOptions' => ['style' => 'text-align: right;'],
                                        ],
                                        [
                                            'attribute'=>'duration_sec',
                                            'label' => 'Dauer Min',
                                            'filter' => false,
                                            'value'=>function($data) {
                                                return round($data->duration_sec/60);
                                            },
                                            'contentOptions' => ['style' => 'text-align: right;'],
                                        ],   
                                        [
                                            'attribute'=>'created_at',
                                            'value' => 'created_at',
                                            'format' => ['date', 'php: H:i:s'],
                                            'contentOptions' => ['style' => 'text-align: right;'],
                                        ],
                                        [
                                            'attribute'=>'created_by',
                                            'value'=>'createdBy.username',
                                        ],
                                        [
                                            'class' => 'yii\grid\ActionColumn'
                                        ],
                                    ],
                                ]);
                            Pjax::end();


                        }
                    ?>



            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <?php
                     //$list = ArrayHelper::map(FaultCode::find()->orderBy(['name' => SORT_ASC])->all(), 'id', 'name');
                     //echo $form->field($model, 'fault_code_id')->radioList($list); 
                    ?>                
                </div>
            </div> 
        </div>
    </div>
  





    <?php ActiveForm::end(); ?>

</div>

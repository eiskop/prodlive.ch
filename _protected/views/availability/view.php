<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Availability */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Störungen'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="availability-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>

            
    
        <?= Html::a(Yii::t('app', 'Störung melden'), ['availability/create'], ['class' => 'btn btn-success btn']) ?>
        <?= Html::a(Yii::t('app', 'Ändern'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Löschen'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'formatter' => [
               'class' => 'yii\i18n\Formatter',
               'dateFormat' => 'php:d.m.Y',
               'datetimeFormat' => 'php:d.m.Y H:i:s',
               'timeFormat' => 'H:i:s', 
        ],   
        'attributes' => [
            'id',
            'start_time:datetime',
            'end_time:datetime',
            'duration_sec',
            'fault_code_id',
            'work_centre_id',
            'created_at:datetime',
            'created_by',
            'updated_at:datetime',
            'updated_by',
        ],
    ]) ?>

</div>

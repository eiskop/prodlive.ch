<?php

use app\rbac\models\AuthItem;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\AvailabilitySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Störungen');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="availability-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Störung melden'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

        <?php foreach (AuthItem::getRoles() as $item_name): ?>
            <?php $roles[$item_name->name] = $item_name->name ?>
        <?php endforeach   ?>
        
<?php
    
  //  echo '<pre>', var_dump(Yii::$app->user->can('admin'));
?>

<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'formatter' => [
               'class' => 'yii\i18n\Formatter',
               'dateFormat' => 'php:d.m.Y',
               'datetimeFormat' => 'php:d.m.Y H:i:s',
               'timeFormat' => 'H:i:s', 
        ],        
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            [
                'attribute'=>'work_centre_id',
                'value'=>'workCentre.name',
            ],
            [
                'attribute'=>'fault_code_id',
                'value'=>'faultCode.name',
            ],
            'start_time:datetime',
            'end_time:datetime',
      //      'duration_sec',
            [
                'attribute'=>'duration_sec',
                'label' => 'Dauer Min',
                'filter' => false,
                'value'=>function($data) {
                    return round($data->duration_sec/60);
                },
                'contentOptions' => ['style' => 'text-align: right;'],                
            ],
            'created_at:datetime',
            [
                'attribute'=>'created_by',
                'value'=>'createdBy.username',
            ],
            'updated_at:datetime',
            [
                'attribute'=>'updated_by',
                'value'=>'updatedBy.username',
            ],
            [
            'class' => 'yii\grid\ActionColumn',
            'header' => "Menu",
            'contentOptions' => ['style' => 'width:50px;'],
            'template' => '{view} {update} {delete}',
                'buttons' => [
                    'view' => function ($url, $model, $key) {
                        return Html::a('', $url, ['title'=>'View', 'class'=>'glyphicon glyphicon-eye-open']);
                    },
                    'update' => function ($url, $model, $key) {
                       // if (Yii::$app->user->can('availability-update')) {
                            return Html::a('', $url, ['title'=>'Update', 'class'=>'glyphicon glyphicon-pencil']);    
                        //}
                        
                    },
                    'delete' => function ($url, $model, $key) {
                        //if (Yii::$app->user->can('availability-delete')) {
                            return Html::a('', $url, 
                            ['title'=>'Delete', 
                                'class'=>'glyphicon glyphicon-trash',
                                'data' => [
                                    'confirm' => Yii::t('app', 'Bist du sicher dass du diesen Störung löschen willst?'),
                                    'method' => 'post']
                            ]);
                        //}
                    }
                ]

            ], // ActionColumn

        ],
    ]); ?>
<?php Pjax::end(); ?></div>

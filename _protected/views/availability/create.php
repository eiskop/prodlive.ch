<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use app\models\WorkCentre;


/* @var $this yii\web\View */
/* @var $model app\models\Availability */

$wc = ArrayHelper::map(WorkCentre::find()->all(), 'id', 'name');

$this->title = $wc[Yii::$app->user->identity->work_centre_id].' '.Yii::t('app', 'Störung melden');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Störungen'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title
?>
<div class="availability-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

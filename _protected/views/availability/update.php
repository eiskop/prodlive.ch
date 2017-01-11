<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Availability */

$this->title = Yii::t('app', 'Störung ändern');

$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Störungen'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Störung ändern');
?>
<div class="availability-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

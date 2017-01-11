<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\WorkCentre */

$this->title = Yii::t('app', 'Create Work Centre');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Work Centres'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="work-centre-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

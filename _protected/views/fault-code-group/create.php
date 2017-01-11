<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\FaultCodeGroup */

$this->title = Yii::t('app', 'Create Fault Code Group');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Fault Code Groups'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="fault-code-group-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

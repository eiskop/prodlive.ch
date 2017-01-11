<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\FaultCode */

$this->title = Yii::t('app', 'Create Fault Code');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Fault Codes'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="fault-code-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

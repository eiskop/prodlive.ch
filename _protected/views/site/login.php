<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \app\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = Yii::t('app', 'Login');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="col-md-5 well bs-component">

        <p><?= Yii::t('app', 'Bitte die folgenden Felder befüllen:') ?></p>

        <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>

        <?php //-- use email or username field depending on model scenario --// ?>
        <?php if ($model->scenario === 'lwe'): ?>

            <?= $form->field($model, 'email')->input('email', 
                ['placeholder' => Yii::t('app', 'Bitte geben Sie ihren E-mail an'), 'autofocus' => true]) ?>

        <?php else: ?>

            <?= $form->field($model, 'username')->textInput(
                ['placeholder' => Yii::t('app', 'Bitte geben Sie ihren Benutzernamen an'), 'autofocus' => true])->label(Yii::t('app', 'Benutzername'), ['class'=>'label-class']) ?>

        <?php endif ?>

        <?= $form->field($model, 'password')->passwordInput(['placeholder' => Yii::t('app', 'Bitte geben Sie ihren Kennwort an')])->label(Yii::t('app', 'Kennwort'), ['class'=>'label-class'])  ?>

        <?= $form->field($model, 'rememberMe')->checkbox()->label(Yii::t('app', 'Daten speichern'), ['class'=>'label-class']) ?>

        <div style="color:#999;margin:1em 0">
            <?= Yii::t('app', 'Hast du dein Kennwort vergessen?') ?>
            <?= Html::a(Yii::t('app', 'reset it'), ['site/request-password-reset']) ?>.
        </div>

        <div class="form-group">
            <?= Html::submitButton(Yii::t('app', 'Login'), ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>
  
</div>

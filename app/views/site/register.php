<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\widgets\MaskedInput;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\RegistrationForm */

$this->title = 'Register';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-register">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Please fill out the following fields to signup:</p>

    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'form-register']); ?>
            <?= $form->field($model, 'OIB')->widget(MaskedInput::className(), [
                'mask' => '99999999999',
                'options' => ['size' => 11, 'class' => 'form-control'],
            ]);
            ?>
            <?= $form->field($model, 'firstName') ?>
            <?= $form->field($model, 'lastName') ?>
            <?= $form->field($model, 'email') ?>


            <?= $form->field($model, 'phone')->widget(MaskedInput::className(), [
                'mask' => '999/999-9999',
                'options' => ['size' => 14, 'class' => 'form-control'],
            ]);
            ?>

            <?= $form->field($model, 'creditCardNumber')->widget(MaskedInput::className(), [
                'mask' => '9999 9999 9999 9999',
                'options' => ['size' => 19, 'class' => 'form-control'], // 16 numbers + 3 ' '
            ]);
            ?>

            <?= $form->field($model, 'username') ?>
            <?= $form->field($model, 'password')->passwordInput() ?>
            <div class="form-group">
                <?= Html::submitButton('Register', ['class' => 'btn btn-primary', 'name' => 'register-button']) ?>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>

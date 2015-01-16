<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\datetimepicker\DateTimePicker;

/* @var $this yii\web\View */
/* @var $model app\models\Reservation */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="reservation-form col-md-3">

    <?php $form = ActiveForm::begin(); ?>

    <?php if ($model->type == \app\models\Reservation::TYPE_INSTANT): ?>
        <?= $this->render('_instant', [
            'model' => $model,
        ]) ?>
    <?php elseif($model->type == \app\models\Reservation::TYPE_PERIODIC): ?>
        <?= $this->render('_periodic', [
            'model' => $model,
        ]) ?>
    <?php else: ?>
        <?= $this->render('_periodic', [
            'model' => $model,
        ]) ?>
    <?php endif; ?>


    <?= $form->field($model, 'start')->widget(DateTimePicker::className(), [
        'language' => 'hr',
        'size' => 'ms',
        'inline' => true,
        'clientOptions' => [
            'autoclose' => true,
            'format' => 'dd MM yyyy - HH:00',
            'todayBtn' => true
        ]
    ]);?>

    <?= $form->field($model, 'end')->widget(DateTimePicker::className(), [
        'language' => 'hr',
        'size' => 'ms',
        'inline' => true,
        'clientOptions' => [
            'autoclose' => true,
            'format' => 'dd MM yyyy - HH',
            'todayBtn' => true
        ]
    ]);?>

    <?= $form->field($model, 'duration')->textInput()->label('Koliko dana?') ?>

    <?= $form->field($model, 'period')->textInput()->label('Koliko često?') ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

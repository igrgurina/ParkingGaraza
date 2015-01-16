<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use trntv\yii\datetimepicker\DatetimepickerWidget;
use kartik\daterange\DateRangePicker;

/* @var $this yii\web\View */
/* @var $model app\models\Reservation */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="reservation-form col-md-4">

    <?php $form = ActiveForm::begin(); ?>

    <?php if ($model->type == \app\models\Reservation::TYPE_INSTANT): ?>
        <?= $form->field($model, 'termin')->widget(DateRangePicker::className(), [
            'convertFormat'=>true,
            'pluginOptions'=>[
                'timePicker'=>true,
                'timePickerIncrement'=>60,
                'format'=>'d.m.Y H:i'
            ]
        ]) ?>

    <?php elseif($model->type == \app\models\Reservation::TYPE_PERMANENT): ?>
            <?= $form->field($model, 'start')->widget(DatetimepickerWidget::className(), [
                'clientOptions' => [
                    'language' => 'hr',
                    'useMinutes' => false,              // disables the minutes picker
                    'useSeconds' => false,              // disables the seconds picker
                    //'defaultDate' => (new DateTime())->add(new DateInterval('PT6H0M0S')),
                    //'useCurrent' => true,
                    'sideBySide' => true,               //show the date and time picker side by side
                    'format'=>'DD.MM.YYYY HH:00'
                ],
            ])->label('Odaberite vrijeme početka vaše trajne rezervacije'); ?>
    <?php else: ?>
        <?= $form->field($model, 'start')->widget(DatetimepickerWidget::className(), [
            'clientOptions' => [
                'language' => 'hr',
                'useMinutes' => false,              // disables the minutes picker
                'useSeconds' => false,              // disables the seconds picker
                //'defaultDate' => (new DateTime())->add(new DateInterval('PT6H0S')),
                //'useCurrent' => true,
                'sideBySide' => true,               //show the date and time picker side by side
            ],
        ]); ?>

        <?= $form->field($model, 'end')->widget(DatetimepickerWidget::className(), [
            'clientOptions' => [
                'language' => 'hr',
                'useMinutes' => false,              // disables the minutes picker
                'useSeconds' => false,              // disables the seconds picker
                'defaultDate' => (new DateTime())->add(new DateInterval('PT7H0S')),
                //'useCurrent' => true,
                'sideBySide' => true,               //show the date and time picker side by side
            ],
        ]); ?>

        <?= $form->field($model, 'duration')->textInput()->label('Koliko dana?') ?>

        <?= $form->field($model, 'period')->textInput()->label('Koliko često?') ?>

    <?php endif; ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use trntv\yii\datetimepicker\DatetimepickerWidget;

/* @var $this yii\web\View */
/* @var $model app\models\Reservation */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="reservation-form col-md-3">

    <?php $form = ActiveForm::begin(); ?>

    <?php if ($model->type == \app\models\Reservation::TYPE_INSTANT): ?>
        <?= $form->field($model, 'start')->widget(DatetimepickerWidget::className(), [
            'clientOptions' => [
                'language' => 'hr',
                'useMinutes' => false,              // disables the minutes picker
                'useSeconds' => false,              // disables the seconds picker
                'defaultDate' => (new DateTime())->add(new DateInterval('PT6H0S')),
                //'useCurrent' => true,
                'sideBySide' => true,               //show the date and time picker side by side
            ],
        ]); ?>

        <?= $form->field($model, 'end')->widget(DatetimepickerWidget::className(), [
            'clientOptions' => [
                'language' => 'hr',
                'useMinutes' => false,              // disables the minutes picker
                'useSeconds' => false,              // disables the seconds picker
                //'useCurrent' => true,
                'sideBySide' => true,               //show the date and time picker side by side
                'pickDate' => false,
                'defaultDate' => $model->start
            ],
        ]); ?>
    <?php elseif($model->type == \app\models\Reservation::TYPE_PERMANENT): ?>
        <div class="alert alert-info">
            Odaberite vrijeme početka vaše trajne rezervacije
            <?= $form->field($model, 'start')->widget(DatetimepickerWidget::className(), [
                'clientOptions' => [
                    'language' => 'hr',
                    'useMinutes' => false,              // disables the minutes picker
                    'useSeconds' => false,              // disables the seconds picker
                    'defaultDate' => (new DateTime())->add(new DateInterval('PT6H0M0S')),
                    //'useCurrent' => true,
                    'sideBySide' => true,               //show the date and time picker side by side
                ],
            ]); ?>
        </div>
    <?php else: ?>
        <?= $this->render('_periodic', [
            'model' => $model,
        ]) ?>
        <?= $form->field($model, 'duration')->textInput()->label('Koliko dana?') ?>

        <?= $form->field($model, 'period')->textInput()->label('Koliko često?') ?>

    <?php endif; ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

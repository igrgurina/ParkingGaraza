<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\datetimepicker\DateTimePicker;

/* @var $this yii\web\View */
/* @var $model app\models\Reservation */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="reservation-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'type')->dropDownList([ 'instant' => 'Jednokratna', 'recurring' => 'Ponavljajuća', 'permanent' => 'Trajna', ], ['prompt' => '']) ?>


    <?= $form->field($model, 'start')->widget(DateTimePicker::className(), [
        'language' => 'hr',
        'size' => 'ms',
        'inline' => true,
        'clientOptions' => [
            'autoclose' => true,
            'format' => 'dd MM yyyy - HH',
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



    <?= $form->field($model, 'duration')->textInput() ?>

    <?= $form->field($model, 'period')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

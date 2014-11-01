<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ParkingSpot */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="parking-spot-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'parking_id')->textInput() ?>

    <?= $form->field($model, 'sensor')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

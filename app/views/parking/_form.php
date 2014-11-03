<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kolyunya\yii2\widgets\MapInputWidget;

/* @var $this yii\web\View */
/* @var $model app\models\Parking */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="parking-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'locationId')->textInput() ?>

    <?= $form->field($model, 'type')->dropDownList([ 'garage' => 'Garage', 'outdoor' => 'Outdoor', ], ['prompt' => '']) ?>

    <?= $form->field($model, 'numberOfParkingSpots')->textInput() ?>

    <?= $form->field($model, 'companyId')->textInput() ?>

    <?= $form->field($model, 'cost')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

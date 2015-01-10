<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Parking */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="parking-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'location_id')->textInput() ?>

    <?= $form->field($model, 'type')->dropDownList([ 'garage' => 'Garage', 'outdoor' => 'Outdoor', ], ['prompt' => '']) ?>

    <?= $form->field($model, 'number_of_parking_spots')->textInput() ?>

    <?= $form->field($model, 'company_id')->textInput() ?>

    <?= $form->field($model, 'status')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

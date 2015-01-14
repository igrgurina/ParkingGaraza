<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Parking */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="parking-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model,'coordinates')->widget(
            'kolyunya\yii2\widgets\MapInputWidget',
            [
                // Google maps browser key.
                'key' => 'AIzaSyA28SKAZ3pUuY8W_mtucw_4Rt7JvvZM0mM',
                'latitude' => $model->isNewRecord ? 45.8167 : $model->location->lat,

                // Initial map center longitude. Used only when the input has no value.
                // Otherwise the input value longitude will be used as map center.
                // Defaults to 0.
                'longitude' => $model->isNewRecord ? 15.9833 : $model->location->lng,

                // Initial map zoom.
                // Defaults to 0.
                'zoom' => 12,
                'pattern' => '%latitude%,%longitude%'
            ]
        )
    ?>

    <?= $form->field($model, 'type')->dropDownList([ 'garage' => 'Garage', 'outdoor' => 'Outdoor', ], ['prompt' => '']) ?>

    <?= $form->field($model, 'number_of_parking_spots')->textInput() ?>

    <?=
        // ako je update, tada omogući promjenu statusa, inače je pri kreiranju defaultno STATUS_OPEN
        $model->isNewRecord ? '' : $form->field($model, 'status')->textInput()
    ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

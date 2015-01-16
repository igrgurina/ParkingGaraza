<?php

/*
 * This file is part of the Dektrium project.
 *
 * (c) Dektrium project <http://github.com/dektrium>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

use yii\helpers\Html;
use yii\widgets\ActiveForm;
/**
 * @var yii\web\View $this
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="panel panel-default panel-danger">
    <div class="panel-heading">
        Deaktiviraj vlastiti korisnički račun
    </div>
    <div class="panel-body">
        <div class="deactivate-form">

            <?php $form = ActiveForm::begin(); ?>

            <div class="form-group">
                <?= Html::submitButton('Deaktiviraj', ['class' => 'btn btn-danger']) ?>
            </div>

            <?php ActiveForm::end(); ?>

        </div>


    </div>
</div>
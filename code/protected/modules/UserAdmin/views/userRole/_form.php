<div class='form form-horizontal well well-small'>

<?php $form = $this->beginWidget('CActiveForm', array(
        'enableClientValidation'=>true,
        'clientOptions'=>array(
                'validateOnSubmit'=>true,
                'validateOnChange'=>false,
        ),
)); ?>

        <div class='control-group'>
                <?php echo $form->labelEx($model, 'name', array('class'=>'control-label')); ?>
                <div class='controls'>
                        <?php echo $form->textField($model, 'name', array('class'=>'input-xxlarge')); ?>
                        <?php echo $form->error($model, 'name'); ?>
                </div>
        </div>

        <div class='control-group'>
                <?php echo $form->labelEx($model, 'code', array('class'=>'control-label')); ?>
                <div class='controls'>
                        <?php echo $form->textField($model, 'code', array('class'=>'input-xxlarge')); ?>
                        <?php echo $form->error($model, 'code'); ?>
                </div>
        </div>

        <div class='control-group'>
                <?php echo $form->labelEx($model, 'home_page', array('class'=>'control-label')); ?>
                <div class='controls'>
                        <?php echo $form->textField($model, 'home_page', array('class'=>'input-xxlarge')); ?>
                        <?php echo $form->error($model, 'home_page'); ?>
                </div>
        </div>

        <div class='control-group'>
                <?php echo $form->labelEx($model, 'description', array('class'=>'control-label')); ?>
                <div class='controls'>
                        <?php echo $form->textArea($model, 'description', array('class'=>'input-xxlarge', 'rows'=>5)); ?>
                        <?php echo $form->error($model, 'description'); ?>
                </div>
        </div>

        <br>
        <?php echo CHtml::htmlButton(
                $model->isNewRecord ? 
                '<i class="icon-plus-sign icon-white"></i> '.Yii::t("UserAdminModule.admin","Create") : 
                '<i class="icon-ok icon-white"></i> '.Yii::t("UserAdminModule.admin","Save"), 
                array(
                        'class'=>'btn btn-info controls',
                        'type'=>'submit',
                )
        ); ?>

<?php $this->endWidget(); ?>

</div>

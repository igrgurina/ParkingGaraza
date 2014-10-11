
<h2>
        <?php echo Yii::t("UserAdminModule.admin","User role details"); ?>
        <?php echo CHtml::link(
                Yii::t("UserAdminModule.admin", "Manage"),
                array("admin"),
                array("class"=>"btn btn-small pull-right")
        ); ?>
        <?php echo CHtml::link(
                Yii::t("UserAdminModule.admin", "Edit"),
                array("update", "id"=>$model->id),
                array("class"=>"btn btn-small pull-right")
        ); ?></h2>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'name',
		'code',
                array(
                        'name'=>'description',
                        'value'=>nl2br($model->description),
                        'type'=>'raw',
                ),
	),
        'htmlOptions'=>array('class'=>'table table-condensed table-striped table-hover table-bordered table-side'),
)); ?>

<?php if(Yii::app()->user->getFlash('taskSaved')): ?>
        <h4 class='alert alert-success centered hide-on-click'>
                <?php echo Yii::t("UserAdminModule.admin","Changes has been saved"); ?>
        </h4>
<?php endif ?>

<table class='table table-bordered table-condensed'>
        <tr>
                <th class='grayHeader'><h2 class='centered'><?php echo Yii::t("UserAdminModule.admin","Tasks"); ?></h2></th>
        </tr>
        <tr>
                <td>
                        <?php $taskForm = $this->beginWidget('CActiveForm'); ?>

                                <?php echo $taskForm->checkBoxList(
                                        $model, 'taskIds', 
                                        CHtml::listData(UserTask::model()->findAll("code != 'freeAccess'"), 'id', 'name'),
                                        array(
                                                'template'=>"<label class='checkbox'>{input} {label}</label>",
                                                'separator'=>'',
                                        )
                                ); ?>

                                <br>
                                <?php echo CHtml::htmlButton(
                                        '<i class="icon-ok icon-white"></i> '.Yii::t("UserAdminModule.admin","Save"), 
                                        array(
                                                'class'=>'btn btn-info',
                                                'type'=>'submit',
                                        )
                                ); ?>

                        <?php $this->endWidget(); ?>
                </td>
        </tr>
</table>

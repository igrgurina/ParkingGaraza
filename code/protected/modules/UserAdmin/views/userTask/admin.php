
<?php $pageSize = Yii::app()->user->getState("pageSize",20); ?>
<h2><?php echo Yii::t('UserAdminModule.admin','User task management'); ?></h2>

<?php echo CHtml::link(
        '<i class="icon-plus-sign icon-white"></i> '.Yii::t('UserAdminModule.admin','Create'), 
        array('create'),
        array('class'=>'btn btn-info')
); ?>

<?php $form=$this->beginWidget("CActiveForm"); ?>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'user-task-grid',
	'dataProvider'=>$model->search(),
        'ajaxUpdate'=>false,
	'filter'=>$model,
	'columns'=>array(
                array(
                        'header'=>'№',
                        'value'=>'$this->grid->dataProvider->pagination->currentPage * $this->grid->dataProvider->pagination->pageSize + ($row+1)',
                        'htmlOptions'=>array(
                                'width'=>'25',
                                'class'=>'centered'
                        )
                ),
                array(
                        'name'=>'name',
                        'value'=>'($data->code == "freeAccess") ? 
                                CHtml::link($data->name, array("view", "id"=>$data->id), array("style"=>"color:green")) :
                                CHtml::link($data->name, array("view", "id"=>$data->id))',
                        'type'=>'raw',
                ),
		'code',
		'description',
                array(
                        'id'=>'autoId',
                        'class'=>'CCheckBoxColumn',
                        'selectableRows'=>2,
                ),
		array(
			'class'=>'CButtonColumn',
                        'buttons'=>array(
                                'delete'=>array(
                                        'visible'=>'($data->code != "freeAccess")',
                                ),
                        ),
                        'header'=>CHtml::dropDownList('pageSize',$pageSize,array(20=>20,50=>50,100=>100,200=>200),array(
                                'onchange'=>"$.fn.yiiGridView.update('user-task-grid',{ data:{pageSize: $(this).val() }})",
                                'style'=>'width:50px'
                        )),
		),
	),
        'itemsCssClass'=>'table table-hover table-striped table-bordered table-condensed',
)); ?>


<script>
function reloadGrid(data) {
    $.fn.yiiGridView.update('user-task-grid');
}
</script>

<?php echo CHtml::ajaxSubmitButton("",array(), array(),array("style"=>"visibility:hidden;")); ?>
<?php echo CHtml::ajaxSubmitButton(
        Yii::t("UserAdminModule.admin", "Delete selected"),
        array("deleteSelected"), 
        array("success"=>"reloadGrid"),
        array(
                "class"=>"btn btn-small pull-right", 
                "confirm"=>Yii::t("UserAdminModule.admin", "Delete selected elements ?"),
        )
); ?>
<?php $this->endWidget(); ?>

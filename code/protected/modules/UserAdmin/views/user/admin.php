<?php 

class UHelper
{
        /**
         * attributeToggler 
         *
         * For CGridView
         * 
         * @param CActiveRecord $model 
         * @param string $attribute 
         * @param array $values - ("On", "Off") or ("Yes", "No") etc.
         * @return CHtml::ajaxLink
         */
        public static function attributeToggler($model, $attribute, $values = array('On', 'Off'))
        {
                if ($model->{$attribute} == 1) 
                {
                        return CHtml::ajaxLink(
                                "<span class='label label-success'>".$values[0]."</span>",
                                array('toggleState', 'id'=>$model->id, 'attribute'=>$attribute, 'value'=>0),
                                array('success'=>"reloadGrid")
                        );
                } 
                else 
                {
                        return CHtml::ajaxLink(
                                "<span class='label label-warning'>".$values[1]."</span>",
                                array('toggleState', 'id'=>$model->id, 'attribute'=>$attribute, 'value'=>1),
                                array('success'=>"reloadGrid")
                        );
                }
        }
}

?>
<?php $pageSize = Yii::app()->user->getState("pageSize",20); ?>
<h2><?php echo Yii::t('UserAdminModule.admin','User management'); ?></h2>

<?php echo CHtml::link(
        '<i class="icon-plus-sign icon-white"></i> '.Yii::t('UserAdminModule.admin','Create'), 
        array('create'),
        array('class'=>'btn btn-info')
); ?>


<?php $form=$this->beginWidget("CActiveForm"); ?>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'user-grid',
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
                        'name'=>'login',
                        'value'=>'CHtml::link($data->login, array("view", "id"=>$data->id))',
                        'type'=>'raw',
                ),
                array(
                        'name'=>'findByRole',
                        'filter'=>CHtml::listData(UserRole::model()->findAll(), 'code', 'name'),
                        'value'=>'User::getRoles($data->roles)',
                ),
                array(
                        'name'=>'is_superadmin',
                        'filter'=>User::getIsSuperAdminList(false),
                        'value'=>'User::getIsSuperAdminValue($data->is_superadmin)',
                        'type'=>'raw',
                        'visible'=>User::checkRole('isSuperAdmin'),
                        'htmlOptions'=>array(
                                'width'=>'55',
                                'style'=>'text-align:center',
                        )
                ),
                array(
                        'name'=>'active',
                        'filter'=>array(1=>'On', 0=>'Off'),
                        'value'=>'UHelper::attributeToggler($data, "active")',
                        'type'=>'raw',
                        'htmlOptions'=>array(
                                'width'=>'55',
                                'style'=>'text-align:center',
                        )
                ),
                array(
                        'id'=>'autoId',
                        'class'=>'CCheckBoxColumn',
                        'selectableRows'=>2,
                ),
		array(
			'class'=>'CButtonColumn',
                        'buttons'=>array(
                                'delete'=>array(
                                        'visible'=>'($data->id != Yii::app()->user->id)',
                                ),
                        ),
                        'header'=>CHtml::dropDownList('pageSize',$pageSize,array(20=>20,50=>50,100=>100,200=>200),array(
                                'onchange'=>"$.fn.yiiGridView.update('user-grid',{ data:{pageSize: $(this).val() }})",
                                'style'=>'width:50px'
                        )),
		),
	),
        'itemsCssClass'=>'table table-hover table-striped table-bordered table-condensed',
)); ?>


<script>
function reloadGrid(data) {
    $.fn.yiiGridView.update('user-grid');
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

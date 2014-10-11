

<h2>
        <?php echo Yii::t("UserAdminModule.admin", "Creating"); ?>
        <?php echo CHtml::link(
                Yii::t("UserAdminModule.admin", "Manage"),
                array("admin"),
                array("class"=>"btn btn-small pull-right")
        ); ?></h2>
<div class='clearfix'>
</div>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>

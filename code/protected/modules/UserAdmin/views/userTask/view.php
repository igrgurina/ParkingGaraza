
<h2>
        <?php echo Yii::t("UserAdminModule.admin","User task details"); ?>
        <?php echo CHtml::link(
                Yii::t("UserAdminModule.admin", "Manage"),
                array("admin"),
                array("class"=>"btn btn-small pull-right")
        ); ?>
        <?php echo CHtml::link(
                Yii::t("UserAdminModule.admin", "Edit"),
                array("update", "id"=>$taskDetails->id),
                array("class"=>"btn btn-small pull-right")
        ); ?>
</h2>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$taskDetails,
	'attributes'=>array(
		'name',
		'code',
                array(
                        'name'=>'description',
                        'value'=>nl2br($taskDetails->description),
                        'type'=>'raw',
                ),
	),
        'htmlOptions'=>array('class'=>'table table-condensed table-striped table-hover table-bordered table-side'),
)); ?>

<?php if(Yii::app()->user->getFlash('success')): ?>
        <h4 class='alert alert-success centered hide-on-click'>
                <?php echo Yii::t("UserAdminModule.admin","Changes has been saved"); ?>
        </h4>
<?php endif ?>

<?php echo CHtml::beginForm(); ?>

        <?php echo CHtml::htmlButton(
                '<i class="icon-ok icon-white"></i> '.Yii::t("UserAdminModule.admin","Save"), 
                array(
                        'class'=>'btn btn-info btn-block',
                        'type'=>'submit',
                )
        ); ?>

        <div style='text-align:right'>
                <?php echo CHtml::link(
                        Yii::t("UserAdminModule.admin","Refresh controllers list"), 
                        array('refreshOperations', 'id'=>$taskDetails->id),
                        array('class'=>'btn btn-inverse btn-small')
                ); ?>
        </div>
        <br><br>

        <table class='table table-bordered table-condensed'>
                <tr>
                        <th class='grayHeader' width='50%'><h2 class='centered'><?php echo Yii::t("UserAdminModule.admin","Common controllers"); ?></h2></th>
                        <th class='grayHeader' width='50%'><h2 class='centered'><?php echo Yii::t("UserAdminModule.admin","Modules"); ?></h2></th>
                </tr>
                <tr>
                        <td class='controllers-box'>
                                <table class='table'>
                                        <tr>
                                                <td width='50%'>
                                                        <span class='btn btn-block btn-small commonHider'>
                                                                <?php echo Yii::t("UserAdminModule.admin","Hide all"); ?>
                                                        </span>
                                                </td>
                                                <td width='50%'>
                                                        <span class='btn btn-block btn-small btn-success commonOpener'>
                                                                <?php echo Yii::t("UserAdminModule.admin","Open all"); ?>
                                                        </span>
                                                </td>
                                        </tr>
                                </table>

                                <?php foreach($generalControllers as $generalController): ?>
                                        <?php
                                        $controllerName = UserTask::getModuleAndControllerName($generalController->route);

                                        if (! isset($prevName) OR ($prevName != $controllerName) )
                                        {
                                                $prevName = $controllerName;
                                                echo "<div class='controllerNameContainer'>".
                                                        " <span class='commonControllerName' param='{$controllerName}'><i class='icon-plus'></i> {$controllerName}</span></div>";
                                        }
                                        ?>

                                        <label class="checkbox hide commonControllerHide commonController<?php echo $controllerName; ?>">
                                                <?php echo CHtml::checkBox(
                                                        'Operation['.$generalController->id.']',
                                                        in_array($generalController->id, $operationIds),
                                                        array(
                                                                'value'=>$generalController->id,
                                                                'class'=>'commonControllerCheckBox'.$controllerName
                                                        )
                                                ); ?>
                                                <?php echo UserTask::pretifyRoute($generalController->route); ?>
                                        </label>
                                <?php endforeach ?>
                        </td>

                        <td>
                        <div class='controllers-box'>
                                <?php foreach($moduleControlers as $moduleControler): ?>
                                        <?php
                                        $tmp = UserTask::getModuleAndControllerName($moduleControler->route);
                                        $moduleName = $tmp['module'];
                                        $controllerName = $tmp['controller'];

                                        if (! isset($prevModuleName) OR ($prevModuleName != $moduleName) )
                                        {
                                                $prevModuleName = $moduleName;
                                                echo "<h3>{$moduleName} <span class='btn btn-small moduleHider' param='{$moduleName}'>".
                                                        Yii::t("UserAdminModule.admin","Hide all").
                                                        "</span> <span class='btn btn-small btn-success moduleOpener' param='{$moduleName}'>".
                                                        Yii::t("UserAdminModule.admin","Open all").
                                                        "</span></h3>";
                                        }
                                        if (! isset($prevControllerName) OR ($prevControllerName != $controllerName) )
                                        {
                                                $prevControllerName = $controllerName;
                                                echo "<div class='controllerNameContainer'>".
                                                        " <span class='moduleControllerName' param='{$moduleName}-{$controllerName}'><i class='icon-plus'> </i>{$controllerName}</span></div>";
                                        }
                                        ?>

                                        <label class='checkbox hide module<?php echo $moduleName; ?> moduleController<?php echo $moduleName.'-'.$controllerName; ?>'>
                                                <?php echo CHtml::checkBox(
                                                        'Operation['.$moduleControler->id.']',
                                                        in_array($moduleControler->id, $operationIds),
                                                        array(
                                                                'value'=>$moduleControler->id,
                                                                'class'=>'moduleControllerCheckBox'.$moduleName.$controllerName,
                                                        )
                                                ); ?>
                                                <?php echo UserTask::pretifyRoute($moduleControler->route); ?>
                                        </label>
                                <?php endforeach ?>
                        </div>
                        </td>
                </tr>
        </table>

        <?php echo CHtml::htmlButton(
                '<i class="icon-ok icon-white"></i> '.Yii::t("UserAdminModule.admin","Save"), 
                array(
                        'class'=>'btn btn-info btn-block',
                        'type'=>'submit',
                )
        ); ?>
<?php echo CHtml::endForm(); ?>

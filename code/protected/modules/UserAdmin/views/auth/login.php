<div id='m_login'>
    <div class='form'>
        <?php $form = $this->beginWidget('CActiveForm',array(
                'focus'=>array($model,'login'),
                'id'=>'login-form',
        )) ?>

        <div class='row'>
            <?php echo $form->label($model, 'login') ?>
            <?php echo $form->textField($model, 'login', array('autocomplete'=>'off')) ?>
            <?php echo $form->error($model, 'login') ?>
        </div>

        <div class='row'>
            <?php echo $form->label($model, 'password') ?>
            <?php echo $form->passwordField($model, 'password') ?>
            <?php echo $form->error($model, 'password') ?>
        </div>

        <div class='row rememberMe'>
            <?php echo $form->label($model, 'rememberMe') ?>
            <?php echo $form->checkBox($model, 'rememberMe') ?>
        </div>

        <div class='row buttons'>
            <?php echo CHtml::submitButton(Yii::t("UserAdminModule.LoginForm","Login"),array('class'=>'btn span2')) ?>
        </div>

        <?php $this->endWidget() ?>

    </div>
</div>
<span class="pull-right">Not registered? <?php echo CHtml::link('Register', array('/UserAdmin/auth/registration'), array('style'=>(!User::checkRole('isGuest', false) ? 'display:none' : ''))); ?></span>
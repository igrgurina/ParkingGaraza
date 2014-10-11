<?php

/**
 * UserAdminModule
 *
 * @version 1.0
 * @author vi mark <webvimark@gmail.com>
 * @license MIT
 */
class UserAdminModule extends CWebModule
{
    /**
     * Cache expiration time
     *
     * @var int
     */
    public $cache_time = 3600;


    public function init()
    {
        $this->setImport(array(
            'UserAdmin.models.*',
            'UserAdmin.components.*',
        ));
    }


    public function beforeControllerAction($controller, $action)
    {
        if (parent::beforeControllerAction($controller, $action)) {
            $dir = CHtml::asset(__DIR__ . '/static');

            Yii::app()->clientScript->registerCssFile($dir . '/style.css');
            Yii::app()->clientScript->registerScriptFile($dir . '/common.js');

            return true;
        } else
            return false;
    }
}

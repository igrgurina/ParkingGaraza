<?php

/**
 * This is the model class for table "user_operation".
 *
 * The followings are the available columns in table 'user_operation':
 * @property integer $id
 * @property string $route
 * @property int $is_module
 *
 * The followings are the available model relations:
 * @property tasks[] $UserTask
 */
class UserOperation extends CActiveRecord
{
        public function defaultScope()
        {
                return array(
                        'order'=>'route ASC',
                );
        }

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return 'user_operation';
	}

        public function rules()
        {
                return array(
                        array('route', 'unique'),
                );
        }

	public function relations()
	{
		return array(
			'tasks' => array(self::MANY_MANY, 'UserTask', 'UserTaskHasUserOperation(user_operation_id, user_task_id)'),
		);
	}

        /**
         * updateData 
         * 
         * @return void
         */
        public static function updateData()
        {
                self::updateGeneralControllers();
                self::updateModuleControllers();
        }

        /**
         * updateGeneralControllers 
         */
        public static function updateGeneralControllers()
        {
                $freshData = UActionTree::getControllersActions(Yii::app()->controllerPath);

                self::updateControllersTemplate($freshData, 0);
        }

        /**
         * updateModuleControllers 
         */
        public static function updateModuleControllers()
        {
                $freshData = UActionTree::getModuleControllersActions();

                self::updateControllersTemplate($freshData, 1);
        }

        /**
         * updateControllersTemplate 
         * 
         * @param array $freshData - array of paths (e.g "site/index")
         * @param int $is_module 
         */
        public static function updateControllersTemplate($freshData, $is_module)
        {
                
                $models = self::model()->findAll('is_module = '.$is_module);

                $oldData = array();
                foreach ($models as $model) 
                {
                        $oldData[] = $model->route;
                }

                $toAdd    = array_diff($freshData, $oldData);
                $toRemove = array_diff($oldData, $freshData);

                if (! empty($toAdd))
                        self::updateToAdd($toAdd, $is_module);

                if (! empty($toRemove))
                        self::updateToRemove($toRemove);
        }

        /**
         * updateToAdd 
         * 
         * @param array $toAdd - array of paths (e.g "site/index") 
         * @param int $is_module 
         */
        public static function updateToAdd($toAdd, $is_module)
        {
                foreach ($toAdd as $path) 
                {
                        $model = new self;
                        $model->route = $path;
                        $model->is_module = $is_module;
                        $model->save();
                }
        }

        /**
         * updateToRemove 
         * 
         * @param array $toRemove - array of paths (e.g "site/index") 
         */
        public static function updateToRemove($toRemove)
        {
                $criteria = new CDbCriteria;
                $criteria->addInCondition('route', $toRemove);

                self::model()->deleteAll($criteria);
        }
}

<?php

/**
 * This is the model class for table "user_task".
 *
 * The followings are the available columns in table 'user_task':
 * @property integer $id
 * @property string $name
 * @property string $code
 * @property string $description
 *
 * The followings are the available model relations:
 * @property users[] $User
 * @property roles[] $UserRole
 * @property operations[] $UserOperation
 */
class UserTask extends CActiveRecord
{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return 'user_task';
	}

	public function rules()
	{
		return array(
			array('name, code', 'required'),
			array('name', 'length', 'max'=>50),
                        array('code', 'unique'),
			array('code', 'length', 'max'=>100),
			array('description', 'length', 'max'=>255),

			array('id, name, code, description', 'safe', 'on'=>'search'),
		);
	}

	public function relations()
	{
		return array(
			'users'      => array(self::MANY_MANY, 'User', 'UserHasUserTask(user_task_code, user_id)'),
			'roles'      => array(self::MANY_MANY, 'UserRole', 'UserRoleHasUserTask(user_task_id, user_role_id)'),
			'operations' => array(self::MANY_MANY, 'UserOperation', 'UserTaskHasUserOperation(user_task_id, user_operation_id)'),
		);
	}

	public function attributeLabels()
	{
		return array(
			'id'          => 'ID',
			'name'        => Yii::t("UserAdminModule.label",'Name'),
			'code'        => Yii::t("UserAdminModule.label",'Code'),
			'description' => Yii::t("UserAdminModule.label",'Description'),
		);
	}

	public function search()
	{
		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('code',$this->code,true);
		$criteria->compare('description',$this->description,true);

		return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'sort'=>array(
                                'defaultOrder'=>'id DESC',
                        ),
                        'pagination'=>array(
                                'pageSize'=>Yii::app()->user->getState('pageSize',20), 
                        ),
		));
	}

        /**
         * pretifyRoute 
         *
         * Change "site/index" to "Site.Index"
         * 
         * @param string $route 
         * @return string
         */
        public static function pretifyRoute($route)
        {
                $array = explode('/', $route);

                if (count($array) == 2) 
                {
                        $result[0] = ucfirst($array[0]);
                        $result[1] = '<b>'.ucfirst($array[1]).'</b>';
                } 
                else 
                {
                        $result[0] = $array[0];
                        $result[1] = ucfirst($array[1]);
                        $result[2] = '<b>'.ucfirst($array[2]).'</b>';
                }

                return implode($result, '.');
        }

        /**
         * getModuleAndControllerName 
         * 
         * @param string $route 
         * @return mixed - string/array
         */
        public static function getModuleAndControllerName($route)
        {
                $array = explode('/', $route);

                if (count($array) == 2) 
                {
                        return ucfirst($array[0]).'Controller';
                }
                else
                {
                        return array(
                                'module'     => ucfirst($array[0]).'Module',
                                'controller' => ucfirst($array[1]).'Controller',
                        );
                }
        }

        /**
         * beforeDelete 
         *
         * Do not allow delete "freeAccess" task
         * 
         * @return void
         */
        protected function beforeDelete()
        {
                if ($this->code == 'freeAccess')
                        return false;

                return parent::beforeDelete();
        }

        /**
         * afterDelete 
         * 
         * Reset cache
         */
        protected function afterDelete()
        {
                UserCache::model()->updateAll(array(
                        'status' => 0,
                ));
        }
}

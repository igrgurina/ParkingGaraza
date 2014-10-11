<?php

/**
 * This is the model class for table "user_role".
 *
 * The followings are the available columns in table 'user_role':
 * @property integer $id
 * @property string $name
 * @property string $code
 * @property string $description
 *
 * The followings are the available model relations:
 * @property users[] $User
 * @property tasks[] $UserTask
 */
class UserRole extends CActiveRecord
{
        /**
         * Used in view by checkBoxList() 
         * 
         * @var array
         */
        public $taskIds = array();


	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return 'user_role';
	}

	public function rules()
	{
		return array(
			array('name, code', 'required'),
                        array('code', 'unique'),
                        array('code', 'checkCode'),
			array('name', 'length', 'max'=>50),
			array('code', 'length', 'max'=>100),
			array('description, home_page', 'length', 'max'=>255),

			array('id, name, description, code', 'safe', 'on'=>'search'),
		);
	}

        /**
         * Code should not be "isSuperAdmin" or "tasks"
         */
        public function checkCode()
        {
                $code = trim(strtolower($this->code));

                if ( ($code == 'issuperadmin') OR ($code == 'tasks'))
                        $this->addError('code', Yii::t("UserAdminModule.admin","Choose another code"));
        }

	public function relations()
	{
		return array(
			'users' => array(self::MANY_MANY, 'User', 'user_has_user_role(user_role_code, user_id)'),
			'tasks' => array(self::MANY_MANY, 'UserTask', 'user_role_has_user_task(user_role_id, user_task_id)'),
		);
	}

	public function attributeLabels()
	{
		return array(
			'id'          => 'ID',
			'name'        => Yii::t("UserAdminModule.label",'Name'),
			'code'        => Yii::t("UserAdminModule.label",'Code'),
			'home_page'   => Yii::t("UserAdminModule.label",'Backend home page'),
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

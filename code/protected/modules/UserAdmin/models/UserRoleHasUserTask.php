<?php

/**
 * This is the model class for table "user_role_has_user_task".
 *
 * The followings are the available columns in table 'user_role_has_user_task':
 * @property integer $id
 * @property integer $user_role_id
 * @property integer $user_task_id
 *
 * The followings are the available model relations:
 * @property UserTask $userTask
 * @property UserRole $userRole
 */
class UserRoleHasUserTask extends CActiveRecord
{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return 'user_role_has_user_task';
	}

	public function rules()
	{
		return array(
			array('user_role_id, user_task_id', 'required'),
			array('user_role_id, user_task_id', 'numerical', 'integerOnly'=>true),

			array('id, user_role_id, user_task_id', 'safe', 'on'=>'search'),
		);
	}

	public function relations()
	{
		return array(
			'userTask' => array(self::BELONGS_TO, 'UserTask', 'user_task_id'),
			'userRole' => array(self::BELONGS_TO, 'UserRole', 'user_role_id'),
		);
	}

	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'user_role_id' => 'User Role',
			'user_task_id' => 'User Task',
		);
	}

	public function search()
	{
		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('user_role_id',$this->user_role_id);
		$criteria->compare('user_task_id',$this->user_task_id);

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
}

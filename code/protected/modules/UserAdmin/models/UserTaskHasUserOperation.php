<?php

/**
 * This is the model class for table "user_task_has_user_operation".
 *
 * The followings are the available columns in table 'user_task_has_user_operation':
 * @property integer $id
 * @property integer $user_task_id
 * @property integer $user_operation_id
 *
 * The followings are the available model relations:
 * @property UserOperation $userOperation
 * @property UserTask $userTask
 */
class UserTaskHasUserOperation extends CActiveRecord
{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return 'user_task_has_user_operation';
	}

	public function rules()
	{
		return array(
			array('user_task_id, user_operation_id', 'required'),
			array('user_task_id, user_operation_id', 'numerical', 'integerOnly'=>true),

			array('id, user_task_id, user_operation_id', 'safe', 'on'=>'search'),
		);
	}

	public function relations()
	{
		return array(
			'userOperation' => array(self::BELONGS_TO, 'UserOperation', 'user_operation_id'),
			'userTask' => array(self::BELONGS_TO, 'UserTask', 'user_task_id'),
		);
	}

	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'user_task_id' => 'User Task',
			'user_operation_id' => 'User Operation',
		);
	}

	public function search()
	{
		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('user_task_id',$this->user_task_id);
		$criteria->compare('user_operation_id',$this->user_operation_id);

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

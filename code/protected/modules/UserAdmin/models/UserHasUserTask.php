<?php

/**
 * This is the model class for table "user_has_user_task".
 *
 * The followings are the available columns in table 'user_has_user_task':
 * @property integer $id
 * @property integer $user_id
 * @property integer $user_task_code
 *
 * The followings are the available model relations:
 * @property UserTask $userTask
 * @property User $user
 */
class UserHasUserTask extends CActiveRecord
{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return 'user_has_user_task';
	}

	public function rules()
	{
		return array(
			array('user_id, user_task_code', 'required'),
			array('user_id, user_task_code', 'numerical', 'integerOnly'=>true),

			array('id, user_id, user_task_code', 'safe', 'on'=>'search'),
		);
	}

	public function relations()
	{
		return array(
			'userTask' => array(self::BELONGS_TO, 'UserTask', 'user_task_code'),
			'user' => array(self::BELONGS_TO, 'User', 'user_id'),
		);
	}

	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'user_id' => 'User',
			'user_task_code' => 'User Task',
		);
	}

	public function search()
	{
		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('user_task_code',$this->user_task_code);

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

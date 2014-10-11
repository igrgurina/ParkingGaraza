<?php

/**
 * This is the model class for table "user_cache".
 *
 * The followings are the available columns in table 'user_cache':
 * @property integer $id
 * @property integer $user_id
 * @property integer $status
 * @property integer $update_time
 * @property string $routes
 *
 * The followings are the available model relations:
 * @property User $user
 */
class UserCache extends CActiveRecord
{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return 'user_cache';
	}

	public function rules()
	{
		return array(
			array('routes', 'safe'),
			array('user_id', 'unique'),
			array('user_id, status, update_time', 'numerical', 'integerOnly'=>true),

			array('id, user_id, status, routes', 'safe', 'on'=>'search'),
		);
	}

	public function relations()
	{
		return array(
			'user' => array(self::BELONGS_TO, 'User', 'user_id'),
		);
	}

	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'user_id' => 'User',
			'status' => 'Status',
			'routes' => 'Routes',
		);
	}

	public function search()
	{
		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('status',$this->status);
		$criteria->compare('routes',$this->routes,true);

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

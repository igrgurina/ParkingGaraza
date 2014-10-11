<?php

/**
 * This is the model class for table "user".
 *
 * The followings are the available columns in table 'user':
 * @property integer $id
 * @property integer $active
 * @property string $login
 * @property string $password
 * @property integer $is_superadmin
 * @property integer $lastChanged
 *
 * The followings are the available model relations:
 * @property roles[] $UserRole
 * @property tasks[] $UserTask
 */
class User extends CActiveRecord
{
    const SALT = 'nlf8BlbU6nsd947haoNwq2Opjhy5nm';

    /**
     * Filled in afterFind() method
     *
     * @var string
     */
    public $oldPass;

    /**
     * Used in _form on create and update
     *
     * @var string
     */
    public $repeat_password;

    /**
     * Used in search() method
     *
     * @var int
     */
    public $findByRole;

    /**
     * Used in view by checkBoxList()
     *
     * @var array
     */
    public $roleIds = array();


    /**
     * Used in view by checkBoxList()
     *
     * @var array
     */
    public $taskIds = array();


    /**
     * getHashedPassword
     *
     * @param string $password
     * @return string
     */
    public static function getHashedPassword($password)
    {
        return md5($password . self::SALT);
    }

    /**
     * checkRole
     *
     * @param $roles
     * @param boolean $superAdminHasAccess - will return "true" if user has $role or he is superAdmin
     *
     * @internal param mixed $role - can be string, or array of roles
     * @return boolean
     */
    public static function checkRole($roles, $superAdminHasAccess = true)
    {
        if ($superAdminHasAccess AND User::checkRole('isSuperAdmin', false))
            return true;

        $allowed = false;
        foreach ((array)$roles as $role) {
            if (($role == 'isGuest') AND Yii::app()->user->isGuest) {
                $allowed = true;
                break;
            }

            if (Yii::app()->user->getState($role) === true) {
                $allowed = true;
                break;
            }
        }

        return $allowed;
    }

    /**
     * checkTask
     *
     * @param string $task
     * @param boolean $superAdminHasAccess - will return "true" if user has $task or he is superAdmin
     *
     * @return boolean
     */
    public static function checkTask($task, $superAdminHasAccess = true)
    {
        if ($superAdminHasAccess AND User::checkRole('isSuperAdmin'))
            return true;

        if (!Yii::app()->user->isGuest AND $task AND in_array($task, Yii::app()->user->tasks))
            return true;
        else
            return false;
    }


    /**
     * getByRole
     *
     * @param string $role
     * @return array - array of Users
     */
    public static function getByRole($role)
    {
        $criteria = new CDbCriteria;
        $criteria->join = "INNER JOIN user_has_user_role uhur ON uhur.user_id = t.id 
                        INNER JOIN user_role ur ON ur.code = uhur.user_role_code";
        $criteria->addCondition("ur.code = '{$role}'");

        return User::model()->active()->findAll($criteria);
    }

    /**
     * getCurrentUser
     *
     * @return CActiveRecord User
     */
    public static function getCurrentUser()
    {
        if (Yii::app()->user->isGuest)
            return null;
        else
            return self::model()->active()->with('roles', 'tasks')->findByPk((int)Yii::app()->user->id);
    }

    /**
     * getCurrentUserHomePage
     *
     * Try to find home page from one of user roles (if he has any)
     *
     * @return mixed - boolean/string
     */
    public static function getCurrentUserHomePage()
    {
        $user = self::model()->active()->with('roles')->findByPk((int)Yii::app()->user->id);

        if ($user AND $user->roles) {
            foreach ($user->roles as $role) {
                if (!empty($role->home_page))
                    return $role->home_page;
            }
        }

        return false;
    }

    public static function getLastLogin()
    {
        /** @var User $user */
        $user = self::model()->active()->with('roles')->findByPk((int)Yii::app()->user->id);

        if ($user) {
            return date("Y-m-d H:i:s", $user->lastChanged);
        }
    }

    public static function setLastLogin()
    {
        /** @var User $user */
        $user = self::model()->active()->with('roles')->findByPk((int)Yii::app()->user->id);

        if ($user) {
            $user->lastChanged = date("Y-m-d H:i:s");
            $user->save();
        }
    }


    public function scopes()
    {
        return array(
            'active' => array(
                'condition' => 'active = 1 OR is_superadmin = 1',
            ),
        );
    }

    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function tableName()
    {
        return 'user';
    }

    public function rules()
    {
        return array(
            array('login, password, repeat_password, is_superadmin', 'required'),

            array('login, password, is_superadmin', 'purgeXSS'),

            array('password', 'compare', 'compareAttribute' => 'repeat_password'),

            array('is_superadmin, active', 'numerical', 'integerOnly' => true),
            array('login', 'length', 'max' => 50),
            array('login', 'unique'),
            array('password', 'length', 'max' => 255),
            array('is_superadmin', 'unsafe', 'on' => array('create', 'update')),

            array('id, login, password, active, is_superadmin, findByRole', 'safe', 'on' => 'search'),
        );
    }


    public function purgeXSS($attr)
    {
        $this->$attr = htmlspecialchars($this->$attr, ENT_QUOTES);
        return true;
    }


    public function relations()
    {
        return array(
            'roles' => array(self::MANY_MANY, 'UserRole', 'user_has_user_role(user_id, user_role_code)'),
            'tasks' => array(self::MANY_MANY, 'UserTask', 'user_has_user_task(user_id, user_task_code)'),
            'cache' => array(self::HAS_ONE, 'UserCache', 'user_id'),
        );
    }

    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'login' => Yii::t("UserAdminModule.label", 'Login'),
            'active' => Yii::t("UserAdminModule.label", 'Active'),
            'password' => Yii::t("UserAdminModule.label", 'Password'),
            'repeat_password' => Yii::t("UserAdminModule.label", 'Repeat password'),
            'is_superadmin' => Yii::t("UserAdminModule.label", 'Superadmin'),
            'findByRole' => Yii::t("UserAdminModule.label", 'Role'),
        );
    }

    public function search()
    {
        $criteria = new CDbCriteria;

        $criteria->compare('t.id', $this->id);
        $criteria->compare('login', $this->login, true);
        $criteria->compare('password', $this->password, true);
        $criteria->compare('active', $this->active);

        // Don't show superadmins for others
        if (self::checkRole('isSuperAdmin'))
            $criteria->compare('is_superadmin', $this->is_superadmin);
        else
            $criteria->compare('is_superadmin', 0);


        if ($this->findByRole) {
            $criteria->join = "INNER JOIN user_has_user_role uhur ON uhur.user_id = t.id";
            $criteria->addCondition("uhur.user_role_code = '{$this->findByRole}'");
        }

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array(
                'defaultOrder' => 't.id DESC',
            ),
            'pagination' => array(
                'pageSize' => Yii::app()->user->getState('pageSize', 20),
            ),
        ));
    }

    //=========== For grid, view etc ===========

    /**
     * getIsSuperAdminList
     *
     * @param boolean $withLabelInfo - false for dropDownList
     *
     * @return array
     */
    public static function getIsSuperAdminList($withLabelInfo = true)
    {
        if ($withLabelInfo) {
            return array(
                '0' => Yii::t("UserAdminModule.admin", "No"),
                '1' => "<span class='label label-info'>" . Yii::t("UserAdminModule.admin", "Yes") . "</span>",
            );
        } else {
            return array(
                '0' => Yii::t("UserAdminModule.admin", "No"),
                '1' => Yii::t("UserAdminModule.admin", "Yes"),
            );
        }
    }

    /**
     * getIsSuperAdminValue
     *
     * @param int $value
     * @return string
     */
    public static function getIsSuperAdminValue($value)
    {
        $ar = self::getIsSuperAdminList();
        return isset($ar[$value]) ? $ar[$value] : '';
    }

    /**
     * getRoles
     *
     * Get string of user roles, separated by comma for CGridView
     *
     * @param array $roles
     * @return string
     */
    public static function getRoles($roles)
    {
        $output = array();
        foreach ($roles as $role) {
            $output[] = $role->name;
        }

        return implode($output, ', ');
    }

    //-----------  For grid, view etc -----------

    /**
     * afterFind
     *
     * Save password, so we know beforeSave() if it has been changed
     * and encrypt it
     *
     * @return void
     */
    protected function afterFind()
    {
        $this->oldPass = $this->password;
        $this->repeat_password = $this->password;

        parent::afterFind();
    }

    /**
     * beforeSave
     *
     * Encrypt password if it has been changed
     *
     * @return boolean
     */
    protected function beforeSave()
    {
        if ($this->oldPass != $this->password)
            $this->password = self::getHashedPassword($this->password);

        // Make sure that user can't deactive himself
        if (Yii::app()->user->id == $this->id)
            $this->active = 1;

        return parent::beforeSave();
    }

    /**
     * beforeDelete
     *
     * Prevent deleting yourself + prevent delet superadmins by not superadmins
     *
     * @return boolean
     */
    protected function beforeDelete()
    {
        if (Yii::app()->user->id == $this->id)
            return false;

        if (!self::checkRole('isSuperAdmin') AND ($this->is_superadmin == 1))
            return false;

        return parent::beforeDelete();
    }
}

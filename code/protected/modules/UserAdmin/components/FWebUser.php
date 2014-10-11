<?php
class FWebUser extends CWebUser
{
        /**
         * afterLogin 
         */
        protected function afterLogin($fromCookie)
        {
                parent::afterLogin($fromCookie);

                $this->_updateUserState();
        }

        /**
         * _updateUserState 
         */
        private function _updateUserState()
        {
                $user = User::model()->active()->with(array('roles','tasks'))->findByPk((int)$this->id);

                if ($user) 
                {
                        $this->name = $user->login;

                        // If it's SuperAdmin
                        if ($user->is_superadmin == 1) 
                                $this->setState('isSuperAdmin', true);

                        // Set roles
                        foreach ($user->roles as $role) 
                                $this->setState($role->code, true);

                        // Set tasks in Yii::app()->user->tasks array
                        $taskArray = array();
                        foreach ($user->tasks as $task) 
                                $taskArray[] = $task->code;

                        foreach ($user->roles as $tRole) 
                        {
                                foreach ($tRole->tasks as $roleTask) 
                                {
                                        $taskArray[] = $roleTask->code;
                                        
                                }
                        }

                        $taskArray = array_unique($taskArray);

                        $this->setState('tasks', $taskArray);
                }
        }
}

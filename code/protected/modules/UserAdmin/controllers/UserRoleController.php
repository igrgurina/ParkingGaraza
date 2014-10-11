<?php
class UserRoleController extends AdminDefaultController
{
        public $modelName = 'UserRole';
        public $noPages = array('index', 'redirect'=>array('admin'));
        public $createRedirect = array('admin');

        /**
         * actionUpdate 
         * 
         * @param int $id 
         */
        public function actionUpdate($id)
        {
                $model = $this->loadModel($id);

                // To persist 'isGuest' code
                $modelCode = $model->code;

                if (isset($_POST['UserRole']))
                {
                        $model->attributes = $_POST['UserRole'];

                        // To persist 'isGuest' code
                        if ($modelCode == 'isGuest')
                                $model->code = $modelCode;

                        if ($model->save()) 
                        {
                                Yii::app()->clientScript->registerScript('goBack',"
                                        history.go(-2);
                                ");
                        }
                }

                $this->render('update', compact('model'));
        }

        /**
         * actionView 
         * 
         * @param int $id 
         */
        public function actionView($id)
        {
                $model = $this->loadModel($id);


                // Fill taskIds for checkBoxList
                foreach ($model->tasks as $task) 
                        $model->taskIds[] = $task->id;

                if (isset($_POST['UserRole']['taskIds']))
                {
                        UserRoleHasUserTask::model()->deleteAllByAttributes(array(
                                'user_role_id'=>$id,
                        ));

                        // Reset cache
                        UserCache::model()->updateAll(array(
                                'status' => 0,
                        ));

                        if (is_array($_POST['UserRole']['taskIds'])) 
                        {
                                foreach ($_POST['UserRole']['taskIds'] as $taskId) 
                                {
                                        $newTask = new UserRoleHasUserTask;
                                        $newTask->user_role_id = $id;
                                        $newTask->user_task_id = $taskId;
                                        $newTask->save(false);
                                }
                        }

                        Yii::app()->user->setFlash('taskSaved', 'aga');
                        $this->redirect(array('view', 'id'=>$id));
                }


                $this->render('view', compact('model'));
        }
}

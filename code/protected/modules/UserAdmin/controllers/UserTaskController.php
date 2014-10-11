<?php
class UserTaskController extends AdminDefaultController
{
        public $modelName = 'UserTask';
        public $noPages = array('index', 'redirect'=>array('admin'));
        public $createRedirect = array('admin');
        public $updateRedirect = array('admin');

        /**
         * actionView 
         * 
         * @param int $id 
         */
        public function actionView($id)
        {
                if (isset($_POST['Operation']))
                {
                        // Reset cache
                        UserCache::model()->updateAll(array(
                                'status' => 0,
                        ));

                        UserTaskHasUserOperation::model()->deleteAll('user_task_id = '.$id);
                        foreach ($_POST['Operation'] as $user_operation_id) 
                        {
                                $model = new UserTaskHasUserOperation;
                                $model->user_task_id = $id;
                                $model->user_operation_id = $user_operation_id;
                                $model->save(false);
                        }

                        Yii::app()->user->setFlash('success', 'aga');
                        $this->redirect(array('view', 'id'=>$id));
                }

                $taskDetails = $this->loadModel($id);

                $generalControllers = UserOperation::model()->findAll('is_module = 0');
                $moduleControlers = UserOperation::model()->findAll('is_module = 1');

                // Get ids of operations realted to this task (for checkboxes)
                $uthuoS = UserTaskHasUserOperation::model()->findAll('user_task_id = '.$id);
                $operationIds = array();
                foreach ($uthuoS as $uthuo) 
                {
                        $operationIds[] = $uthuo->user_operation_id;
                }

                $this->render('view', compact('taskDetails', 'operationIds', 'generalControllers', 'moduleControlers'));
        }

        /**
         * actionRefreshOperations 
         * 
         * @param int $id - task id
         */
        public function actionRefreshOperations($id)
        {
                UserOperation::updateData();

                // Reset cache
                UserCache::model()->updateAll(array(
                        'status' => 0,
                ));

                $this->redirect(array('view', 'id'=>$id));
        }
}

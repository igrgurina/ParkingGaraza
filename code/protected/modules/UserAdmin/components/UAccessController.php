<?php

class UAccessController extends CController
{
    public $freeAccess = true;
    public $freeAccessActions = array();

    public function filters()
    {
        return array(
            'userAdminControl'
        );
    }

    /**
     * filterUserAdminControl
     *
     * @param mixed $filterChain
     * @return void
     */
    public function filterUserAdminControl($filterChain)
    {
        // Get login action url
        if (is_array(Yii::app()->user->loginUrl))
            $loginUrl = trim(Yii::app()->user->loginUrl[0], '/');
        else
            $loginUrl = trim(Yii::app()->user->loginUrl, '/');


        $errorAction = trim(Yii::app()->errorHandler->errorAction, '/');


        // If it's not error or login action
        if ((strtolower($this->route) === strtolower($loginUrl)) OR (strtolower($this->route) === strtolower($errorAction))) {
            $filterChain->run();
        } // If this controller or this action if free to access for everyone
        elseif (($this->freeAccess === true) OR (in_array($this->action->id, $this->freeAccessActions))) {
            $filterChain->run();
        } // User is guest
        elseif (Yii::app()->user->isGuest) {
            if ($this->_isRouteAllowed($this->_getGuestAllowedRoutes())) {
                $filterChain->run();
            } else {
                Yii::app()->user->returnUrl = array('/' . $this->route);
                $this->redirect(Yii::app()->user->loginUrl);
            }
        } // If user is SuperAdmin
        elseif (User::checkRole('isSuperAdmin')) {
            $filterChain->run();
        } // Check if this user has access to this action
        else {
            if ($this->_isRouteAllowed(array_merge($this->_getAllowedUserRoutes(), $this->_getGuestAllowedRoutes())))
                $filterChain->run();
            else
                throw new CHttpException(403, Yii::t("UserAdminModule.front", "You are not authorized to perform this action."));
        }

    }

    /**
     * _isRouteAllowed
     *
     * Checks if current route is in array of allowed routes
     *
     * @param array $allowedRoutes
     *
     * @return boolean
     */
    private function _isRouteAllowed($allowedRoutes)
    {
        foreach ($allowedRoutes as $allowedRoute) {
            if ($this->route == $allowedRoute) {
                return true;
            } else {
                // If some controller fully allowed (wildcard)
                if (substr($allowedRoute, -1) == '*') {
                    $routeArray = explode('/', $this->route);
                    array_splice($routeArray, -1);

                    $allowedRouteArray = explode('/', $allowedRoute);
                    array_splice($allowedRouteArray, -1);

                    if (array_diff($routeArray, $allowedRouteArray) === array())
                        return true;
                }
            }
        }

        return false;
    }

    /**
     * _getGuestAllowedRoutes
     *
     * @return array
     */
    private function _getGuestAllowedRoutes()
    {
        $cache = $this->_checkCache(true);

        if (is_array($cache)) {
            return $cache;
        } else // If no cached routes
        {
            $sql = "SELECT DISTINCT route FROM user_operation uo
                                INNER JOIN user_task_has_user_operation uthuo ON uo.id = uthuo.user_operation_id 
                                INNER JOIN user_task ut ON ut.id = uthuo.user_task_id 

                                WHERE ut.code = 'freeAccess'";

            $routes = Yii::app()->db->createCommand($sql)->queryAll();

            $result = array();

            foreach ($routes as $route)
                $result[] = $route['route'];

            $result = array_unique($result);

            // Save results in cache
            $cache->routes = serialize($result);
            $cache->status = 1;
            $cache->is_guest = 1;
            $cache->update_time = time();
            $cache->save(false);

            return $result;
        }
    }

    /**
     * _getAllowedUserRoutes
     *
     * @return array
     */
    private function _getAllowedUserRoutes()
    {
        // No allowed routes if user id isn't set
        if (!Yii::app()->user->id)
            return array();

        $cache = $this->_checkCache();

        if (is_array($cache)) {
            return $cache;
        } else // If no cached routes
        {
            $sqlRoles = "SELECT DISTINCT route FROM user_operation uo
                                INNER JOIN user_task_has_user_operation uthuo ON uo.id = uthuo.user_operation_id 
                                INNER JOIN user_task ut ON ut.id = uthuo.user_task_id 

                                INNER JOIN user_role_has_user_task urhut ON urhut.user_task_id = ut.id 
                                INNER JOIN user_role ur ON ur.id = urhut.user_role_id 

                                INNER JOIN user_has_user_role uhur ON uhur.user_role_code = ur.code 

                                INNER JOIN user u ON u.id = uhur.user_id

                                WHERE u.id = :user_id";

            $sqlTasks = "SELECT DISTINCT route FROM user_operation uo
                                INNER JOIN user_task_has_user_operation uthuo ON uo.id = uthuo.user_operation_id 
                                INNER JOIN user_task ut ON ut.id = uthuo.user_task_id 

                                INNER JOIN user_has_user_task uhut ON uhut.user_task_code = ut.code 

                                INNER JOIN user u ON u.id = uhut.user_id 

                                WHERE u.id = :user_id";

            $userId = Yii::app()->user->id;

            $roleRoutes = Yii::app()->db->createCommand($sqlRoles)
                ->bindParam(':user_id', $userId, PDO::PARAM_INT)
                ->queryAll();

            $taskRoutes = Yii::app()->db->createCommand($sqlTasks)
                ->bindParam(':user_id', $userId, PDO::PARAM_INT)
                ->queryAll();

            $result = array();

            foreach ($roleRoutes as $roleRoute)
                $result[] = $roleRoute['route'];

            foreach ($taskRoutes as $taskRoute)
                $result[] = $taskRoute['route'];

            $result = array_unique($result);

            // Save results in cache
            $cache->routes = serialize($result);
            $cache->status = 1;
            $cache->is_guest = 0;
            $cache->update_time = time();
            $cache->save(false);

            return $result;
        }
    }

    /**
     * _checkCache
     *
     * Get agailiable routes from cache (or UserCache model)
     *
     * @param boolean $forGuest
     *
     * @return array / CActiveRecord
     */
    private function _checkCache($forGuest = false)
    {
        if ($forGuest) {
            $userCache = UserCache::model()->find('is_guest = 1');
        } else {
            $user = User::model()->active()->with('cache')->findByPk((int)Yii::app()->user->id);

            // If no user (let's say he's been banned during session)
            // then return empty array - no allowed routes
            if (!$user)
                return array();

            $userCache = $user->cache;
        }

        // No cache
        if (!$userCache) {
            $cache = new UserCache;

            if (!$forGuest)
                $cache->user_id = $user->id;

            return $cache;
        } // Has been modified
        elseif ($userCache->status == 0) {
            return $userCache;
        } // Expired
        elseif ($userCache->update_time < (time() - Yii::app()->getModule('UserAdmin')->cache_time)) {
            return $userCache;
        } // All OK - so we return array of routes
        else {
            return unserialize($userCache->routes);
        }
    }
}

<?php
class ProfileController extends Controller
{
    /**
     * actionPersonal 
     * 
     * Personal profile page.
     *
     * @return void
     */
    public function actionPersonal()
    {
        if (Yii::app()->user->isGuest) 
            throw new CHttpException(403, Yii::t("UserAdminModule.front","You are not authorized to perform this action."));

        $user = User::model()->active()->findByPk((int)Yii::app()->user->id);

        if (! $user)
            throw new CHttpException(403, Yii::t("UserAdminModule.front","You are not authorized to perform this action."));


        //=========== Here you can implement some logic (like changing password) ===========


        //----------------------------------------------------------------------------------

        $this->render('personal', compact('user'));
    }
}

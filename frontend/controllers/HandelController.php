<?php
namespace frontend\controllers;

use Yii;
use yii\base\Controller;
use frontend\models\Handel;

class HandelController extends HomeController
{
    /*
     * 处理添加好友
     */
    public function actionAddChar()
    {
        $post=Yii::$app->request->post();
        $model=new Handel();
        return $this->asJson($model->SendAdd($post));


    }

    /*
     * 同意添加好友
     */
    public function actionCharSave()
    {
        $post=Yii::$app->request->post();
        $model=new Handel();
        return $this->asJson($model->TVS($post));


    }
}
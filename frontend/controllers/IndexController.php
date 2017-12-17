<?php
namespace frontend\controllers;

use Yii;

class IndexController extends HomeController
{
    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        /* $name=new AliYunPhone(Yii::$app->params['aliyuncode']);
        $stdclass=$name->setParam("1832347709",1346)->run();
        echo "<pre>";
        print_r($stdclass);
        */
        return $this->render('index');
    }

}
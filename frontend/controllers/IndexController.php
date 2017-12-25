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
       //$server = new \swoole_websocket_server("0.0.0.0", 9501);
        return $this->render('index');
    }


}
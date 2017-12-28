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
       /* $name=new \redis();
        $name->connect("127.0.0.1",);
        echo "<pre>";
        print_r($name->get("name"));
        exit;
       */

        return $this->render('index');
    }


}
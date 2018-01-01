<?php
namespace frontend\controllers;

use Yii;
use yii\helpers\Json;

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
        /*  $redis=new \redis();
        $redis->connect("127.0.0.1");
        $redis->select(0);
        echo "<pre>";
        print_r($redis->hgetall("fd"));
       // $array=$redis->mget($redis->keys("*"));
        echo $key=array_search(100,$redis->hgetall("fd"));
        $redis->hdel("fd",$key);
        exit;
*/


        return $this->render('index');
    }


}
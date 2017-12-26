<?php
namespace frontend\controllers;

use Yii;
use frontend\models\Char;

class CharController extends HomeController
{
    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $model=new Char();
        $data=$model->GetFriend();
        return $this->render('index',['data'=>$data]);
    }

    public function actionTx()
    {
        return $this->render('tx');
    }


}
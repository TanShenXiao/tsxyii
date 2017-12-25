<?php
namespace frontend\controllers;

use Yii;

class CharController extends HomeController
{
    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionTx()
    {
        return $this->render('tx');
    }


}
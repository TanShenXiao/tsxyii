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
        $data=$model->GetRecord();

        return $this->render('index',['data'=>$data]);
    }

    /*
     * 通讯
     */
    public function actionTx()
    {
        $get=Yii::$app->request->get();
        $model=new Char();
        $data=$model->GetChatDate($get);
        if($data['code'] == 203){
            return $this->asJson($data['msg']);
        }
        return $this->render('tx',["data"=>$data['data']]);
    }
    /*
     * 好友
     */
    public function actionFriends()
    {
        $model=new Char();
        $data=$model->GetFriend();

        return $this->render('friends',['data'=>$data]);

    }

}
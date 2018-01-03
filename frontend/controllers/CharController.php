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
        $get=Yii::$app->request->get();
        $model=new Char();
        $data=$model->GetFriend($get);

        return $this->render('friends',['data'=>$data]);

    }
    /*
     * 动态
     */
    public function actionDynamic()
    {
        //var_dump(is_file("./data/timg.jpeg"));
       /* $average = new \Imagick("./data/bj.jpg");
        $average->quantizeImage(2, \Imagick::COLORSPACE_RGB, 0, false, false); // 这个里边的2表示获取 2个较多的颜色，1的话就是1个主要色调，这样
        $average->uniqueImageColors();
        $colorarr = array();
        $it = $average->getPixelIterator();
        $it->resetIterator();
        $row = $it->getNextIteratorRow();
            foreach ($row as $pixel) {

                $colorarr[]= $pixel->getColor();
            }
   echo "<pre>";
            print_r($colorarr);
            exit;
*/
        return $this->render('dynamic');
    }

}
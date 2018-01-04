<?php
namespace frontend\controllers;

use Yii;
use frontend\models\Char;
use common\models\UpFile;
use common\models\User;
use yii\web\UploadedFile;



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

    /*
     * 上传文件
     */
    public function actionUpfile()
    {
        $post=Yii::$app->request->post();
        $model=new UpFile();
        $model->imageFile = UploadedFile::getInstanceByName('imageFile');
        $model->basename=time()."tsx";
        $dir=$model->upload();
        if($dir and isset($post['type']) and $post['type'] == 1 ) {
            $codeLogo = new \Imagick($dir );
            $codeLogo->resizeImage(400,400,false,1);
            $codeLogo->writeImage($dir);
           return $this->asJson(["code"=>200,"dir"=>$dir]);
        }elseif ($dir and isset($post['type']) and $post['type'] == 2)
        {
            return $this->asJson(["code"=>200,"dir"=>$dir]);
        }

        return $this->asJson(["code"=>203,"msg"=>current($model->getFirstErrors())]);

    }
    /*
     * 修改logo
     */
    public function actionEditLogo()
    {
        $post=Yii::$app->request->post();
        if(isset($post['img']) and is_file(substr($post['img'],1))){
            $user=User::find()->where(["id"=>Yii::$app->user->getId()])->one();
            if(isset($post['type']) and  $post['type'] == 1){
                $user->logo=$post['img'];
            }elseif(isset($post['type']) and  $post['type'] == 2){
                $user->bgimg=$post['img'];
            }
            if($user->save()){
                return $this->asJson(["code"=>200,"msg"=>"保存成功"]);
            }
        }
        return $this->asJson(["code"=>203,"msg"=>"文件不存在"]);

    }

}
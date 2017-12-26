<?php
namespace frontend\models;

use Yii;
use yii\base\Model;
use common\models\Friend;

class Char extends Model
{
    /*
     * 获取好友
     */
    public function GetFriend()
    {
        $identity=Yii::$app->user->identity;

       return Friend::find()->where(['status'=>2])->andWhere(['uid'=>$identity->uid])->orWhere(['friend'=>$identity->friend])->asArray()->all();
    }
}
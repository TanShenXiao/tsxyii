<?php
namespace frontend\models;

use Yii;
use yii\base\Model;
use common\models\Friend;
use common\models\User;

class Char extends Model
{
    /*
     * 好友id
     */
    public $id;
    /*
     * 好友对象
     */
    public $friend;

    public function rules()
    {
        return [
            [['id'],'required'],
            ['id','validate_id']
        ];
    }

    public function validate_id($attribute)
    {
        if($this->hasErrors()) return null;
        $identity=Yii::$app->user->identity;
        $this->friend=$row=Friend::find()->alias('a')->leftJoin(['b'=>User::tableName()],'a.friend=b.id')->where(["a.uid"=>$identity->id,"a.friend"=>$this->id])->select(["b.*"])->asArray()->one();
        if(count($row) <= 0){
            $this->addError($attribute,"好友不存在");
        }
    }

    /*
     * 获取聊天信息
     */
    public function GetChatDate($param)
    {
        $this->load($param,'');
        if(!$this->validate())
        {
            return ['code'=>203,'msg'=>current($this->getFirstErrors())];
        }

        return ['code'=>200,'data'=>$this->friend];
    }

    /*
     * 获取好友
     */
    public function GetFriend()
    {
        $identity=Yii::$app->user->identity;
        $data=Friend::find()->where(['status'=>2])->andWhere(['uid'=>$identity->id])->select("friend")->asArray()->all();
        $data=array_column($data,'friend');

       return User::find()->where(['status'=>10])->andWhere(['in','id',$data])->asArray()->all();
    }
}
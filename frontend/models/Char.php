<?php
namespace frontend\models;

use common\models\Chatrecord;
use Yii;
use yii\base\Model;
use common\models\Friend;
use common\models\User;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;

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
        $uid=Yii::$app->user->getId();
        $fid=$this->friend['id'];
        $this->friend['record']=$this->GetCharRecord($uid,$fid);
        $redis=new \redis();
        $redis->connect("127.0.0.1");
        $redis->select(1);
        $redis->hSet("UnreadMessage",$fid.$uid,0);
        return ['code'=>200,'data'=>$this->friend];
    }

    /*
     * 获取前100条聊天记录
     */
    public function GetCharRecord($uid,$fid)
    {
        $array=[$uid,$fid];
        sort($array,SORT_NUMERIC);
        $key=$array[0].$array[1];
        $redis=new \redis();
        $redis->connect("127.0.0.1");
        $redis->select(1);
        $array=[];
        foreach($redis->lRange($key,0,100) as $val){
            $array[]=Json::decode($val);
        }
        krsort($array,SORT_NUMERIC);

        return $array;
    }

    /*
     * 获取消息记录
     */
    public function GetRecord()
    {
        $identity=Yii::$app->user->identity;
        $data=Friend::find()->where(['status'=>1])->andWhere(['friend'=>$identity->id])->select("uid")->asArray()->all();
        $data=array_column($data,'uid');

       $user=User::find()->where(['status'=>10])->andWhere(['in','id',$data])->asArray()->all();
        $redis=new \redis();
        $redis->connect("127.0.0.1");
        $redis->select(1);
       foreach ($user as $key=>$val){
           $user[$key]["num"]=$redis->hGet("UnreadMessage",$val["id"].$identity->id);
       }
       return $user;
    }

    /*
     * 获取好友
     */
    public function GetFriend($get)
    {
        $name = ArrayHelper::getValue($get, "serach", "");
        $identity = Yii::$app->user->identity;
        $data = Friend::find()->where(['status' => 2])->andWhere(['uid' => $identity->id])->select("friend")->asArray()->all();
        $data = array_column($data, 'friend');
        $da = [];
        $da['user'] = User::find()->where(['status' => 10])->andWhere(['in', 'id', $data])->andFilterWhere(['like', 'username', $name])->asArray()->all();
        if ($name) {
            $da['yk'] = User::find()->where(['status' => 10])->andWhere(["not", ["id" => $identity->getId()]])->andWhere(['not in', 'id', $data])->andFilterWhere(['like', 'username', $name])->asArray()->all();

        }

        return $da;
    }

    /*
     * 获取说说信息
     */
    public function getDynamic($get)
    {
        $id=Yii::$app->user->getId();
        if(isset($get["own"])){
            $data=[$id];
        }else{
            $data = Friend::find()->where(['status' => 2])->andWhere(['uid' => $id])->select("friend")->asArray()->all();
            $data = array_column($data, 'friend');
            array_push($data,$id);
        }

       return  \common\models\Dynamic::find()->where(["in","dynamic.uid",$data])
           ->innerJoin(["a"=>User::tableName()],"dynamic.uid = a.id")
           ->select(["dynamic.*","a.username as username","a.logo as logo"])->asArray()->all();
    }


}
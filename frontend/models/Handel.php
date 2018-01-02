<?php

namespace frontend\models;

use Yii;
use yii\base\Exception;
use yii\base\Model;
use common\models\User;
use common\models\Friend;

class Handel extends Model
{
    /*
     * 逻辑处理类
     */
     /*
      * 请求添加事
      */
     const CHARADD='charadd';
     /*
      * 同意添加事件
      */
     const CHARSAVE='charsave';
     /*
      * 发起添加者id
      */
     public $uid;
     /*
      * 接受者id
      */
     public $fid;
     /*
      * 接受者对象
      */
     public $fobject;

     public function rules()
     {
         return [
             [['fid'],'required','on'=>[self::CHARADD,self::CHARSAVE]],
             ['fid','validate_fid'],
         ];
     }

     public function attributeLabels()
     {
         return [
           'uid'=>'发起者',
           'fid'=>'接受者',
         ];
     }

     public function scenarios()
     {
         return [
           self::CHARADD=>['fid'],
           self::CHARSAVE=>['fid'],
         ];
     }

    public function validate_fid($attribute)
     {
         if($this->hasErrors()) return null;
         $id=Yii::$app->user->getId();
         $this->fobject=$row=User::find()->where(["id"=>$this->fid])->one();
         if(!$row){
             $this->addError($attribute,"好友已存在");
         }
         $row=Friend::find()->where(["uid"=>$id,"friend"=>$this->fid])->one();
         if($row and $row->status == 1){
             $this->addError($attribute,"请求已发送");
         }
         if($row and $row->status == 2){
             $this->addError($attribute,'你们已经是好友');
         }
         if($this->fid == $id){
             $this->addError($attribute,'自己不能添加自己');
         }

     }

     /*
      * 发起添加好友
      */
     public function SendAdd($post)
     {
         $this->scenario=self::CHARADD;
         $this->load($post,"");
         if(!$this->validate()){
             return ["code"=>203,"msg"=>current($this->getFirstErrors())];
         }
         $begintransaction=Yii::$app->db->beginTransaction();
         try{
             $friend=new Friend();
             $friend->uid=Yii::$app->user->getId();
             $friend->friend=$this->fid;
             $friend->status=1;
             $friend->created_at=time();
             $friend->updated_at=time();
             if(!$friend->save()){
                 throw new \Exception("处理第一条数据失败");
             }

             $friend1=new Friend();
             $friend1->uid=$this->fid;
             $friend1->friend=Yii::$app->user->getId();
             $friend1->status=1;
             $friend1->created_at=time();
             $friend1->updated_at=time();
             if(!$friend1->save()){
                 throw new \Exception("处理第二条数据失败");
             }
             $begintransaction->commit();
             return ["code"=>200,"msg"=>"申请已提交"];
         }catch(\Exception $e){
             $begintransaction->rollback();
             return ["code"=>203,"msg"=>$e->getMessage()];
         }



     }
}
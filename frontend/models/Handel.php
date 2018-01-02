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
     /*
      * 请求状态 1是同意2是拒接
      */
     public $status;

     public function rules()
     {
         return [
             [['fid'],'required','on'=>[self::CHARADD,self::CHARSAVE]],
             ['status','in','range'=>[1,2]],
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
             $friend=new Friend();
             $friend->uid=Yii::$app->user->getId();
             $friend->friend=$this->fid;
             $friend->status=1;
             $friend->created_at=time();
             $friend->updated_at=time();
             if(!$friend->save()){
                 return ["code"=>203,"meg"=>"请求失败"];
             }

             return ["code"=>200,"msg"=>"申请已提交"];
     }

     /*
      * 同意拒绝添加好友
      */
     public function TVS($post)
     {
         $this->scenario=self::CHARSAVE;
         $this->load($post,"");
         if(!$this->validate()){
             return ["code"=>203,"msg"=>current($this->getFirstErrors())];
         }
         $begintransaction=Yii::$app->db->beginTransaction();

     }

}
<?php
namespace common\models;

use Yii;
use yii\base\Model;
use common\api\AliYunPhone;

class SendCode extends Model
{
    /*
     * 手机号码
     */
     public $phone;
     /*
      * 验证码，有本类自动生成
      */
     public $code;
     /*
      * 验证码的失效是时间默认五分钟内
      */
     public $InvalidTime = 5;

     public function rules()
     {
         return [
           [['phone','code'],'required'],
           ['phone', 'string', 'max' => 11,'min'=>11],
           ['InvaliTime','safe'],
           ['InvalidTime','integer']
         ];
     }

     public function attributeLabels()
     {
         return [
           'phone' => '手机号码',
           'code' => '验证码',
           'InvalidTime' => '验证码时间'
         ];
     }

     public function run($param)
     {
         $this->load($param,'');
         if(!$this->validate())
         {
            return ['code'=>203,'msg'=>current($this->getFirstErrors())];
         }
         $name=new AliYunPhone(Yii::$app->params['aliyuncode']);
         $stdclass=$name->setParam($this->phone,$this->code)->run();

         if(strtoupper($stdclass->Code) == 'OK')
         {
             $phonecode=new Phonecode();
             $phonecode->phone=$this->phone;
             $phonecode->code = $this->code;
             $phonecode->created_at=time();
             $phonecode->status = 20;

             if($phonecode->save()){
                 return ['code'=>200,'msg'=>'验证码发送成功'];
             }
             print_r($phonecode->getFirstErrors());
             exit;
         }

         return ['code'=>203,'msg'=>'验证码发送失败'];
     }

     /*
      * 验证验证码
      */
     public function validateCode($param)
     {
         $this->load($param,'');
         if(!$this->validate())
         {
             return ['code'=>203,'msg'=>current($this->getFirstErrors())];
         }

         $new=Phonecode::find()->where(["phone"=>$this->phone,'status'=>20])->orderBy("created_at desc")->one();

         if($new)
         {
            if(strtotime("+".$this->InvalidTime."minute",$new->created_at) < time())
            {
                return ['code'=>203,'msg'=>'验证码已过期'];
            }
            if($new->code != $this->code)
            {
                return ['code'=>203,'msg'=>'验证码错误'];
            }
         $new->status=30;
         if($new->save())  return ['code'=>200,'msg'=>'验证码发送成功'];

         }
         return ['code'=>203,'msg'=>'验证码已使用或未发送'];


     }
}
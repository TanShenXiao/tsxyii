<?php
namespace frontend\models;

use Yii;
use yii\base\Model;
use common\models\Dynamic as dy;

class Dynamic extends Model
{
    /*
     * 发表说说
     */
    /*
     * 说说内容
     */
    public $content;
    /*
     * 说说图片
     */
    public $images;

    public function rules()
    {
        return [
          [["content"],"required"],
          ["images","safe"],
        ];
    }

    public function attributeLabels()
    {
        return [
            "content"=>"发表内容",
            "images"=>"说说图片",
        ];
    }

  /*
   * 发表说说
   */
  public function send($param)
  {
      $this->load($param,"");
      if(!$this->validate($param,"")){
        return ["code"=>203,"msg"=>current($this->getFirstErrors())];
      }
      $uid=Yii::$app->user->getId();
      $dy=new dy();
      $dy->uid=$uid;
      $dy->content=$this->content;
      $dy->images=$this->images;
      $dy->status=1;
      $dy->created_at=time();
      if($dy->save()){
          return ["code"=>200,"msg"=>"发表成功"];
      }
      return ["code"=>203,"msg"=>"发表失败"];
  }

}
<?php
namespace common\models;

use yii\base\Model;
use yii\web\UploadedFile;

class UpFile extends Model
{
    /**
    * @var UploadedFile
    */
    public $imageFile;
    public $basename="img";

    public function rules()
    {
        return [
            [['imageFile'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg,jpeg'],
        ];
    }

    public function upload()
    {
        if ($this->validate()) {
            $dir='./data/' . $this->basename. '.' . $this->imageFile->extension;
            $this->imageFile->saveAs($dir);
         return $dir;
         } else {
             return false;
         }
    }
}
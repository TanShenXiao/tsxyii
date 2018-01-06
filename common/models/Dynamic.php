<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "dynamic".
 *
 * @property integer $id
 * @property integer $uid
 * @property string $content
 * @property string $images
 * @property integer $status
 * @property integer $created_at
 */
class Dynamic extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'dynamic';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['uid', 'status', 'created_at'], 'integer'],
            [['content'], 'required'],
            [['content', 'images'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'uid' => 'Uid',
            'content' => 'Content',
            'images' => 'Images',
            'status' => 'Status',
            'created_at' => 'Created At',
        ];
    }
}

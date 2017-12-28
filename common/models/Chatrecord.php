<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "chatrecord".
 *
 * @property integer $id
 * @property integer $uid
 * @property integer $fid
 * @property string $content
 * @property integer $status
 * @property integer $created_at
 */
class Chatrecord extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'chatrecord';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['uid', 'fid', 'content', 'created_at'], 'required'],
            [['uid', 'fid', 'status', 'created_at'], 'integer'],
            [['content'], 'string', 'max' => 255],
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
            'fid' => 'Fid',
            'content' => 'Content',
            'status' => 'Status',
            'created_at' => 'Created At',
        ];
    }
}

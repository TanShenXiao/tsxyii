<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "friend".
 *
 * @property integer $id
 * @property integer $uid
 * @property integer $friend
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 */
class Friend extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'friend';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['uid', 'friend', 'status', 'created_at', 'updated_at'], 'integer'],
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
            'friend' => 'Friend',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}

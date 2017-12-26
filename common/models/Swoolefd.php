<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "swoolefd".
 *
 * @property integer $id
 * @property integer $uid
 * @property integer $fd
 */
class Swoolefd extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'swoolefd';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['uid', 'fd'], 'integer'],
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
            'fd' => 'Fd',
        ];
    }
}

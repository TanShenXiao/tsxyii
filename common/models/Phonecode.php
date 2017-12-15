<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "phonecode".
 *
 * @property integer $id
 * @property string $phone
 * @property string $code
 * @property integer $status
 * @property string $created_at
 */
class Phonecode extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'phonecode';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['phone', 'code', 'created_at'], 'required'],
            [['status'], 'integer'],
            [['created_at'], 'safe'],
            [['phone'], 'string', 'max' => 11],
            [['code'], 'string', 'max' => 10],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'phone' => 'Phone',
            'code' => 'Code',
            'status' => 'Status',
            'created_at' => 'Created At',
        ];
    }
}

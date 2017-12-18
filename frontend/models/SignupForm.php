<?php
namespace frontend\models;

use yii\base\Model;
use common\models\User;
use common\models\SendCode;

/**
 * Signup form
 */
class SignupForm extends Model
{
    public $username;
    public $phone;
    public $password;
    public $code;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['username', 'trim'],
            ['username', 'required'],
            ['username', 'unique', 'targetClass' => '\common\models\User', 'message' => '用户名已存在'],
            ['username', 'string', 'min' => 2, 'max' => 255],

            ['phone', 'trim'],
            ['phone', 'required'],
            ['phone', 'string', 'max' => 11,'min'=>11],
            ['phone', 'unique', 'targetClass' => '\common\models\User', 'message' => '手机号码已存在'],

            ['password', 'required'],
            ['password', 'string', 'min' => 6],

            ['code','required'],
            ['code','string','length'=>6],
            ['code','validate_code']
        ];
    }

    /*
     * 验证验证码
     */
    public function validate_code($attribute)
    {
        if($this->hasErrors()) return null;
        $param['phone'] = $this->phone;
        $param['code'] = $this->code;
        $code=new SendCode();
        $message=$code->validateCode($param);
        if($message['code'] == 203){
            $this->addError($attribute,$message['msg']);
        }


    }

	public function attributeLabels()
	{
		return [
			'phone' => '手机号码',
			'username' =>'用户名',
			'password' => '密码',
            'code' => '验证码',
			
		];
	}

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function signup()
    {
        if (!$this->validate()) {
            return null;
        }
        
        $user = new User();
        $user->username = $this->username;
        $user->phone = $this->phone;
        $user->setPassword($this->password);
        $user->generateAuthKey();
        
        return $user->save() ? $user : null;
    }
}

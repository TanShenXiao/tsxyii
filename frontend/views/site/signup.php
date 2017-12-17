<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\SignupForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'TanShenXiao-注册';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-signup">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>注册界面</p>

    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>

                <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>

                <?= $form->field($model, 'password')->passwordInput() ?>
                <?= $form->field($model, 'phone')->textInput() ?>
                <?= $form->field($model, 'code')->textInput() ?>
                <div class="input-group-addon"><a id="phone-code" href="javascript:sendcode();">点击获取验证码</a></div>
                <p></p>
                <div class="form-group">
                    <?= Html::submitButton('Signup', ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
                </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
<script type="text/javascript"  >
		function sendcode()
		{
			var phone=$("#signupform-phone");
			window.code =$("#phone-code");
			if(phone.val().length != 11)
			{
				alert("请输入正确的手机号");
				return ;
			}
			code.attr("href","javascript:;");
			code.text("60s");
			
			window.time=60;
			interval=window.setInterval(function (){
				if(time != 0)
			{
				time--;
				code.text(time+"s");
				
			}else if(time <= 0)
			{
				  code.attr("href","javascript:sendcode();");
				  code.text("点击获取验证码");
				  window.clearInterval(interval);  
			}
			},1000);
			
			
		}
	


</script>

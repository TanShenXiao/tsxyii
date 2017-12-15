<?php
namespace common\api;

class AliYunPhone
{
    //接口地址
    public $url="http://dysmsapi.aliyuncs.com";
    //短信签名
    public $signName = '谭深潇';
    //短信密匙
    public $accessKeyId = "LTAImr8hN2asIWn7"; // AccessKeyId
    //密匙
    public $accessKeySecret = "Kgrp84MF1ozUon8a6P6WjmNBSVN4s6";
    // 暂时不支持多Region
    public $region = "cn-hangzhou";
    //手机号码
    public $PhoneNumbers = '18323477096';
    // 服务结点
    public $endPointName = "cn-hangzhou";
    //接受数据类型
    public $format="JSON";
    //请求方式
    public $request_type="POST";
    //模板变量
    public $templateParam="{'code'=>1234567}";
    //短信模板id
    public $TemplateCode = "SMS_116562354";
    public $resource = '/topics/sms.topic-cn-shanghai/messages';
    //参数
    public $param=[];


    /*
     * 发送验证码
     */
    public function run()
    {
        $this->curl($this->url,"",$this->getParam());
    }
    //获取参数
    public function getParam()
    {
        $param =[];
        $param['PhoneNumbers'] = '18323477096';
        $param['SignName'] = '谭深潇';
        $param['TemplateCode'] = 'SMS_116562354';
        $param['TemplateParam'] = '{"code":"12345"}';
        $param['OutId'] = 'yourOutId';
        $param['SmsUpExtendCode'] = '1234567';
        $param['RegionId'] = 'cn-hangzhou';
        $param['AccessKeyId'] = 'LTAImr8hN2asIWn7';
        $param['Format'] = 'JSON';
        $param['SignatureMethod'] = 'HMAC-SHA1';
        $param['SignatureVersion'] = '1.0';
        $param['SignatureNonce'] = '416775a30e13ee9bdb6.45620519';
        $param['Timestamp'] = '2017-12-13T08:13:50Z';
        $param['Action'] = 'SendSms';
        $param['Version'] = '2017-05-25';
        $param['Signature'] = 'byR7X3sn2HiagINhdfs1G9i+TQo=';
        return $param;
    }
   /*
    * 发送请求
    */
    public static function curl($url, $httpMethod = "GET", $postFields = null,$headers = null)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_FAILONERROR, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, is_array($postFields) ? self::getPostHttpBody($postFields) : $postFields);


        echo "<pre>";
        print_r(curl_exec($ch));
        echo "<br>";

        print_r(curl_getinfo($ch, CURLINFO_HTTP_CODE));
        if (curl_errno($ch))
        {
            echo "error";
        }
        curl_close($ch);
    }

    //参数编码
    static function getPostHttpBody($postFildes){
        $content = "";
        foreach ($postFildes as $apiParamKey => $apiParamValue)
        {
            $content .= "$apiParamKey=" . urlencode($apiParamValue) . "&";
        }
        return substr($content, 0, -1);
    }


}
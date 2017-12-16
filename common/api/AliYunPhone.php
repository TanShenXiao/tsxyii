<?php
namespace common\api;


class AliYunPhone
{
    //接口地址
    public $Url;
    //短信签名
    public $SignName;
    //短信密匙
    public $AccessKeyId; // AccessKeyId
    //密匙
    public $AccessKeySecret;
    // 暂时不支持多Region
    public $RegionId = "cn-hangzhou";
    //手机号码
    public $PhoneNumbers;
    // 服务结点
    public $EndPointName = "cn-hangzhou";
	//时间格式
	public $DateTimeFormat = 'Y-m-d\TH:i:s\Z'; 
	//签名方式
	public $SignatureMethod = "HMAC-SHA1";
	//签名版本固定值 1.0
	public $SignatureVersion = "1.0";
	//生成一个唯一值
	public $SignatureNonce;
	//当前时间
	public $Timestamp;
	//当前api的命名
	public $Action  = "SendSms";
	//api的版本
	public $Version = "2017-05-25";
	//签名
	public $signature;
    //接受数据类型
    public $Format="JSON";
    //请求方式
    public $Request_type="POST";
    //模板变量
    public $TemplateParam;
    //短信模板id
    public $TemplateCode = "SMS_116562354";
    //参数
    public $param=[];

    public function __construct(array $config)
    {
		$this->Url=$config['Url'];
		$this->SignName = $config['SignName'];
		$this->AccessKeyId = $config['AccessKeyId'];
		$this->AccessKeySecret = $config['AccessKeySecret'];
		$this->TemplateCode = $config['TemplateCode'];
		
    }

    /*
     * 发送验证码
     */
    public function run()
    {
        return $this->curl($this->Url,$this->Request_type,$this->param);
    }
    //获取参数
    public function setParam($phone,$code)
    {
        $this->PhoneNumbers=$phone;
        $this->TemplateParam='{"code":"'.$code.'"}';
        $param =[];
        $param['PhoneNumbers'] = $this->PhoneNumbers;
        $param['SignName'] = $this->SignName;
        $param['TemplateCode'] = $this->TemplateCode;
        $param['TemplateParam'] = $this->TemplateParam;
        $param['RegionId'] = $this->RegionId;
        $param['AccessKeyId'] = $this->AccessKeyId;
        $param['Format'] = $this->Format;
        $param['SignatureMethod'] = $this->SignatureMethod;
        $param['SignatureVersion'] = $this->SignatureVersion;
        $param['SignatureNonce'] = uniqid(mt_rand(1,100),1);
		date_default_timezone_set("GMT");
        $param['Timestamp'] = date($this->DateTimeFormat);
        $param['Action'] = $this->Action;
        $param['Version'] = $this->Version;
        $param['Signature'] = $this->sign($param);
        $this->param=$param;

        return $this;
    }
   /*
    * 发送请求
    */
    public static function curl($url, $httpMethod = "pos", $postFields = null,$headers = null)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $httpMethod);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_FAILONERROR, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, is_array($postFields) ? self::getPostHttpBody($postFields) : $postFields);



        $path=json_decode(curl_exec($ch));
       curl_close($ch);
        return $path;
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
	//签名
	public function sign($txt)
	{
		ksort($txt);
		$QueryString="";
		foreach($txt as $key => $value)
		{
			$QueryString.='&'.$this->precentEncode($key).'='.$this->precentEncode($value);
		}
		$stringToSign=$this->Request_type.'&%2F&'. $this->precentEncode(substr($QueryString, 1));
		
		return	base64_encode(hash_hmac('sha1', $stringToSign, $this->AccessKeySecret."&", true));
		
	}
	
	//对数据进行编码
	protected function precentEncode($str)
	{
		$res=urlencode($str);
		$res = preg_replace('/\+/', '%20', $res);
	    $res = preg_replace('/\*/', '%2A', $res);
	    $res = preg_replace('/%7E/', '~', $res);
		
		return $res;
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	

}
<?php

/* @var $this yii\web\View */

$this->title = 'TanShenXiao-聊天';
?>
<style>
    .footer{
        display:none;
    }
	a{
		color:#fff;
	}
	.wrap > .container{
		padding: 55px 0px 0px;
		width:100%;
	}
	.title-icon{
		display:inline-block;
		float:left;
		margin-top:15px;
	}
    .title{
		position: fixed;
        border-color:#337ab7;
		background-color:#337ab7;
        height:50px;
        line-height:50px;
        font-size:larger;
        color:#fff;
		margin:0px;
		width:100%;
        border-radius:10px;
        padding-left:20px;
		text-align:center;
		z-index:10;
    }
	.content{
		
		 border-radius:10px;
		 margin-top:55px;
		 padding:10px;
		 height:100%;
	}
	.bottom{
		height:60px;
		border-radius:10px;
		padding:10px;
		padding-left:20px;
		text-align:center;
		
	}
	.form-control{
		width:70%;
		float:left;
		margin:auto 0px;
		border:2px solid #337ab7;
		 border-radius:10px;
		 
	}
	.btn-primary{
		 border-radius:10px;
	}
	.but{
		height:100px;
		border:1px solid red;
	}
	*{ margin:0; padding:0; border:0; outline:0; font-family:"Microsoft YaHei";}
body{ font-size:12px;}
#box{ width:200px; height:200px; background:orange; position:absolute; left:0; top:0;} 

.f-cb{ zoom:1;}
.f-cb:after,.f-cb:before{ clear:both; content:""; display:table; height:0; }


ul{ list-style:none;}
.m1 { position:relative; }
.m1:after,.m1:before { clear:both; content:""; display:table; height:0; margin-bottom:20px;}
.m1 dt a{ font-size:24px;width:60px; height:60px; background:#337ab7; display:inline-block; text-align:center; line-height:60px; }
.m1 dd{ max-width:274px;  border-radius:3px; padding:10px ;  background:#93e653; box-sizing:border-box; position:relative;}
.m1 dd:before{ position:absolute; bottom:5px;  content:""; border-width:10px; border-style:solid; }
.m1.he dd:before,.m1.vhe dd:before{ left:-20px; border-color:transparent #93e653  transparent transparent;   }
.m1.me dd:before,.m1.vme dd:before{ right:-20px; border-color:transparent  transparent transparent   #93e653; }
.m1.he dt { float:left; }
.m1.he dd{ margin-left:20px; margin-top:20px ;float:left; }
.m1.me dt { float:right; margin-left:20px;}
.m1.me dd { float:right; margin-top:20px;}

.m1.he dt a{ float:left; }
.m1.he dt span{ display:block; float:left;  margin-right:-200px; color:#666; margin-left:20px;}

.m1.me dt a{ float:right; }
.m1.me dt span{ display:block; float:right;  margin-left:-200px; color:#666; margin-right:20px;}


.m1.vhe dt a{ position:absolute; bottom:0; }
.m1.vhe dt span{ padding-left:80px; }
.m1.vhe dd{ margin-left:80px; margin-top:5px;}
 
.m1.vme dt a{ position:absolute; bottom:0; right:0;}
.m1.vme dt span{ padding-right:80px; text-align:right; display:block; }
.m1.vme dd{ margin-right:80px; margin-top:5px; float:right;}



a:link,a:visited {
	color: black;
	text-decoration: none;
}
a:hover,a:active {
	text-decoration: underline;
}



.m02{ width:318px; border:1px solid #999; margin-left:20px;  }
.m2 li{ clear:both; display:table; padding-left:20px;}
.m2{ width:168px;  }
.m2 li a{float:left; max-width:168px; overflow:hidden; white-space:nowrap; text-overflow:ellipsis; }
.m2 li span{ float:left; padding-left:10px; margin-right:-100px;}

</style>
<div class="title"><a href="/char/index"><span class="title-icon glyphicon glyphicon-menu-left"></a></span><?=$data['username']?></div>
<div class="content" id="container-txt">
    <?php foreach($data['record'] as $val):
        if($val['uid'] == $data['id']){
    ?>
            <dl class="vhe m1">
                <dt><a><?=mb_substr($data['username'],0,1,'utf-8')?></a><span><?=date("Y-m-d H:i:s",$val["created_at"])?></span></dt>
                <dd><?=$val['content']?></dd>
            </dl>
     <?php  }              ?>
        <dl class="me m1">
            <dt><a><?= mb_substr(Yii::$app->user->identity->username, 0, 1,'utf-8')?></a><span><?=date("Y-m-d H:i:s",$val["created_at"])?></span></dt>
            <dd><?=$val['content']?></dd>
        </dl>

    <?php endforeach;                 ?>




</div>
<div class="navbar-fixed-bottom bottom">
<input class="form-control" type="text" id="content" ><button type="button" class="btn btn-primary" onclick="send();">发送</button>
</div>
<input type="hidden" value="<?=Yii::$app->user->identity->id?>" id="userid">
<input type="hidden" value="<?=$data['id'];?>" id="senduid">
<script type="text/javascript">
//websocket
 var ws = new WebSocket("ws:120.77.37.194:9501");
    ws.onopen = function(){
			var txt="tsx-save"+"94bb8b5325d0c835"+$("#userid").val();
               ws.send(txt);
               };
	ws.onmessage = function (evt){ 
                var received_msg = evt.data;
				var time=getTime();
                var content='<dl class="he m1"><dt><a><?=mb_substr($data['username'],0,1,'utf-8')?></a><span>'+time+'</span></dt><dd>'+received_msg+'</dd></dl>';
				$("#container-txt").append(content);
				$(window).scrollTop($(document).height());
               };
	
	ws.onclose = function(){ 
                  // 关闭 websocket
                  alert("连接已关闭..."); 
               };
			        
			   
 function send(){
 var txt=$("#userid").val()+"94bb8b5325d0c835"+$("#senduid").val()+"94bb8b5325d0c835"+$("#content").val();
	 if(txt == ""){
		 return ;
	 }
	 var time=getTime();
	   ws.send(txt);
	 var content='<dl class="vme m1"><dt><a><?= mb_substr(Yii::$app->user->identity->username, 0, 1,'utf-8')?></a><span>'+time+'</span></dt><dd>'+$("#content").val();+'</dd></dl>';
	 $("#container-txt").append(content);
	 $("#content").val('');

	 $(window).scrollTop($(document).height());
 }
 
 function getTime()
 {
	 var myDate = new Date();
	 var Year=myDate.getFullYear();
	 var Month=myDate.getMonth();   
	 var Da=myDate.getDate();   
	 var Hours=myDate.getHours();    
	 var Minutes=myDate.getMinutes();     
	 var Time=myDate.getSeconds();     
	
	 return Year+"年-"+Month+"月-"+Da+"日 "+Hours+"时:"+Minutes+"分:"+Time+"秒";
	 
 }

</script>
























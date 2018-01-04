<?php

/* @var $this yii\web\View */

$this->title = 'TanShenXiao-聊天';
?>
<style>
    .footer{
        display:none;
    }
	.title{
		border:1px solid red;
		
	}
    .row{
        margin:0px;
    }
	.wrap > .container{
		padding: 55px 0px 0px;
		
		width:100%;
	}
    .table-bordered{
        border-color:#337ab7;
        height:50px;
        line-height:50px;
        font-size:larger;
        color:#337ab7;
        padding-left: 20px;
        margin:10px;
    }
    .badge{
        background-color:#337ab7;
        margin:14px 0px;
    }
    .top-left{
        width:100px;
        height:50px;
        text-align:center;
        float:right;
        line-height:50px;
        vertical-align: middle;
    }
    .navbar-tsx{
        display:flex;
        text-align: center;
        background:#fff;
    }
	.botton{
		float:right;
		margin-right:10px;
		padding:0px;
		display:block;
		text-align:right;
	}
	.bth{
		padding:0px;
	}
	.col{
		padding:0px;
		margin:10px;
	}
	
	.row > div{
		margin-left:10px;
	}
	strong{
		color:red;
	}

</style>
<form action="/char/friends" action="get">
<div class="row">
  <div class="col col-xs-9" style="margin-right:0px;">
    <input type="text" name="serach" class="form-control" required placeholder="这里可以搜索好友，也可以添加好友">
  </div>
  <div class="col col-xs-2 botton" style="margin-left:0px;">
    <button type="submit" class="btn btn-primary">搜索</button>
  </div>
</div>
</form>

    <div class="row">
		<?php 
			$serach=Yii::$app->request->get();
			if(isset($serach['serach']) and !empty($serach['serach'])){
		?>
		<div >一共搜索到<strong><?=count($data["user"])?></strong>个好友，<strong><?=count($data["yk"])?></strong>个不认识的人。<a href="/char/friends">返回</a></div>
		
		<?php
			foreach($data['yk'] as $item):
		?>
		    <div class="table-bordered"><?=$item['username']?><div class="top-left"><a href="javascript:s(<?=$item['id']?>);">添加好友</a></div></div>

		<?php
			endforeach; 
			}
		?>
        <?php foreach($data['user'] as $item):  ?>
            <a href="/char/tx?id=<?=$item['id']?>"><div class="table-bordered"><?=$item['username']?><div class="top-left"></div></div></a>
        <?php endforeach;             ?>
    </div>
<ul class="nav nav-pills navbar-fixed-bottom row navbar-tsx">
    <li role="presentation" class="col-xs-4"><a href="/char/index">聊天</a></li>
    <li role="presentation" class="col-xs-4 active"><a href="/char/friends">好友</a></li>
    <li role="presentation" class="col-xs-4"><a href="/char/dynamic">动态</a></li>
</ul>
<script type="text/javascript">
    function s(id){
        var csrf=$("#csrf").val();
       $.post({
           url:"/handel/add-char",
           data:{"fid":id,"_csrf-frontend":csrf},
           datatype:"json",
           success:function (json){
               alert(json.msg);
           }
       });
    }
</script>
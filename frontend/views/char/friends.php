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
        width:60px;
        height:50px;
        text-align:center;
        float:right;
        line-height:50px;
        vertical-align: middle;
    }
    .navbar-tsx{
        display:flex;
        text-align: center;
    }

</style>
<div class="row">
  <div class="col-xs-8">
    <input type="text" class="form-control" placeholder=".col-xs-8">
  </div>
  <div class="col-xs-2">
    <button type="submit" class="btn btn-primary">搜索好友</button>
  </div>
  <div class="col-xs-2">
   <button type="submit" class="btn btn-primary">搜索好友</button>
  </div>
</div>

    <div class="row">
        <?php foreach($data as $item): ?>
            <a href="/char/tx?id=<?=$item['id']?>"><div class="table-bordered"><?=$item['username']?><div class="top-left"></div></div></a>
        <?php endforeach;             ?>
    </div>
<ul class="nav nav-pills navbar-fixed-bottom row navbar-tsx">
    <li role="presentation" class="col-xs-4"><a href="/char/index">聊天</a></li>
    <li role="presentation" class="col-xs-4 active"><a href="/char/friends">好友</a></li>
    <li role="presentation" class="col-xs-4"><a href="#">动态</a></li>
</ul>
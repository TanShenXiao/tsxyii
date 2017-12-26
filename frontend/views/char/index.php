<?php

/* @var $this yii\web\View */

$this->title = 'TanShenXiao-聊天';
?>
<style>
    .footer{
        display:none;
    }
    .table-bordered{
        border-color:#337ab7;
        height:50px;
        line-height:50px;
        font-size:larger;
        color:#337ab7;
        border-radius:20px;
        padding-left: 20px;
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
        <?php foreach($data as $item): ?>
            <a href="/char/tx?id=<?=$data['id']?>"><div class="table-bordered"><?=$item['username']?><div class="top-left"><span class="badge">1</span></div></div></a>
        <?php endforeach;             ?>
    </div>
<ul class="nav nav-pills navbar-fixed-bottom row navbar-tsx">
    <li role="presentation" class="active col-xs-4"><a href="/char/index">聊天</a></li>
    <li role="presentation" class="col-xs-4"><a href="">好友</a></li>
    <li role="presentation" class="col-xs-4"><a href="#">动态</a></li>
</ul>
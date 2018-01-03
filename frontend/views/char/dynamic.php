<?php

/* @var $this yii\web\View */

$this->title = 'TanShenXiao-聊天';
$id=Yii::$app->user->getId();

$root=$_SERVER['SERVER_NAME'];
?>
<style>
    .footer{
        display:none;
    }
    .navbar-tsx{
        display:flex;
        text-align: center;
    }
    .wrap > .container{
        padding: 50px 0px 0px;
        width:100%;
    }
    a{
        text-decoration:none;
    }
    .top{
        margin:0px auto;
        position:relative;
    }
    .top > img{
        width:100%;
    }
    .top-tx{
        height:100px;
        position:absolute;
        bottom:-50px;
        right:6px;
        padding-left:20px;
        padding-right: 20px;
        background:rgb(80,87,141);
        text-align: center;
        line-height: 100px;
        border:2px solid #ffffee;
        box-shadow:2px 2px 2px #000;
        color:rgb(203,193,206);
        font-weight: 900;
        min-width:100px;
    }
    .content{
        margin-top:10px;
    }
    .content-tx{
        width:50px;
        height:50px;
        text-align:center;
        background:rgb(80,87,141);
        float:left;
        margin-right:6px;


    }
    .content-tx-left{
        padding:10px;
        border-bottom: 1px solid rgb(80,87,141);
    }
    .content-tx-left-top{
        height:50px;
        line-height: 50px;
        color:rgb(203,193,206);
        font-weight: 900;
        font-size:18px;
    }
    .content-tx-left-jz{
        margin:10px 0px;
    }
    .content-tx-left-bottom{
        font-size:4px;
    }
    .title{
        height:50px;
    }
    .title ul{
        list-style-type:none;
        padding:0px;
        margin:0px;
    }
    .title ul li{
        display:block;
        height:50px;
        width:60px;
        float:left;
        margin-left:4px;
        text-align: center;
        line-height: 50px;
        color:rgb(80,87,141);
    }


</style>
<div class="top">
    <img src="../data/bj.jpg">
    <div class="top-tx">谭潇;lajlanga</div>
</div>
<div class="title">
   <ul>
       <li>所有</li>
       <li>自己</li>
       <li class="active">发表</li>
       <li>背景</li>
   </ul>
</div>
<div class="content">
    <div class="content-tx-left">
        <div class="content-tx-left-top"><div class="content-tx">韩</div>大义</div>
        <div class="content-tx-left-jz">sakjhnglkajngkjnakljhkuay</div>
       <div class="content-tx-left-bottom">时间：<?=date("Y-m-d H:i:s")?></div>
    </div>
    <div class="content-tx-left">
        <div class="content-tx-left-top"><div class="content-tx">贾</div>超</div>
        <div class="content-tx-left-jz">sakjhnglkajngkjnakljhkuay</div>
       <div class="content-tx-left-bottom">时间：<?=date("Y-m-d H:i:s")?></div>
    </div>
</div>
<ul class="nav nav-pills navbar-fixed-bottom row navbar-tsx">
    <li role="presentation" class="col-xs-4"><a href="/char/index">聊天</a></li>
    <li role="presentation" class="col-xs-4"><a href="/char/friends">好友</a></li>
    <li role="presentation" class="col-xs-4 active"><a href="#">动态</a></li>
</ul>

<script>


</script>
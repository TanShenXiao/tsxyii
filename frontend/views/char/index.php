<?php

/* @var $this yii\web\View */

$this->title = 'TanShenXiao-聊天';
$id=Yii::$app->user->getId();
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
    .table-borderedz{
        border:2px solid #35ffdc;
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
        width:120px;
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
    a{
        text-decoration:none;
    }

</style>
    <div class="row">
        <?php foreach($data as $item): ?>
            <a href="javascript:;"><div class="table-borderedz"><?=$item['username']?>，请求添加你为好友。<div class="top-left">-<a href="javascript:s('<?=$id?>','<?=$item['id']?>',1);">同意</a>--<a href="javascript:s('<?=$id?>','<?=$item['id']?>',2);">拒绝</a>-</div></div></a>
            <!---            <a href="/char/tx?id=<?=$item['id']?>"><div class="table-bordered"><?=$item['username']?><div class="top-left"><?=$item['num'] > 0?"<span class='badge'>".$item['num']."</span>":""?></div></div></a>
-->
        <?php endforeach;             ?>
    </div>
<ul class="nav nav-pills navbar-fixed-bottom row navbar-tsx">
    <li role="presentation" class="active col-xs-4"><a href="/char/index">聊天</a></li>
    <li role="presentation" class="col-xs-4"><a href="/char/friends">好友</a></li>
    <li role="presentation" class="col-xs-4"><a href="/char/dynamic">动态</a></li>
</ul>

<script>
    function s(uid,fid,status){
        var csrf=$("#csrf").val();
        $.post({
            url:"/handel/char-save",
            data:{"fid":fid,"status":status,"_csrf-frontend":csrf},
            datatype:"json",
            success:function (json){
                if(json.code == 203){
                    alert(json.msg);
                }
                if(json.code == 200){
                    alert(json.msg);
                    location.reload();
                }
            }
        });
    }


</script>
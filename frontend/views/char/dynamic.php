<?php

/* @var $this yii\web\View */

$this->title = 'TanShenXiao-聊天';
$id=Yii::$app->user->getId();
$user=Yii::$app->user->identity;
$csrf=Yii::$app->request->csrfToken;
$this->registerJsFile("@web/js/scrollPic.js",['position'=>$this::POS_END]);

$root=$_SERVER['SERVER_NAME'];
?>
<style>
    .footer{
        display:none;
    }
    .navbar-tsx{
        display:flex;
        text-align: center;
        background:#fff;
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
        height:88px;
        width:88px;
        position:absolute;
        bottom:-50px;
        right:6px;
        background:rgb(80,87,141);
        text-align: center;
        border:2px solid #ffffee;
        box-shadow:2px 2px 2px #000;
        color:rgb(203,193,206);
        font-weight: 900;

    }
    .top-tx img{
        width:100%;
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
    .content-tx img{
        width:100%;
        height:100%;
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
        margin-top:10px;
        font-size:12px;
    }
    .title{
        height:50px;
        cursor:hand;
    }
    .title ul{
        list-style-type:none;
        padding:0px;
        margin:0px;
        margin-top:50px;
    }
    .title ul li{
        display:block;
        height:40px;
        width:60px;
        float:left;
        margin-left:4px;
        text-align: center;
        line-height: 40px;
        color:rgb(80,87,141);
    }
    .at{
        display:none;
        position: fixed;
        top:0px;
        left:0px;
        width:100%;
        height:100%;
        background:rgba(80,87,141,0.2);
    }
    .at-content{
        width:70%;
        background:#ffffee;
        position: fixed;
        left:50%;
        top:50%;
        transform:translate(-50%,-50%);
        -webkit-transform:translate(-50%,-50%);
        -moz-transform:translate(-50%,-50%);
    }
    .at-wh{
        width:100%;
        height:100%;
    }
    .tx > .title{
        height:40px;
        line-height: 40px;
        text-align: center;

    }

    .tx-content{

        width:60%;
        margin:0px auto;
    }
    .tx-content img{
        width:100%;
    }
    .tx-bottom{
        text-align: center;
        margin-top: 40px;
        margin-bottom: 40px;

    }
    .btn-primary{
        position:relative;
        margin-bottom: 10px;
    }
    .btn{
        width:60%;
    }
    .tx-file{
        top:0px;
        left:0px;
        position:absolute;
        opacity:0;
        width:100%;
    }
    .tx-x{display:none}
    .bj-x{display:none}
    .fb-x{display:none}
    .fb-content{
        width:100%;
    }
    .fb-content textarea{
        width:100%;
        height:100px;
        border:0px;
    }
    .fb-img{
        list-style-type:none;
        padding:0px;
        margin:0px;


    }
    .fb-img li{
        display:block;
        width:55px;
        height:55px;
        float:left;
        margin:2px;
        position: relative;
    }
    .fb-img li img{
        width:55px;
        height:55px;
    }
    .fb-img li span{
        position:absolute;
        top:0px;
        left:45px;
    }
    .active1{
        background:#00b3ee;
    }
    .content-imags ul{
        list-style-type: none;
        padding:0px;
        margin:0px;
    }
    .content-imags ul li{
        width:100px;
        height:100px;
        float:left;
        display:inline;
        margin:5px;
        overflow: hidden;
    }
    .content-imags ul li img{
        width:100%;
    }
    .glyphicon-right{
        position:fixed;
        z-index:101;
        border:2px solid rgb(80,87,141);
        top:50%;
        right:10px;
        width:30px;
        height:60px;
        background:#ffffee;
        line-height:60px;
        text-align:center;
        display:none;



    }

    .glyphicon-left{
        position:fixed;
        z-index:101;
       top:50%;
        left:10px;
        border:2px solid rgb(80,87,141);
        width:30px;
        height:60px;
        line-height:60px;
        text-align:center;
        background:#ffffee;
        display:none;
    }
    .images-title{
        position:fixed;
        top:55px;
        left:0px;
        width:100%;
        height:40px;
        z-index:101;
        background:#3c3c3c;
        color:#ffffee;
        line-height: 40px;
        padding-left:10px;
        padding-right:10px;
        text-align:center;
        display:none;
    }
    .images-title span{
        float:left;
        line-height: 40px;
        height:40px;
    }
</style>
<div class="top">
    <img src="<?=$user->bgimg?>">
    <div class="top-tx"><img src="<?=$user->logo?>"></div>
</div>
<div class="title">
   <ul>
       <a href="/char/dynamic"><li class="<?=$own == false?'active1':'';?>">所有</li></a>
       <a href="/char/dynamic?own=1"><li class="<?=$own == true ?'active1':'';?>">自己</li></a>
       <li onclick="fb();">发表</li>
       <li onclick="bj();">背景</li>
       <li onclick="t();">头像</li>
   </ul>
</div>
<div class="content">
    <?php foreach($data as $val):  ?>
    <div class="content-tx-left">
        <div class="content-tx-left-top"><div class="content-tx"><img src="<?=$val['logo']?>"></div><?=$val['username']?></div>
        <div class="content-tx-left-jz"><?=$val['content']?></div>
        <div class="content-imags">
            <ul id="image<?=$val["id"]?>">
                <?php
                $array=explode(",",trim($val['images'],","));
                $i=0;
                foreach ($array as $img):
                    if(!empty($img)):
                        echo "<li><img num='{$i}' src='{$img}' class='seeimage'></li>";
                        $i++;
                    endif;
                endforeach;
                ?>
            </ul>
        </div>
        <div style="clear: both;"></div>
       <div class="content-tx-left-bottom">时间：<?=date("Y-m-d H:i:s",$val['created_at'])?></div>
    </div>
    <?php endforeach;       ?>
    <div class="images-title"><span class="img-colse glyphicon glyphicon-menu-left"></span><strong id="imgs"></strong>/<strong id="total"></strong></div>
    <span id="imageleft" class="glyphicon glyphicon-menu-left glyphicon-left"></span>
    <span id="imageright" class="glyphicon glyphicon-menu-right glyphicon-right"></span>
</div>
<ul class="nav nav-pills navbar-fixed-bottom row navbar-tsx">
    <li role="presentation" class="col-xs-4"><a href="/char/index">聊天</a></li>
    <li role="presentation" class="col-xs-4"><a href="/char/friends">好友</a></li>
    <li role="presentation" class="col-xs-4 active"><a href="/char/dynamic">动态</a></li>
</ul>
<div class="at" >
    <div class="at-content">
        <!-------------logo------------->
       <div class="at-wh tx tx-x">
            <div class="title">上传logo</div>
            <div class="tx-content">
                <img id="logoimg" src="<?=$user->logo?>">
            </div>
           <div class="tx-bottom">
                   <button type="button" class="btn btn-primary">上传logo<input type="file" id="loginfile" name="imageFile" class="tx-file" /></button>
                   <button type="button" class="btn btn-success" id="tx-button">保存</button>
                   <input type="hidden" name="_csrf-frontend" value="<?=$csrf?>"/>
            </div>
        </div>
        <!-------------背景------------->
        <div class="at-wh tx bj-x">
        <div class="title">上传背景图</div>
        <div class="tx-content">
            <img id="bgimg" src="<?=$user->bgimg?>">
        </div>
        <div class="tx-bottom">
            <button type="button" class="btn btn-primary">上传背景图<input type="file" id="bgfile" name="imageFile" class="tx-file" /></button>
            <button type="button" class="btn btn-success" id="bg-button">保存</button>
            <input type="hidden" name="_csrf-frontend" value="<?=$csrf?>"/>
        </div>
        </div>
        <!-------------发表动态-------------->
        <div class="at-wh tx fb-x">
            <div class="title">发表动态</div>
            <div class="fb-content">
                <textarea id="ss-txt" placeholder="想说点什么。。。。。。"></textarea>
            </div>
            <ul class="fb-img" id="ssimg" >
            </ul>
            <div style="clear: both;"></div>
            <div class="tx-bottom">
                <button type="button" class="btn btn-primary">上传说说图片<input type="file" id="ssfile" name="imageFile" class="tx-file" /></button>
                <button type="button" class="btn btn-success" id="ss-button">发表说说</button>
                <input type="hidden" name="_csrf-frontend" value="<?=$csrf?>"/>
            </div>
        </div>
    </div>
        <script>
        function t()
        {
            $(".at").show();
            $(".tx-x").show();
        }
        function bj()
        {
            $(".at").show();
            $(".bj-x").show();
        }
        function fb()
        {
            $(".at").show();
            $(".fb-x").show();
        }
        window.onload=function (){
            $(".at").click(function (ev){
                $(".at").hide();
                $(".at-content > div").hide();
         });
        $(".at-wh").click(function (ev)
        {
            var oEvent = ev || window.event;
            oEvent.stopPropagation();

        });
        /*
        上传logo
         */
        $("#loginfile").change(function (){
            upfile("#loginfile","#logoimg",1,0);
        });
        /*
        上传背景
        */
        $("#bgfile").change(function (){
            upfile("#bgfile","#bgimg",2,0);
        })
        /*
        说说图片
         */
        $("#ssfile").change(function (){
            upfile("#ssfile","#ssimg",2,1);
        });

        $("#tx-button").click(function (){
            var dir=$("#logoimg").attr("src");
            change({"_csrf-frontend":"<?=$csrf?>","img":dir,"type":1},"/char/edit-logo");
        })
        $("#bg-button").click(function (){
            var dir=$("#bgimg").attr("src");
            change({"_csrf-frontend":"<?=$csrf?>","img":dir,"type":2},"/char/edit-logo");
        })
        /*
        发表说说
         */
        $("#ss-button").click(function (){
            var images="";
            $.each($(".fassimg"),function (a,b){
                images+=$(b).attr('src')+",";
            })
            var content=$("#ss-txt").val();
            change({"_csrf-frontend":"<?=$csrf?>","images":images,"content":content},"/char/pulish");
        })
         $(".img-colse").click(function (){
           location.reload();

         })


        function upfile(clas1,clas2,type,append){
            var formData = new FormData();
            formData.append("imageFile",$(clas1).get(0).files[0]);
            formData.append("type",type);
            formData.append("_csrf-frontend","<?=$csrf?>");
            $.post({
                url: "/char/upfile",
                data: formData,
                datatype: "json",
                processData: false,
                contentType: false,
                success: function (json) {
                   if(json.code == 203){
                       alert(json.msg);
                   }
                   if(json.code == 200){
                       if(append){
                          $(clas2).append('<li><img class="fassimg" src=".'+json.dir+'"><a href="javascript:;"><span onclick="de(this);" class="glyphicon glyphicon-remove"></span></a></li>');
                       }else{
                           $(clas2).attr("src","."+json.dir);
                       }

                   }
                }
            });
        }

        function change(obj,url){
            $.post({
                url:url,
                data: obj,
                datatype:'json',
                //processData: false,
                //contentType: false,
                success: function (json) {
                    if(json.code == 203){
                        alert(json.msg);
                    }
                    if(json.code == 200){
                       location.reload();
                    }
                }
            });
        }

            /*
         查看说说图片
          */
            $(".seeimage").click(function ()
            {
                var ul=$(this).parent("li").parent("ul");
                var jsonul={
                    position:"fixed",
                    "z-index":100,
                    top:"0px",
                    left:"0px",
                    "height":"100%",
                    "overflow":"scroll",

                    background:"rgba(0,0,0,0.8)",
                };
                var jsonli={
                    width:$(window).width()+"px",
                    height:"100%",
                    margin:"0px",
                    float:"left",
                    "padding-top":"100px",
                    display:"inline",

                };

                var jsonimg = {
                "vertical-align":"middle",
                    "width":$(window).width()+"px",
                    "max-height":$(window).height()-140+"px",

                };
                ul.css(jsonul);
                ul.children("li").css(jsonli);
                ul.children("li").children("img").css(jsonimg);
                $(".glyphicon-left").css({"display":"block"});
                $(".glyphicon-right").css({"display":"block"});
                $(".images-title").css({"display":"block"});
                $("#imageright").attr("onclick","return null;");
                $("#total").text(ul.children("li").children("img").length);
                var id=ul.attr("id");
                var num=$(this).attr("num");
                scrollPic(id,num);

            })

        }
        /*
        删除元素
        */
        function de(th)
        {
            $(th).parent().parent("li").remove();
        }

        function scrollPic(contentid,num)
        {
            var width=$(window).width();
            var scrollPic = new ScrollPic();
            scrollPic.scrollContId   = contentid; //内容容器ID
            scrollPic.arrLeftId      = "imageleft";//左箭头ID
            scrollPic.arrRightId     = "imageright"; //右箭头ID

           // scrollPic.dotListId      = "FS_numList_01";//点列表ID


          //  scrollPic.listType     = "number";//列表类型(number:数字，其它为空)

            scrollPic.frameWidth     = width;//显示框宽度
            scrollPic.pageWidth      = width; //翻页宽度

            scrollPic.speed          = 10; //移动速度(单位毫秒，越小越快)
            scrollPic.space          = 10; //每次移动像素(单位px，越大越快)
            scrollPic.autoPlay       = false; //自动播放
            scrollPic.autoPlayTime   = 3; //自动播放间隔时间(秒)

            scrollPic.initialize(); //初始化
            scrollPic.pageTo(num)
        }

</script>
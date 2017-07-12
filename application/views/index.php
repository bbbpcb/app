<!DOCTYPE html>
<html lang="zh-cn">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>九州资本</title>
<meta name="keywords" content="九州资本" />
<meta name="description" content="九州资本官方网站" />
<link type="text/css" href="<?=base_url()?>static/css/style.css"  rel="stylesheet" />
<script type="text/javascript" src="<?=base_url()?>static/js/jquery.js" ></script>
<script type="text/javascript" src="<?=base_url()?>static/js/jquery.SuperSlide.2.1.1.js"></script>
    <!--[if IE 6]>
    <script src="http://www.cs9z.com/static/js/iepng.js" type="text/javascript"></script>
    <script type="text/javascript">
        EvPNG.fix('div,ul,img,li,dl,dd,dt,input,h1,a,a:hover,span');
    </script>
    <![endif]-->
</head>

<body>

<!--  * header *  -->
<?php Widget::navigate();?>

<!--  * 轮播图  *  -->
<div id="imageShow">
    <ul class="imagebg">
        <?php
            foreach($banner as $k =>$v){
        ?>
        <li class="bannerbg">
            <div class="bannerbg_main" style="background:url(<?=base_url()?>uploads/banner/<?=$v['pic']?>) center no-repeat;">
                <div class="banner" onClick="window.open('<?=$v['url']?>');">
                </div>
            </div>
        </li>
        <?php
    }
        ?>

    </ul>
    <!-- 圆点  -->
    <div id="scroll_dot">
        <span class="sel"></span>
        <span></span>
    </div>
    <!-- 左右切换箭头 -->
    <span class="slide_prev slide_btn"></span>
    <span class="slide_next slide_btn"></span>
</div>


<!--  * content *  -->
<div class="content">

    <div class="wrap pr">
        <p class="p_center"><a href=""><img src="<?=base_url()?>static/images/p_center.jpg" width="128" height="208" alt="产品中心图片" /></a></p>
        <div class="index_txt">
            <p><img src="<?=base_url()?>static/images/index_txt.gif" width="857" height="106" /></p>
            <p class="mt30"><a class="blue_btn" href="business.html">进入产品中心 &gt;</a><a class="yellow_btn" href="">注册信息 &gt;</a></p>
        </div>
    </div>

    <div class="index_center">
        <div class="wrap">
            <div id="product_tab">
                <div class="product_list clearfix">
                    <ul>
                        <?php
                            foreach($tjlist as $k => $v){
                        ?>
                        <li>
                            <a href="<?=base_url()?>index.php?c=orders&id=<?=$v['id']?>"><img src="<?=base_url()?>uploads/product/<?=$v['pic']?>" width="274" height="176" /></a>
                            <div class="pro_intro">
                                <a href="<?=base_url()?>index.php?c=orders&id=<?=$v['id']?>"><h3><?=$v['productname']?></h3></a>
                                <p class="good_txt"><?=$v['productname2']?></p>
                                <p class="font_family"><?=$v['info']?></p>
                                <div class="pro_income">
                                    <p>预期最高收益<strong class="float_num"><?=$v['shouyi']?>%</strong></p>
                                    <p>限期<?=$v['qixian']?>个月</p>
                                </div>
                            </div>
                        </li>
                        <?php
                            }
                        ?>

                    </ul>
                </div>
                <ul class="slide_nav">
                    <a href="javascript:;" class="prev"></a>
                    <a href="javascript:;" class="next"></a>
                </ul>
                <script type="text/javascript">
                    jQuery("#product_tab").slide({mainCell:".product_list ul",effect:"left",autoPlay:false,scroll:1,autoPage:true,vis:3,trigger:"click"});
                </script>
                
            </div>
        </div>
    </div>
    
    <p class="tc"><img src="<?=base_url()?>static/images/index_txt2.gif" width="650" height="494" /></p>
    <div class="index_bottom_bg">
        <p class="tc"><a href=""><img src="<?=base_url()?>static/images/private_img.jpg" width="980" height="336" alt="私人银行中心图片" /></a></p>
    </div>

</div>

<!--  * footer *  -->
<div class="footer">
    <div class="wrap">
        <div class="top_footer">
            <img src="<?=base_url()?>static/images/footer_top.gif" width="956" height="130" alt="公司信息" />
        </div>
        <p><a href="">法律声明</a> | <a href="about.html">关于我们</a> | <a href="news.html">企业动态</a> | <a href="">产品中心</a> | <a href="resources.html">招贤纳士</a> | <a href="">联络我们</a></p>
        <p>九州资本版权所有© 粤ICP备14005573号</p> 
  </div>
</div>


<script type="text/javascript">
//幻灯片
$(function(){
    var p = 0;
    var len = $("#imageShow li").length;

    $("#imageShow li").css({"z-index":1,"opacity":0});

    $("#imageShow li").eq(0).css({"z-index":100,"opacity":1});
    $("#scroll_dot span").click(
        function(){
            play($("#scroll_dot span").index(this));
    });

    function play(p){
        $("#scroll_dot span").eq(p).addClass("sel").siblings().removeClass("sel");
        $("#imageShow li").eq(p).animate({'opacity':1},800).css({'z-index':100}).siblings().animate({'opacity':0},800).css({'z-index':1});
    }
    
    $("#imageShow .slide_prev").click(function() {
        p -= 1;
        if(p == -1) {p = len - 1;}
        showPics(p);
    });
    $("#imageShow .slide_next").click(function() {
        p += 1;
        if(p == len) {p = 0;}
        showPics(p);
    });
    
    function showPics(p) { 
        $("#scroll_dot span").removeClass("sel").eq(p).addClass("sel"); 
        $("#imageShow li").stop(true,false).eq(p).animate({'opacity':1},800).css({'z-index':100}).siblings().animate({'opacity':0},800).css({'z-index':1});
    }
    
    function autoplay(){
        p = (p>$("#scroll_dot span").length-2)?0:(p+1);
        play(p);
    }
    var auto = setInterval(function(){ autoplay(p)},5000);
    // $("#imageShow").mouseover(function(){clearInterval(auto);})
   //  $("#imageShow").mouseout (function(){auto = setInterval(function(){ autoplay(p)},5000);})
    
})

</script>

</body>
</html>

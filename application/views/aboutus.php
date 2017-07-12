<!DOCTYPE html>
<html lang="zh-cn">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>九州资本</title>
<meta name="keywords" content="九州资本" />
<meta name="description" content="九州资本官方网站" />
<link type="text/css" href="<?=base_url()?>static/css/style.css"  rel="stylesheet" />
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
<!--  * banner *  -->
<div id="inside_bannner" style="background:url(<?=base_url()?>static/images/ban_about.jpg) no-repeat top center; height:513px;">
    <!--    <img src="images/ban_about.jpg" width="1920" height="513" alt="关于我们广告图" />  -->
</div>

<!--  * content *  -->
<div class="inside_con wrap clearfix">
    <!-- * sidebar *  -->
    <div class="sidebar">
        <dl>
            <dt><a href="">关于我们</a></dt>
            <?php
                foreach($list as $k => $v){
            ?>
           <!-- <dd><a class="active" href="">集团简介</a></dd> -->
            <dd><a href="<?=base_url()?>index.php?c=aboutus&typeid=<?=$k?>"><?=$v['lanmu_name']?></a></dd>
            <?php
                }
            ?>

        </dl>
    </div>
    
    <!-- * main *  -->
    <div class="main">
        <div class="now_position">
            <a class="home_icon" href="index.html" title="首页"></a> &gt 关于我们  &gt; <?=$info['lanmu_name']?>
        </div>
        
        <div class="edit_secition">
            <?=$info['content']?>
        </div>
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

</body>
</html>

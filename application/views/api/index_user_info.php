<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="maximum-scale=1.0,minimum-scale=1.0,user-scalable=0,width=device-width,initial-scale=1.0">
<title>APP</title>
<link rel="stylesheet" type="text/css" href="<?=base_url()?>static/api/css/aui.css">
<link rel="stylesheet" type="text/css" href="<?=base_url()?>static/api/css/aui-slide.css" />
<link rel="stylesheet" type="text/css" href="<?=base_url()?>static/api/css/styles.css" />
 
</head>
<body>
<header class="aui-bar aui-bar-nav aui-bar-warning abs" id="aui-header"> 

 <a class="aui-pull-left aui-btn abs" href="javascript:history.go(-1);"> <span class="aui-iconfont aui-icon-left"></span> </a> 
 <?=$realname?>
  </header>
<section id="wrap">
  <div class="jfbox">
  <div class="zjf">
     <span class="z1">个人总积分</span>
  <span class="z2"><?=$total?></span></div>
  
  <div class="zlist">重大项目 <span class="c1"><?=$majorcount?>分</span></div>
  <div class="zlist">基础项目 <span class="c1"><?=$basiccount?>分</span></div>
  <div class="zlist">复盘得分 <span class="c1"><?=$conquercount?>分</span></div>
  <div class="zlist">人气得分 <span class="c1"><?=$peoplecount?>分</span></div>
  
  </div>
  

</section>



<?php  $this->load->view('/api/inc/footer.php') ?>

<script type="text/javascript" src="<?=base_url()?>static/api/script/api.js"></script> 
 
</body>
</html>

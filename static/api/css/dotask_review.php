<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="maximum-scale=1.0,minimum-scale=1.0,user-scalable=0,width=device-width,initial-scale=1.0">
<title>APP</title>
<link rel="stylesheet" type="text/css" href="<?=base_url()?>static/api/css/aui.css">
<link rel="stylesheet" type="text/css" href="<?=base_url()?>static/api/css/aui-slide.css" />
<link rel="stylesheet" type="text/css" href="<?=base_url()?>static/api/css/styles.css" />
<link rel="stylesheet" type="text/css" href="<?=base_url()?>static/api/css/swiper.min.css" />
<script type="text/javascript" src="<?=base_url()?>static/api/script/jquery.js"></script>
<script type="text/javascript" src="<?=base_url()?>static/api/script/swiper.min.js"></script>
</head>

<body>
<header class="aui-bar aui-bar-nav aui-bar-warning" id="aui-header"> <a class="aui-pull-left aui-btn" href="<?=base_url()?>"> <span class="aui-iconfont aui-icon-home"></span> </a> 指导<a class="aui-btn aui-btn-warning aui-pull-right" > <i class="aui-iconfont aui-icon-my"></i> </a> </header>
<section id="wrap">
  <div class="aui-tab" id="tab">
    <div class="aui-tab-item <?=$_GET['types'] == '1'?'aui-active':''?>"> <a href="<?=base_url()?>index.php?d=api&c=dotask&m=dotask_major&types=1">重大项目</a></div>
    <div class="aui-tab-item <?=$_GET['types'] == '3'?'aui-active':''?>"> <a href="<?=base_url()?>index.php?d=api&c=dotask&m=dotask_major&types=3">基础项目</a></div>
    <div class="aui-tab-item <?=$_GET['m'] == 'dotask_review'?'aui-active':''?>"> <a href="<?=base_url()?>index.php?d=api&c=dotask&m=dotask_review">我要点评</a></div>
    <div class="aui-tab-item <?=$_GET['m'] == 'dotask_score'?'aui-active':''?>"> <a href="<?=base_url()?>index.php?d=api&c=dotask&m=dotask_score">我要评分</a></div>
  </div>
  <ul class="aui-list aui-media-list project dotask ">
    <li class="aui-list-item aui-list-item-middle">
      <?php foreach($list as $k=>$v){   ?>
      <div class="aui-media-list-item-inner dotask_review">
        <div class="aui-list-item-media" > <img  style="width:2.5rem" src="<?=$v['headerurl']?>" class="aui-img-round aui-list-img-sm">
          <div class="name">
            <?=$v['realname']?>
          </div>
          <div class="C"></div>
        </div>
        <div class="aui-list-item-inner">
          <div class="aui-list-item-text"> <a href="<?=base_url()?>index.php?d=api&c=dotask&m=dotask_detail&taskid=<?=$v["taskid"]?>&typeid=<?=$v["typeid"]?>&membertaskmid=<?=$v["mid"]?>&typerole=2<?=$_GET['m']=='dotask_score'?'&make=1':''?>">
            <?=$v['title']?>
            </a> </div>
          <div class="aui-list-item-text">
            <?=$v["ptitle"]?>
          </div>
        </div>
      </div>
      <?php } ?>
    </li>
  </ul>
</section>
<?php $is_active = array('is_active'=>2); $this->load->view('/api/inc/footer.php',$is_active); ?>
<script type="text/javascript" src="<?=base_url()?>static/api/script/api.js"></script> 
<script type="text/javascript" src="<?=base_url()?>static/api/script/aui-tab.js" ></script> 
<script type="text/javascript">

    apiready = function(){

        api.parseTapmode();

    }

    var tab = new auiTab({

 

    },function(ret){

 

    });

  var swiper = new Swiper('.swiper-container', {

        slidesPerView: 'auto',

        paginationClickable: true,

        spaceBetween: 30,

		slidesPerView: 2.2,

    }); 

	

		 

</script>
</body>
</html>

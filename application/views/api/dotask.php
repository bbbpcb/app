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
<header class="aui-bar aui-bar-nav aui-bar-warning" id="aui-header"> <a class="aui-pull-left aui-btn" href="<?=base_url()?>"> <span class="aui-iconfont aui-icon-home"></span> </a> 指导<a class="aui-btn aui-btn-warning aui-pull-right"  href="javascript:;" id="menu"  > <i class="aui-iconfont aui-icon-my"></i> </a> </header>
<section id="wrap">
  <div class="aui-tab" id="tab">
    <div class="aui-tab-item <?=$_GET['types'] == '1'?'aui-active':''?>"> <a href="<?=base_url()?>index.php?d=api&c=dotask&m=dotask_major&types=1">重大项目</a></div>
    <div class="aui-tab-item <?=$_GET['types'] == '3'?'aui-active':''?>"> <a href="<?=base_url()?>index.php?d=api&c=dotask&m=dotask_major&types=3">基础项目</a></div>
    
    <div class="aui-tab-item <?=$_GET['m'] == 'dotask_review'?'aui-active':''?>"> <a href="<?=base_url()?>index.php?d=api&c=dotask&m=dotask_review">我要点评</a></div>
     <div class="aui-tab-item <?=$_GET['m'] == 'dotask_score'?'aui-active':''?>"> <a href="<?=base_url()?>index.php?d=api&c=dotask&m=dotask_score">我要评分</a></div>
    
    
  </div>
  <ul class="aui-list aui-media-list project dotask">
    <?php if($_GET['types']==1){?>
    <li class="aui-list-item aui-list-item-middle">
      <?php foreach($list as $k=>$v){ ?>
      <div class="aui-list-item-media" > <img src="<?=$v['icon']?>" class="aui-img-round aui-list-img-sm">
        <?=$v['title']?>
      </div>
      <section class="aui-content pro_list">
        <div class="aui-card-list">
          <div class="aui-card-list-content swiper-container">
            <div class="aui-row aui-row-padded swiper-wrapper">
              <?php  if($v["tasklist"]){ foreach($v["tasklist"] as $k=>$val){  ?>
              <div class="aui-col-xs-6 swiper-slide task-info">
                <input type="hidden" value="<?=$val["taskid"]?>" class="taskid" />
                <input type="hidden" value="<?=$val["modid"]?>" class="modid" />
                <input type="hidden" value="<?=$val["user"]["roleid"]?>" class="roleid" />
                <div class="imgbox"> <img src="<?=$val['task_icon']?>">
                  <div class="r-jb">
                    <?= $val['totlescore'] ?>
                    分 </div>
                  <div class="txt">
                    <h1>
                      <?=$val["m_name"]?>
                    </h1>
                    <h1>
                      <?=$val["type_name"]?>
                    </h1>
                    规模：
                    <?=$val["scale"]?>
                    难度：
                    <?=$val["difficulty"]?>
                  </div>
                </div>
                <span class="title"> <a href="<?=base_url()?>index.php?d=api&c=dotask&m=dotask_detail&taskid=<?=$val["id"]?>&typeid=<?=$val["typeid"]?>&membertaskmid=<?=$val["mid"]?>&typerole=1">
                <?= $val['title'] ?>
                </a> </span> <span class="name"> 专家评分：
                <?= $val['expertscore'] ?>
                分 </span> <span class="replay" ><i class="aui-iconfont aui-icon-comment"></i>
                <?=$val['replynum']?>
                </span> </div>
              <?php } } ?>
            </div>
          </div>
        </div>
      </section>
      <?php } ?>
    </li>
    <?php }else{ ?>
    <li class="aui-list-item aui-list-item-middle">
      <?php foreach($list as $k=>$v){ ?>
      <div class="aui-media-list-item-inner">
        <div class="aui-list-item-inner">
          <div class="aui-list-item-text"> <a href="<?=base_url()?>index.php?d=api&c=dotask&m=dotask_detail&taskid=<?=$v["id"]?>&typeid=2&membertaskmid=<?=$v["mid"]?>&typerole=1">
            <?=$v['title']?>
            </a>
            <?=$v["createtime"]?>
          </div>
          <div class="aui-list-item-text"> 标准分
            <?=$v['totlescore']?>
          </div>
        </div>
      </div>
      <?php } ?>
    </li>
    <?php } ?>
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
<?php  $this->load->view('/api/inc/menu.php') ?>
</body>
</html>

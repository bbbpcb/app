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
<header class="aui-bar aui-bar-nav aui-bar-warning" id="aui-header"> <a class="aui-btn aui-btn-warning aui-pull-left" href="<?=base_url();?>index.php?d=api&c=login" > 登录</a>
 <a class="aui-btn aui-btn-warning aui-pull-right" href="javascript:;" id="menu" >
  <i class="aui-iconfont aui-icon-my"></i>
   </a> 
 </header>
<section id="wrap">
  <div class="aui-content">
    <div id="aui-slide3">
      <div class="aui-slide-wrap" >
        <?php foreach($list as $k=>$v){?>
        <div class="aui-slide-node bg-dark"> <img  alt="<?=$v['title']?>" src="<?=$v['img1']?>" /> </div>
        <?php } ?>
      </div>
      <div class="aui-slide-page-wrap"> 
        <!--分页容器--> 
      </div>
    </div>
  </div>
  <ul class="aui-list aui-media-list index-user">
    <li class="aui-list-item">
      <div class="aui-list-item-inner">
        <div class="aui-list-item-title">员工积分榜&nbsp;Employees <span class="aui-pull-right"><a href="<?=base_url()?>index.php?d=api&c=index&m=user_detail_list&typeid=1&company_id=1">更多员工</a></span> </div>
        <div class="aui-row aui-row-padded">
          <?php foreach($employeelist as $k=>$v){?>
          
         <a href="<?=base_url()?>index.php?d=api&c=userinfo&m=member_integral&mid=<?=$v['id']?>"> <div class="aui-col-xs-4 ubox <?=($k+1)%3==0?'last':''?>"> <img   src="<?=$v['headerurl']?>"> <span class="name">
            <?=$v['realname']?>
            </span> <span class="inte">
            <?=$v['integraltotal']?>
            </span> </div>
         </a>   
          <?php } ?>
        </div>
      </div>
    </li>
    <li class="aui-list-item">
      <div class="aui-list-item-inner">
        <div class="aui-list-item-title">专家人气榜&nbsp;Experts <span class="aui-pull-right"><a href="<?=base_url()?>index.php?d=api&c=index&m=user_detail_list&typeid=2&company_id=1">更多专家</a></span></div>
        <div class="aui-row aui-row-padded">
          <?php foreach($expertlist as $k=>$v){?>
          <div class="aui-col-xs-4 ubox <?=($k+1)%3==0?'last':''?>"> <img   src="<?=$v['headerurl']?>"> <span class="name">
            <?=$v['realname']?>
            </span> <span class="inte">
            <?=$v['integraltotal']?>
            </span> </div>
          <?php } ?>
        </div>
      </div>
    </li>
  </ul>
</section>




<?php  $this->load->view('/api/inc/footer.php') ?>

<script type="text/javascript" src="<?=base_url()?>static/api/script/api.js"></script> 
<script type="text/javascript" src="<?=base_url()?>static/api/script/aui-slide.js"></script> 

<script type="text/javascript">

   var slide3 = new auiSlide({
        container:document.getElementById("aui-slide3"),
        // "width":300,
        "height":240,
        "speed":500,
        "autoPlay": 3000, //自动播放
        "loop":true,
        "pageShow":true,
        "pageStyle":'dot',
        'dotPosition':'center'
    })

</script>
<?php  $this->load->view('/api/inc/menu.php') ?>
</body>
</html>

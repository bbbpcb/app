<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="maximum-scale=1.0,minimum-scale=1.0,user-scalable=0,width=device-width,initial-scale=1.0">
<title>APP</title>
<link rel="stylesheet" type="text/css" href="<?=base_url()?>static/api/css/aui.css">
<link rel="stylesheet" type="text/css" href="<?=base_url()?>static/api/css/aui-slide.css" />
<link rel="stylesheet" type="text/css" href="<?=base_url()?>static/api/css/styles.css" />
<style type="text/css">
#chat {
	display: none
}
</style>
</head>
<body>
<section id="member_list">
<header class="aui-bar aui-bar-nav aui-bar-warning" id="aui-header"> <a class="aui-btn aui-btn-warning aui-pull-left abs"  href="javascript:;" onClick="window.history.go(-1)" > <i class="aui-iconfont aui-icon-left"></i></a>
  <div class="aui-title">项目分布</div>
</header>
<section id="wrap">
  <div class="fenbu">
    <div class="LE"> <span>项目类型比重：</span> <img src="<?=base_url();?>index.php?d=api&c=userinfo&m=putimg&a=1&c1=<?=$project['majorproject']?>&c2=<?=$project['basicproject']?>"?> <span class="xmlist"><span class="bg5"></span>重大项目</span> <span  class="xmlist" ><span class="bg6"></span>基础项目</span> </div>
    <div class="R"> <span>项目负责人比重：</span> <img src="<?=base_url();?>index.php?d=api&c=userinfo&m=putimg&a=2&c1=<?=$member['experttotal']?>&c2=<?=$member['employeetotal']?>&c3=<?=$member['$leadertotal']?>"?> <span class="xmlist"><span class="bg7"></span>员工</span> <span  class="xmlist" ><span class="bg8"></span>专家</span> <span  class="xmlist" ><span class="bg9"></span>领导</span> </div>
  </div>
  

  
  
  </div>
  
 <div class="fenbu2">
 <?php ?>
    <div class="LE"> 
    
    <span class="title">
    重大项目</span>
    <div class="fenbu2box">
    <ul>
    <?php foreach($majorfeatures as $v){ ?>
    <li><div class="aui-col-xs-1"> <i  class="aui-iconfont aui-icon-star c2"  ></i> </div>特性  <b style="float:right"><?=$v?>分</b></li>
    <?php } ?>
    </ul>
    
    </div>
    </div>
    <div class="R">
    
     <span class="title">
    基础项目
    </span>
    
    
     <div class="fenbu2box">
    <ul>
    <?php foreach($basicfeatures as $v){ ?>
    <li><div class="aui-col-xs-1"> <i  class="aui-iconfont aui-icon-star c2"  ></i> </div>特性  <b style="float:right"><?=$v?>分</b></li>
    <?php } ?>
    </ul>
    
    </div>
    
    </div>
  
  </div>
  
  
</section>
<script type="text/javascript" src="<?=base_url()?>static/api/script/api.js"></script> 
<script type="text/javascript" src="<?=base_url()?>static/api/script/jquery.js"></script> 
<script type="text/javascript" src="<?=base_url()?>static/api/script/aui-toast.js" ></script> 
<script type="text/javascript">
var toast = new auiToast({})


</script>
</body>
</html>

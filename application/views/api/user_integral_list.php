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
<header class="aui-bar aui-bar-nav aui-bar-warning" id="aui-header"> <a class="aui-btn aui-btn-warning aui-pull-left abs"  href="javascript:;" onClick="window.history.go(-1)" > <i class="aui-iconfont aui-icon-left"></i></a>
  <div class="aui-title">
    <?=$list[0]['realname']?>
  </div>
</header>
<section id="wrap">
  <div class="aui-tab" id="tab">
    <div class="aui-tab-item <?=$_GET['typeid'] == '1'?'aui-active':''?>"> <a href="<?=base_url()?>index.php?d=api&c=userinfo&m=integral_list&id=<?=$_GET['id']?>&typeid=1">重大项目</a></div>
    <div class="aui-tab-item <?=$_GET['typeid'] == '2'?'aui-active':''?>" > <a href="<?=base_url()?>index.php?d=api&c=userinfo&m=integral_list&id=<?=$_GET['id']?>&typeid=2">基础项目</a></div>
  </div>
  <ul class="inv_lists">
    <?php foreach($list as $k=>$v){ ?>
    <li>
      <span class="lis">
      <div class="aui-col-xs-1"> <i class="aui-iconfont aui-icon-star c2">
        <?=(5-$k)?>
        </i> </div>
      <span class="name">
      <?=$v['realname']?>
      <span class="c1 R">
      <?=$v['total']?>
      分 </span>
      
      </span>
      </span>
      
      
      <div class="name_n"> <span class="n1">
        <?=$v['rolename']?>
        </span> <span class="n2">
        <?=$v['total']?>
        </span> </div>
    </li>
    <?php } ?>
  </ul>
</section>
<script type="text/javascript" src="<?=base_url()?>static/api/script/api.js"></script>
<script type="text/javascript" src="<?=base_url()?>static/api/script/jquery.js"></script>
<script type="text/javascript" src="<?=base_url()?>static/api/script/aui-tab.js" ></script>
<script type="text/javascript" src="<?=base_url()?>static/api/script/aui-toast.js" ></script>
<script type="text/javascript">
var toast = new auiToast({})
    apiready = function(){
        api.parseTapmode();
    }
    var tab = new auiTab({
         },function(ret){
     });
  
</script>
</body>
</html>

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
	display:none
}
</style>
</head>
<body>
<section id="member_list">
<header class="aui-bar aui-bar-nav aui-bar-warning" id="aui-header"> <a class="aui-btn aui-btn-warning aui-pull-left"  href="javascript:;" onClick="window.history.go(-1)" > <i class="aui-iconfont aui-icon-left"></i></a>
  <div class="aui-title">联系人</div>
  <a class="aui-btn aui-btn-warning aui-pull-right"  onClick="javascript:void(0)" id="plus" > <i class="aui-iconfont aui-icon-my"></i>
 
  </a> </header>
<section id="wrap" class="member">
  <div class="aui-content aui-margin-b-15" id="mem_list" style="display:block">
    <ul class="aui-list aui-media-list">
     <?php foreach($list as $k=>$v){ ?>
      <li class="aui-list-item aui-list-item-middle ">
        <div class="aui-media-list-item-inner">
          <div class=" aui-col-xs-5 aui-list-item-left">
            <div class=" aui-col-xs-5"><img src="<?=$v['headerurl']?>" class="aui-img-round aui-list-img-sm"></div>
            <div class="aui-col-xs-6"><span class="aui-font-size-16"><?=$v['realname']?></span><span class="aui-font-size-14">
              <h5><?=$v['role']?></h5>
              </span></div>
          </div>
          <div class="aui-list-item-right aui-col-xs-7">
            <div class="aui-col-xs-7 aui-font-size-18"><?=$v['phone']?></div>
            <input class="aui-checkbox aui-list-item-right" type="checkbox" value="<?=$v['id']?>" name="member_ex">
          </div>
        </div>
      </li>
     <?php } ?> 
      
    </ul>
   
   <section class="aui-chat" id="chat" style="display:block">
 
    <div class="send inv">
      <div class="aui-btn  aui-btn-block  L" id="fail">取消</div>
      <div class="aui-btn  aui-btn-block  R" id="succ">完成</div>
    </div>
   
  </section>
   
    
  </div>
</section>
</section>
<script type="text/javascript" src="<?=base_url()?>static/api/script/api.js"></script>
<script type="text/javascript" src="<?=base_url()?>static/api/script/jquery.js"></script>
<script type="text/javascript" src="<?=base_url()?>static/api/script/aui-toast.js" ></script>
<script type="text/javascript">
var toast = new auiToast({})

</script>
</body>
</html>

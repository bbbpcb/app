<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="maximum-scale=1.0,minimum-scale=1.0,user-scalable=0,width=device-width,initial-scale=1.0">
<title>APP</title>
<link rel="stylesheet" type="text/css" href="<?=base_url()?>static/api/css/aui.css">
<link rel="stylesheet" type="text/css" href="<?=base_url()?>static/api/css/aui-slide.css" />
<link rel="stylesheet" type="text/css" href="<?=base_url()?>static/api/css/styles.css" />
<script type="text/javascript" src="<?=base_url()?>static/api/script/jquery.js"></script>
</head>
<body>
<section id="main"> </section>
<section id="main-info">
  <header class="aui-bar aui-bar-nav aui-bar-warning" id="aui-header"> <a class="aui-pull-left aui-btn abs" href="javascript:;window.history.go(-1)"> <span class="aui-iconfont aui-icon-left"></span> </a>
    创建 
 
  </header>
  <section id="wrap" class="pro-det">
    <div class="page-main" id="task">
    
    <?php foreach($list as $k=> $v){ ?>
      <div class="from-main task_type" <?=($k+1) == count($list)?'style="margin-bottom:10rem"':''?>>
        <div class="title1"><?=$v['type_name']?></div>
        <div class="list"> <span class="name">创建任务标题</span>
          <input type="hidden" value="<?=$v['id']?>" class="task_typeid" />
          <input type="text" class="inp title" value="<?=$proinfo['title']?>" name="title" placeholder="请输入标题名" />
        </div>
        <div class="list"> <span class="name">创建任务描述</span>
          <input type="text" class="inp intro" value="<?=$proinfo['intro']?>" name="intro"  placeholder="请输入项目描述" />
        </div>

        <div class="list start scale"> <span class="name">规模</span>
          <input type="hidden" value="<?=$proinfo['scale']?>" class="scales">
          <?php for($i=1;$i<=5;$i++){?>
          <div class="aui-col-xs-1"> <i data-id="<?=$i?>" <?=$i<=$proinfo['scale']?'style="color: rgb(252, 0, 0);"':''?> class="aui-iconfont aui-icon-star"></i> </div>
          <?php } ?>
        </div>
        <div class="list start difficulty"> <span class="name">难度</span>
          <input type="hidden" value="<?=$proinfo['difficulty']?>" class="difficultys">
          <?php for($i=1;$i<=5;$i++){?>
          <div class="aui-col-xs-1"> <i data-id="<?=$i?>" <?=$i<=$proinfo['difficulty']?'style="color: rgb(252, 0, 0);"':''?> class="aui-iconfont aui-icon-star"></i> </div>
          <?php } ?>
        </div>
        <div class="list start quality"> <span class="name">质量</span>
          <input type="hidden" value="<?=$proinfo['quality']?>" class="qualitys">
          <?php for($i=1;$i<=5;$i++){?>
          <div class="aui-col-xs-1"> <i data-id="<?=$i?>" <?=$i<=$proinfo['quality']?'style="color: rgb(252, 0, 0);"':''?> class="aui-iconfont aui-icon-star"></i> </div>
          <?php } ?>
        </div>
        <div class="list start features"> <span class="name">特性</span>
          <input type="hidden" value="<?=$proinfo['features']?>" class="featuress">
          <?php for($i=1;$i<=5;$i++){?>
          <div class="aui-col-xs-1"> <i data-id="<?=$i?>" <?=$i<=$proinfo['features']?'style="color: rgb(252, 0, 0);"':''?> class="aui-iconfont aui-icon-star"></i> </div>
          <?php } ?>
        </div>
          <div class="addtask" ><i class="aui-iconfont aui-icon-plus"></i>新增任务</div>
      </div>
      <?php } ?> 
      </div>
    
    
    
    <section class="aui-chat" id="chat">
      <div class="send">
      提示：点击保存，可返回工作模块页面，选择新的模块在创建新的任务。
        <div class="aui-btn an aui-btn-block" id="tasksub">保存</div>
      </div>
    </section>
 
    
    
    
  </section>
</section>
<script type="text/javascript" src="<?=base_url()?>static/api/script/api.js"></script>
<script type="text/javascript" src="<?=base_url()?>static/api/script/aui-toast.js" ></script>
<script type="text/javascript" src="<?=base_url()?>static/api/script/jquery.js"></script>
<script type="text/javascript">
var toast = new auiToast({})
 
 
 
 $(".scale .aui-icon-star").click(function(){
    var star =  $(this).attr("data-id");
 
	
      $(this).parents(".scale").find(".aui-icon-star").each(
            function(index, el) { 
			if((index+1) <=  star ){
			 $(el).css("color","#fc0000");  
			}
			 });
	$(this).parents(".scale").find(".scales").val(star); 
	 
 })
 
 
  $(".difficulty .aui-icon-star").click(function(){
    var star =  $(this).attr("data-id");
 
    $(this).parents(".difficulty").find(".aui-icon-star").each(
            function(index, el) { 
			 if((index+1) <=  star ){
			 $(el).css("color","#fc0000");  
			}
			 });
			 
	 $(this).parents(".difficulty").find(".difficultys").val(star); 
	 
 })
 
  $(".quality .aui-icon-star").click(function(){
    var star =  $(this).attr("data-id");
	 
       $(this).parents(".quality").find(".aui-icon-star").each(
            function(index, el) {
			if((index+1) <=  star ){
			 $(el).css("color","#fc0000");  
			}
			 });
			 
	 $(this).parents(".quality").find(".qualitys").val(star); 
	 
 })
 
  $(".features .aui-icon-star").click(function(){
    var star =  $(this).attr("data-id");
	
       $(this).parents(".features").find(".aui-icon-star").each(
            function(index, el) {
			if((index+1) <=  star ){
			 $(el).css("color","#fc0000");  
			}
			 });
			 
	 $(this).parents(".features").find(".featuress").val(star); 
	 
 })
 
  
</script>
</body>
</html>

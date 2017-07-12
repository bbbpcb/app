<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="maximum-scale=1.0,minimum-scale=1.0,user-scalable=0,width=device-width,initial-scale=1.0">
<title>APP</title>
<link rel="stylesheet" type="text/css" href="<?=base_url()?>static/api/css/aui.css">
<link rel="stylesheet" type="text/css" href="<?=base_url()?>static/api/css/aui-slide.css" />
<link rel="stylesheet" type="text/css" href="<?=base_url()?>static/api/css/styles.css" />
<script type="text/javascript" src="<?=base_url()?>static/api/script/jquery.js"></script>
<script type="text/javascript" src="<?=base_url()?>static/api/script/layer.js"></script>
</head>
<body>
<section id="main"> </section>
<section id="main-info">
  <header class="aui-bar aui-bar-nav aui-bar-warning" id="aui-header"> <a class="aui-pull-left aui-btn abs" href="javascript:;window.history.go(-1)"> <span class="aui-iconfont aui-icon-left"></span> </a>
    <?=$_GET['proid']?'修改':'创建'?>
    <?php if($_GET['proid']){?>
    <a class="aui-pull-right aui-btn" href="javascript:;" onClick="delproject(<?=$proinfo['id']?>)">删除</a>
    <?php } ?>
  </header>
  <section id="wrap" class="pro-det">
    <div class="page-main">
      <div class="from-main">
        <div class="list"> <span class="name">创建项目标题</span>
          <input type="text" class="inp" value="<?=$proinfo['title']?>" name="title" id="title" placeholder="请输入标题名" />
        </div>
        <div class="list"> <span class="name">创建项目描述</span>
          <input type="text" class="inp" value="<?=$proinfo['intro']?>" name="intro" id="intro" placeholder="请输入项目描述" />
        </div>
        <div class="list">
          <input type="hidden" value="<?=$proinfo['headid']?>" id="headid" />
          <span class="name">请选择项目负责人</span>
          <?php if($_GET['proid']){?>
          <span class="choo">
          <?=$proinfo['header']?>
          &nbsp;></span>
          <?php }else{ ?>
          <span class="choo"> 点击选择&nbsp;></span>
          <?php } ?>
        </div>
        <div class="list start scale"> <span class="name">规模</span>
          <input type="hidden" value="<?=$proinfo['scale']?>" id="scale">
          <?php for($i=1;$i<=5;$i++){?>
          <div class="aui-col-xs-1"> <i data-id="<?=$i?>" <?=$i<=$proinfo['scale']?'style="color: rgb(252, 0, 0);"':''?> class="aui-iconfont aui-icon-star"></i> </div>
          <?php } ?>
        </div>
        <div class="list start difficulty"> <span class="name">难度</span>
          <input type="hidden" value="<?=$proinfo['difficulty']?>" id="difficulty">
          <?php for($i=1;$i<=5;$i++){?>
          <div class="aui-col-xs-1"> <i data-id="<?=$i?>" <?=$i<=$proinfo['difficulty']?'style="color: rgb(252, 0, 0);"':''?> class="aui-iconfont aui-icon-star"></i> </div>
          <?php } ?>
        </div>
        <div class="list start quality"> <span class="name">质量</span>
          <input type="hidden" value="<?=$proinfo['quality']?>" id="quality">
          <?php for($i=1;$i<=5;$i++){?>
          <div class="aui-col-xs-1"> <i data-id="<?=$i?>" <?=$i<=$proinfo['quality']?'style="color: rgb(252, 0, 0);"':''?> class="aui-iconfont aui-icon-star"></i> </div>
          <?php } ?>
        </div>
        <div class="list start features"> <span class="name">特性</span>
          <input type="hidden" value="<?=$proinfo['features']?>" id="features">
          <?php for($i=1;$i<=5;$i++){?>
          <div class="aui-col-xs-1"> <i data-id="<?=$i?>" <?=$i<=$proinfo['features']?'style="color: rgb(252, 0, 0);"':''?> class="aui-iconfont aui-icon-star"></i> </div>
          <?php } ?>
        </div>
      </div>
    </div>
   
    <section class="aui-chat" id="chat">
      <div class="send">
        <div class="aui-btn an aui-btn-block" id="basics">提交</div>
      </div>
    </section>
   
  </section>
</section>
<script type="text/javascript" src="<?=base_url()?>static/api/script/api.js"></script> 
<script type="text/javascript" src="<?=base_url()?>static/api/script/aui-toast.js" ></script> 
<script type="text/javascript" src="<?=base_url()?>static/api/script/jquery.js"></script> 
<script type="text/javascript">
var toast = new auiToast({})
 
 $(".choo").click(function(){
 $("#main-info").hide();
 $("#main").show();
  var url = "<?=base_url();?>index.php?d=api&c=userinfo&m=member_ajax_list";
  $("#main").load(url+" #member_list ",function(res){
    $(".aui-checkbox").click(function(){
	   var id = $(this).val();
	   var name = $(this).parents("li").find(".aui-font-size-16").html();
	   $("#main-info").show();
	   $("#main").hide();
	   $("#headid").val(id);
	   $(".choo").html(name+'&nbsp;>');
    })
  
  });
 })
 
 
 $(".scale .aui-icon-star").click(function(){
    var star =  $(this).attr("data-id");
       $(".scale .aui-icon-star").each(
            function(index, el) {
			if((index+1) <=  star ){
			 $(el).css("color","#fc0000");  
			}
			 });
	 $("#scale").val(star); 
	 
 })
 
 
  $(".difficulty .aui-icon-star").click(function(){
    var star =  $(this).attr("data-id");
       $(".difficulty .aui-icon-star").each(
            function(index, el) {
			if((index+1) <=  star ){
			 $(el).css("color","#fc0000");  
			}
			 });
	 $("#difficulty").val(star); 
	 
 })
 
  $(".quality .aui-icon-star").click(function(){
    var star =  $(this).attr("data-id");
       $(".quality .aui-icon-star").each(
            function(index, el) {
			if((index+1) <=  star ){
			 $(el).css("color","#fc0000");  
			}
			 });
	 $("#quality").val(star); 
	 
 })
 
  $(".features .aui-icon-star").click(function(){
    var star =  $(this).attr("data-id");
       $(".features .aui-icon-star").each(
            function(index, el) {
			if((index+1) <=  star ){
			 $(el).css("color","#fc0000");  
			}
			 });
	 $("#features").val(star); 
	 
 })
 
 $("#basics").click(function(){
 var title=$("#title").val();
 var intro=$("#intro").val();
 var headid=$("#headid").val();
 var scale =$("#scale").val(); 
 var difficulty=$("#difficulty").val(); 
 var quality =$("#quality").val(); 
 var features = $("#features").val(); 
 if(title.length <= 0 ){
  layer.open({
    content: '标题不能为空'
    ,skin: 'msg'
    ,time: 2 //2秒后自动关闭
  });
 return;
 }
 
  if(intro.length <= 0 ){
  layer.open({
    content: '描述不能为空'
    ,skin: 'msg'
    ,time: 2 //2秒后自动关闭
  });
 return;
 }
 
  if(headid.length <= 0 ){
  layer.open({
    content: '请选择负责人'
    ,skin: 'msg'
    ,time: 2 //2秒后自动关闭
  });
 return;
 }
 <?php if($_GET['proid']){?>

  var url = "<?=base_url();?>index.php?d=api&c=project&m=projectupdate";
  var proid = <?=$_GET['proid']?$_GET['proid']:0?>;
  var data={'proid':proid,'title':title,'intro':intro,'headid':headid,'scale':scale,'difficulty':difficulty,'quality':quality,'features':features};
 <?php }else{?>
 var url = "<?=base_url();?>index.php?d=api&c=project&m=create_basics";
  var data={'title':title,'intro':intro,'headid':headid,'scale':scale,'difficulty':difficulty,'quality':quality,'features':features};
 <?php } ?>

  $.post(url, data,
    function(res) {
        var res = jQuery.parseJSON(res);
        if (res.errcode < 0) {
            toast.fail({
                title: res.errmsg,
                duration: 2000
            });
        } else {
		
		     toast.success({
			       <?php if($_GET['proid']){?>
				    title:"项目修改成功",
				   <?php }else{ ?>
                    title:"项目创建成功",
					<?php } ?>
					
                    duration:2000
                });
			window.location.href="<?=base_url()?>index.php?d=api&c=project&ptype=own";
		 }
		 
		})
 
 })

 
function delproject(id){

  var url = "<?=base_url();?>index.php?d=api&c=project&m=projectdel";
  var data = {'proid':id};
   $.post(url, data,
    function(res) {
        var res = jQuery.parseJSON(res);
        if (res.errcode < 0) {
            toast.fail({
                title: res.errmsg,
                duration: 2000
            });
        } else {
		
		     toast.success({
			        
				    title:"项目删除成功",
				 
					
                    duration:2000
                });
			window.location.href="<?=base_url()?>index.php?d=api&c=project&ptype=own";
		 }
		 })
  
} 

 

</script>
</body>
</html>

<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="maximum-scale=1.0,minimum-scale=1.0,user-scalable=0,width=device-width,initial-scale=1.0">
<title>APP</title>
<link rel="stylesheet" type="text/css" href="<?=base_url()?>static/api/css/aui.css">
<link rel="stylesheet" type="text/css" href="<?=base_url()?>static/api/css/aui-slide.css" />
<link rel="stylesheet" type="text/css" href="<?=base_url()?>static/api/css/styles.css" />
<style type="text/css">
 
.aui-list-item-right .aui-btn-block {
	float:right;
	width:45%;
	margin-left:2%
}
#title {
	border:1px solid #ccc
}
#new{ display:none}
</style>
</head>
<body>
<header class="aui-bar aui-bar-nav aui-bar-warning" id="aui-header"> <a class="aui-btn aui-btn-warning aui-pull-left"  href="<?=base_url()?>" id="home" > <i class="aui-iconfont aui-icon-home"></i></a>
  <div class="aui-title">用户中心</div>
  <a class="aui-btn aui-btn-warning aui-pull-right" id="menu"  > <i class="aui-iconfont aui-icon-my"></i> </a> </header>
<section id="wrap">
  <section class="aui-grid aui-margin-b-15" id="main1" >
    <div class="aui-row user">
      <div class="aui-col-xs-6" id="y">
        <div class="aui-grid-label">个人总积分:</div>
       <span class="c1"> <?=$jf[total]?>
        分 </span></div>
      <div class="aui-col-xs-3" id="h">
        <div class="aui-grid-label">重大项目:</div>
      <span class="c1"> <?=$jf[majorcount]?>
        分 </span>
      
       </div>
      <div class="aui-col-xs-3">
        <div class="aui-grid-label">基础项目:</div>
       <span class="c1"> <?=$jf[basiccount]?>
        分 </span> </div>
      <div class="aui-col-xs-3">
        <div class="aui-grid-label">讨论题目:</div>
       <span class="c1"> <?=$jf[conquercount]?>
        分 </span> </div>
      <div class="aui-col-xs-3">
        <div class="aui-grid-label">人气项目:</div>
          <span class="c1"> <?=$jf[peoplecount]?>
        分 </span></div>
    </div>
  </section>
  <section class="aui-grid aui-margin-b-15 user-info"  id="main2" >
    <div class="aui-row">
      <div class="aui-col-xs-6 cb1"> <a href="<?=base_url();?>index.php?d=api&c=userinfo&m=messages_list">
        <div class="aui-grid-label">问答箱</div>
        <i class="aui-iconfont aui-icon-mail "></i> </a> </div>
      <div class="aui-col-xs-6 cb2 mr0"> <a href="<?=base_url();?>index.php?d=api&c=userinfo&m=member_list" >
        <div class="aui-grid-label">通信录</div>
        <i class="aui-iconfont aui-icon-cert"></i> </a></div>
      <div class="aui-col-xs-6 cb3"> <a href="<?=base_url();?>index.php?d=api&c=userinfo&m=group_list_inv">
        <div class="aui-grid-label">积分榜</div>
        <i class="aui-iconfont aui-icon-calendar"></i> </a> </div>
      <div class="aui-col-xs-6 cb4"> <a href="<?=base_url();?>index.php?d=api&c=userinfo&m=project_distribution">
        <div class="aui-grid-label">项目分布</div>
        <i class="aui-iconfont aui-icon-info"></i> </a> </div>
    </div>
  </section>
</section>
 
<div class="aui-content aui-margin-b-15" id="mem_list">
     <ul class="aui-list aui-media-list">
     </ul>
</div>
<?php if($member_ex){?>
<div class="aui-tips" > <i class="aui-iconfont aui-icon-info"></i>
  <div class="aui-tips-title">有
    <?=count($member_ex)?>
    人邀请您</div>
  <a href="javascript:;" id="view" >去查看</a> </div>
<?php }?>
<?php $is_active = array('is_active'=>5); $this->load->view('/api/inc/footer.php',$is_active); ?>
<script type="text/javascript" src="<?=base_url()?>static/api/script/api.js"></script>
<script type="text/javascript" src="<?=base_url()?>static/api/script/jquery.js"></script>
<script type="text/javascript" src="<?=base_url()?>static/api/script/aui-toast.js" ></script>
<script type="text/javascript">
 var toast = new auiToast({
    })
 $(function(){
 var h = $("#h").height();
         $("#y").height(h*2);
 })
$("#view").click(function(){
 toast.loading({
       title:"加载中",
       duration:2000
      });
 var url="<?=base_url();?>index.php?d=api&c=userinfo&m=invite_list"; 
     $.get(url,
      function(res){
	  	var res = jQuery.parseJSON(res);  
		if(res.errcode< 0){
			 toast.fail({
             title:res.errmsg,
             duration:2000
             });
			}else{
	         toast.hide();
              var html ='';
			  $("#home").attr("href","javascript:;");
			  $(".aui-icon-home").addClass("aui-icon-left");
			  $(".aui-icon-home").removeClass("aui-icon-home");
			  $("#main1").hide();
			  $("#main2").hide();
			  $("#main1").html("");
			  $("#main2").html("");
			  $(".aui-tips").hide();
			  $(".aui-title").html('查看邀请');
			  $("#mem_list").show();
			  
			  $.each(res.data.list,function(index,el){ 
			  html +='<li class="aui-list-item aui-list-item-middle "><div class="aui-media-list-item-inner"><div class=" aui-col-xs-6 aui-list-item-left"><div class=" aui-col-xs-5"><img src="'+el['headerurl']+'" class="aui-img-round aui-list-img-sm"></div><div class="aui-col-xs-7"><span class="aui-font-size-16">'+el['realname']+'</span><span class="aui-font-size-14"><h5>我想邀请您，关注我</h5></div></div><div class="aui-list-item-right aui-col-xs-6"><div class="aui-btn aui-btn-primary aui-btn-block aui-btn-sm" onclick="accept('+el['exid']+',1)">接受</div><div class="aui-btn aui-btn-success aui-btn-block aui-btn-sm" onclick="accept('+el['exid']+',2)">拒绝</div></div></div></li>';
			  })
			  $("#mem_list ul").html(html);
		      }
	          })
  })
 
$("#home").click(function(){
 	location.reload(); 
 })
function accept(id,type){
var url="<?=base_url();?>index.php?d=api&c=userinfo&m=invite_submit";
var data = {exid:id,type:type};
  $.post(url,
        data,
		function(res){
			var res = jQuery.parseJSON(res);  
		if(res.errcode< 0){
			 toast.fail({
             title:res.errmsg,
             duration:2000
             });
			}else{
			if(type == 2){
			 toast.success({
                    title:"拒绝申请",
                    duration:2000
                });
			}else{
			 toast.success({
                    title:"接受申请",
                    duration:2000
                });
			}
			 location.reload(); 
			}
		
		
		})  
}
 

 
</script>
<?php  $this->load->view('/api/inc/menu.php') ?>
</body>
</html>

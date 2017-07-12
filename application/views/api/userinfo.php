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
<header class="aui-bar aui-bar-nav aui-bar-warning" id="aui-header"> 
<a class="aui-btn aui-btn-warning aui-pull-left"  href="javascript:;" onClick="window.history.go(-1)"  id="home" > <i class="aui-iconfont aui-icon-left"></i></a>
  <div class="aui-title">个人信息</div>
  <a class="aui-btn aui-btn-warning aui-pull-right" id="my" >编辑</a> </header>
<section id="wrap">
<div class="userinfo">
<div class="touxiang">
 
<img src="<?=$user['headerurl']?>" />
<span class="name"><?=$user['realname']?></span>
<span class="an">编辑头像</span>
</div>
<ul>
<li><span>个人简介：</span><?=$user['intro']?$user['intro']:'---'?> </li>
<li><span>帐号：</span><?=$user['moblie']?>(不可更改)</li>
<li><span>姓名：</span><input type="text" readonly value="<?=$user['realname']?$user['realname']:'---'?>" id="realname" class="inpread" /></li>
<li><span>性别：</span><input type="text" readonly value="<?=$user['gende']==0?'女':'男'?>" id="gende" class="inpread" /></li>
<li><span>邮箱：</span><input type="text" readonly value="<?=$user['email']?$user['email']:'---'?>" id="email" class="inpread" /></li>
<li><span>单位：</span><input type="text" readonly value="<?=$user['company']?$user['company']:'---'?>" id="company" class="inpread" /></li>
<li><span>部门：</span> <?=$user['dep_name']?$user['dep_name']:'---'?> 
<input type="hidden" value="<?=$user['depid']?>" id="depid"   /> 
</li>
<li><span>职位：</span> <?=$user['zhiweiname']?$user['zhiweiname']:'---'?> 
<input type="hidden" value="<?=$user['zhiweiid']?>" id="zhiwei"  />
</li>
</ul>

</div>

 
</section>
 
 
 
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
 
</script>
</body>
</html>

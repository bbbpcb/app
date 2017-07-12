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
<a class="aui-btn aui-btn-warning aui-pull-left abs"  href="javascript:;" onClick="window.history.go(-1)"  id="home" > <i class="aui-iconfont aui-icon-left"></i></a>
  <div class="aui-title">关于我们</div>
   </header>
<section id="wrap">
 <div class="about">
 <img src="<?=base_url()?>static/api/images/logo.png" />
 <?=$list['content']?>
 <ul>
 <li>版本： <?=$list['version']?></li>
 <li>网址： <?=$list['website']?></li>
 <li>电话： <?=$list['tel']?></li>
 </ul>
 
 </div>
</section>
 
 
 
<script type="text/javascript" src="<?=base_url()?>static/api/script/api.js"></script>
<script type="text/javascript" src="<?=base_url()?>static/api/script/jquery.js"></script>
<script type="text/javascript" src="<?=base_url()?>static/api/script/aui-toast.js" ></script>
<script type="text/javascript">
 var toast = new auiToast({
    })
 
$(".loginbnt").click(function(){ 
	var passwd =$("#passwd").val();
	var newpasswd =$("#newpasswd").val();
	var  data={passwd:passwd};
	if( passwd != newpasswd){
		
		 toast.fail({
             title:'两次密码必须一致',
             duration:2000
             });
			 return;
		}
 
 var url="<?=base_url();?>index.php?d=api&c=userinfo&m=changepwd"; 
     $.post(url,data,
      function(res){
	  	var res = jQuery.parseJSON(res);  
		
		if(res.errcode< 0){
	 
			 toast.fail({
             title:res.errmsg,
             duration:2000
             });
			 
			}else{
	         
				 toast.success({
                    title:"密码修改成功",
                    duration:2000
                });
				
				window.history.go(-1);
			 
			 
	          }
	  })
  })
 
</script>
</body>
</html>

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
<header class="aui-bar aui-bar-nav aui-bar-warning" id="aui-header"> <a class="aui-btn aui-btn-warning aui-pull-left" href="javascript:;window.history.go(-1)" ><i class="aui-iconfont aui-icon-left"></i> </a> 登录 <a class="aui-btn aui-btn-warning aui-pull-right" >注册</a> </header>
<section id="wrap" class="pro-det">
  <div class="page-main">
    <div class="from-main">
      <div class="list"> <span class="name">用户名：</span>
        <input type="text" name="mobile" id="mobile" class="inp" placeholder="用户名">
      </div>
      <div class="list"> <span class="name">密码：</span>
        <input type="password" name="passwd" id="passwd"  class="inp"  placeholder="密码">
      </div>
    </div>
  </div>
  <div class="C"></div>
  <div class="zj">
  <span class="LE">
  <input class="aui-radio" type="radio" name="radio" checked="">&nbsp;&nbsp;记住用户名
  </span>
  <span class="R">
  <a  href="#">找回密码</a>
  </span>
  </div>
    <div class="C"></div>
  <p>
  <div class="aui-btn an aui-btn-block loginbnt">登陆</div>
  </p>
</section>
<?php $is_active = array('is_active'=>5); $this->load->view('/api/inc/footer.php',$is_active); ?>
<script type="text/javascript" src="<?=base_url()?>static/api/script/api.js"></script>
<script type="text/javascript" src="<?=base_url()?>static/api/script/aui-toast.js" ></script>
<script type="text/javascript" src="<?=base_url()?>static/api/script/jquery.js"></script>
<script type="text/javascript">
 var toast = new auiToast({
    })
$(".an").click(function(){
	var mobile =$("#mobile").val();
	var passwd =$("#passwd").val();
	
	if(mobile == ''){
		 toast.fail({
         title:"手机号不能为空",
         duration:2000
         });
        }
		if(passwd == ''){
		 toast.fail({
         title:"密码不能为空",
         duration:2000
         });
        }
	var url ="<?=base_url();?>index.php?d=api&c=login";		
	var data ={'mobile':mobile,'passwd':passwd};
	$.post(url,data,function(res){
		var res = jQuery.parseJSON(res);  
		if(res.errcode< 0){
			
			 toast.fail({
         title:res.errmsg,
         duration:2000
         });
			}else{
			 toast.success({
                    title:"登录成功",
                    duration:2000
                });
			window.location.href="<?=base_url();?>index.php?d=api&c=userinfo";
			
			}
		});	
	
	})
 
</script>
</body>
</html>

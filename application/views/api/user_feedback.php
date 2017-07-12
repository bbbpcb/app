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
<header class="aui-bar aui-bar-nav aui-bar-warning" id="aui-header"> 
<a class="aui-btn aui-btn-warning aui-pull-left abs"  href="javascript:;" onClick="window.history.go(-1)"  id="home" > <i class="aui-iconfont aui-icon-left"></i></a>
  <div class="aui-title">意见反馈</div>
 </header>
<section id="wrap">
<div class="from-main">
        <div class="list tab-ul"> 
    
             <textarea name="content" placeholder="请输入..." class="content" id="content"></textarea>
        </div>
        
  <div class="aui-btn an aui-btn-block loginbnt">提交</div>
  </div>
</section>
 
 
 
<script type="text/javascript" src="<?=base_url()?>static/api/script/api.js"></script>
<script type="text/javascript" src="<?=base_url()?>static/api/script/jquery.js"></script>
<script type="text/javascript" src="<?=base_url()?>static/api/script/aui-toast.js" ></script>
<script type="text/javascript">
 var toast = new auiToast({
    })
 
$(".loginbnt").click(function(){ 
	var content =$("#content").val();
	 
	var  data={content:content};
 
 var url="<?=base_url();?>index.php?d=api&c=feedback"; 
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
                    title:"反馈提交成功",
                    duration:2000
                });
				
				window.history.go(-1);
			 
			 
	          }
	  })
  })
 
</script>
</body>
</html>

<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="maximum-scale=1.0,minimum-scale=1.0,user-scalable=0,width=device-width,initial-scale=1.0">
<title>APP</title>
<link rel="stylesheet" type="text/css" href="<?=base_url()?>static/api/css/aui.css">
<link rel="stylesheet" type="text/css" href="<?=base_url()?>static/api/css/aui-slide.css" />
<link rel="stylesheet" type="text/css" href="<?=base_url()?>static/api/css/styles.css" />
<link rel="stylesheet" type="text/css" href="<?=base_url()?>static/api/css/dropload.css" />
 
</head>
<body>
<header class="aui-bar aui-bar-nav aui-bar-warning" id="aui-header"> 

 <a class="aui-pull-left aui-btn abs" href="javascript:;window.history.go(-1)"> <span class="aui-iconfont aui-icon-left"></span> </a>
 
 <?=$_GET['typeid']=='1'?'员工':'专家'?>积分榜
 
 </header>
<section id="wrap">
  
  <ul class="aui-list aui-media-list index-user">
  
 
  
    <li class="aui-list-item">
      <div class="aui-list-item-inner">
     
        <div class="aui-row aui-row-padded">
          <?php foreach($list as $k=>$v){?>
             <a href="<?=base_url()?>index.php?d=api&c=userinfo&m=member_integral&mid=<?=$v['id']?>"> <div class="aui-col-xs-4 ubox <?=($k+1)%3==0?'last':''?>"> <img   src="<?=$v['headerurl']?>"> <span class="name">
            <?=$v['realname']?>
            </span> <span class="inte">
            <?=$v['integraltotal']?>
            </span> </div>
            </a>   
          <?php } ?>
        </div>
      </div>
    </li>
   
  </ul>
</section>




<?php  $this->load->view('/api/inc/footer.php') ?>

<script type="text/javascript" src="<?=base_url()?>static/api/script/api.js"></script> 
<script type="text/javascript" src="<?=base_url()?>static/api/script/aui-slide.js"></script> 
<script type="text/javascript" src="<?=base_url()?>static/api/script/jquery.js"></script>
<script type="text/javascript" src="<?=base_url()?>static/api/script/dropload.min.js" ></script> 
 <script>
/*$(function(){
    // 页数
    var page = 0;
    // 每页展示5个
    var size = 6;
    
    // dropload
    $('#wrap').dropload({
        scrollArea : window,
        loadDownFn : function(me){
            page++;
            // 拼接HTML
            var result = '';
            $.ajax({
                type: 'POST',
				
				url:'<?=base_url();?>index.php?d=api&c=index&m=user_detail_list&typeid=<?=$_GET['typeid']?>',
				
				data:{limit:page*6,offset:size*page},
                dataType: 'json',
                success: function(data){
					var  data =data['data'];
					
                    var arrLen = data.length;
				    if(arrLen > 0){
					
					    $.each(data,
            function(index, el) {
        
	 
							  })
					
					
               
                    }else{
                        // 锁定
                        me.lock();
                        // 无数据
                        me.noData();
                    }
                    // 为了测试，延迟1秒加载
                    setTimeout(function(){
                        // 插入数据到页面，放到最后面
                        $('.lists').append(result);
                        // 每次数据插入，必须重置
                        me.resetload();
                    },100);
                },
                error: function(xhr, type){
                    alert('Ajax error!');
                    // 即使加载出错，也得重置
                    me.resetload();
                }
            });
        }
    });
});*/
</script>
</body>
</html>

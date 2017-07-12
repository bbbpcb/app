<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="maximum-scale=1.0,minimum-scale=1.0,user-scalable=0,width=device-width,initial-scale=1.0">
<title>APP</title>
<link rel="stylesheet" type="text/css" href="<?=base_url()?>static/api/css/aui.css">
<link rel="stylesheet" type="text/css" href="<?=base_url()?>static/api/css/aui-slide.css" />
<link rel="stylesheet" type="text/css" href="<?=base_url()?>static/api/css/styles.css" />
<link rel="stylesheet" type="text/css" href="<?=base_url()?>static/api/css/dropload.css" />
<script type="text/javascript" src="<?=base_url()?>static/api/script/jquery.js"></script>
</head>
<body>
<header class="aui-bar aui-bar-nav aui-bar-warning" id="aui-header"> <a class="aui-pull-left aui-btn" href="<?=base_url()?>"> <span class="aui-iconfont aui-icon-home"></span> </a>
  <div class="aui-searchbar" id="search">
    <div class="aui-searchbar-input aui-border-radius" tapmode onClick="doSearch()"> <i class="aui-iconfont aui-icon-search"></i>
      <form action="javascript:search();">
        <input type="search" placeholder="请输入搜索内容" id="search-input">
      </form>
    </div>
  </div>
  <a class="aui-btn aui-btn-warning aui-pull-right" > <i class="aui-iconfont aui-icon-my"></i> </a> </header>
<section id="wrap" class="wrap">
  <div class="aui-tab" id="tab">
    <div class="aui-tab-item <?=$_GET['types'] == '1'?'aui-active':''?>"> <a href="<?=base_url()?>index.php?d=api&c=review&m=review_list&types=1">参与评审</a></div>
    <div class="aui-tab-item <?=$_GET['types'] == '2'?'aui-active':''?>"> <a href="<?=base_url()?>index.php?d=api&c=review&m=review_list&types=2">发起评审</a></div>
    <div class="aui-tab-item <?=$_GET['m'] == 'project_notasklist'?'aui-active':''?>"  > <a href="<?=base_url()?>index.php?d=api&c=review&m=project_notasklist">待评审</a></div>
 
  </div>
  <ul class="aui-list aui-media-list project dotask review">
    <li class="aui-list-item aui-list-item-middle">
      <?php foreach($list as $k=>$v){ ?>
 
      <div class="aui-list-item-media rbox" > <img src="<?=$v['icon']?>" class="aui-img-round aui-list-img-sm">
        <?=$v['title']?>
        
        <a href="<?=base_url();?>index.php?d=api&c=review&m=do_review&proid=<?=$v['id']?>"><div class="fq">   <i class="aui-iconfont aui-icon-pencil"></i>发起</div></a>
      </div>
      
      <?php } ?>
    </li>
 
  </ul>
  <?php if($_GET['types'] == 2){?>
  <div class="mc"> </div>
  <div class="set" style="z-index:1"> <i class="aui-iconfont aui-icon-cert"></i>
    <p><span>+</span>发起</p>
  </div>
  <?php } ?>
</section>
<?php $is_active = array('is_active'=>4); $this->load->view('/api/inc/footer.php',$is_active); ?>
<script type="text/javascript" src="<?=base_url()?>static/api/script/api.js"></script> 
<script type="text/javascript" src="<?=base_url()?>static/api/script/aui-tab.js" ></script> 
<script type="text/javascript" src="<?=base_url()?>static/api/script/dropload.min.js" ></script> 
<script type="text/javascript">
    apiready = function(){
        api.parseTapmode();
    }
    var tab = new auiTab({
     },function(ret){
     });
 $(".set").click(function(){
 	window.location.href="<?=base_url();?>index.php?d=api&c=review&m=do_review";
})
</script> 
<script>
$(function(){
    // 页数
    var page = 0;
    // 每页展示5个
    var size = 10;
    
    // dropload
    $('.content').dropload({
        scrollArea : window,
        loadDownFn : function(me){
            page++;
            // 拼接HTML
            var result = '';
            $.ajax({
                type: 'POST',
				url:'<?=base_url();?>index.php?d=api&c=review&m=review_list',
				data:{limit:page*10,offset:size*page},
                dataType: 'json',
                success: function(data){
                    var arrLen = data.length;
                    if(arrLen > 0){
                        for(var i=0; i<arrLen; i++){
                            result +=   '<a class="item opacity" href="'+data[i].link+'">'
                                            +'<img src="'+data[i].pic+'" alt="">'
                                            +'<h3>'+data[i].title+'</h3>'
                                            +'<span class="date">'+data[i].date+'</span>'
                                        +'</a>';
                        }
                    // 如果没有数据
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
                    },1000);
                },
                error: function(xhr, type){
                    alert('Ajax error!');
                    // 即使加载出错，也得重置
                    me.resetload();
                }
            });
        }
    });
});
</script>
</body>
</html>

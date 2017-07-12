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
  <a class="aui-btn aui-btn-warning aui-pull-right"  href="javascript:;" id="menu"  > <i class="aui-iconfont aui-icon-my"></i> </a> </header>
<section id="wrap">
  <div class="page-main">
    <div class="aui-tab" id="tab">
      <div class="aui-tab-item <?=$_GET['ptype'] == 'major'|| !$_GET['ptype']?'aui-active':''?>"> <a href="<?=base_url()?>index.php?d=api&c=project&ptype=major">重大项目</a></div>
      <div class="aui-tab-item <?=$_GET['ptype'] == 'basics'?'aui-active':''?>" > <a href="<?=base_url()?>index.php?d=api&c=project&ptype=basics">基础项目</a></div>
      <div class="aui-tab-item <?=$_GET['ptype'] == 'own'?'aui-active':''?>" > <a href="<?=base_url()?>index.php?d=api&c=project&ptype=own" >创建项目</a></div>
      <div class="aui-tab-item <?=$_GET['ptype'] == 'header'?'aui-active':''?>" > <a href="<?=base_url()?>index.php?d=api&c=project&ptype=header" >负责项目</a></div>
    </div>
    <ul class="aui-list aui-media-list project">
      <li class="aui-list-item aui-list-item-middle">
        <?php foreach($list as $k=>$v){  ?>
        <div class="aui-media-list-item-inner">
          <?php if($_GET['ptype'] == 'header' ){?>
          <img class="r-img" src="<?=base_url()?>static/api/images/yaoqing<?=$v['invitestatus']?>.png" />
          <?php }else{ ?>
          <?php if($v['invitestatus'] == 2){?>
            <img class="r-img" src="<?=base_url()?>static/api/images/yaoqing2.png" />
          <?php }else{ ?>
          <img class="r-img" src="<?=base_url()?>static/api/images/project-<?=$v['status']?>.png" />
          <?php } ?>
          <?php } ?>
          <div class="aui-list-item-media" style="width: 3rem;"> <img src="<?=$v['icon']?>" class="aui-img-round aui-list-img-sm"> </div>
          <div class="aui-list-item-inner">
            <div class="aui-list-item-text">
              <div class="aui-list-item-title aui-font-size-14 aui-padded-b-10">
                <?php if($_GET['ptype']=='own' && $v['status'] == 1 &&  $v['typeid']==2){ ?>
                <a href="<?=base_url()?>?d=api&c=project&m=create_basics&proid=<?=$v['id']?>">
               <?php }elseif($_GET['ptype']=='own' && $v['typeid']==1){ ?>
                  <a href="<?=base_url()?>?d=api&c=project&m=detail&proid=<?=$v['id']?>&t=task">  
                <?php }else{ ?>
                <a href="<?=base_url()?>?d=api&c=project&m=detail&proid=<?=$v['id']?><?=$_GET['ptype']=='own' || $_GET['ptype'] =='header'?'&t='.$_GET['ptype']:''?>">
                <?php } ?>
                <?=$v['title']?>
                </a> </div>
            </div>
            <div class="aui-list-item-text">规模:
              <?=$v["scale"]?>
              难度:
              <?=$v["difficulty"]?>
              <span class="name"><img src="<?=base_url()?>static/api/images/user-<?=$v['roleid']?>.png" />
              <?=$v["header"]?>
              </span>
              <?=$v["createtime"]?>
            </div>
          </div>
        </div>
        <?php } ?>
         <div class="lists"></div>
      </li>
    </ul>
  </div>
  <?php  if($_GET['ptype'] == 'own'){?>
  <!--{创建项目}-->
  <div class="pro-task">
    <div class="title">选择所创建项目的类型<span class="cls"><i class="aui-iconfont aui-icon-close"></i></span></div>
    <div class="aui-list-item-input set-bnt">
      <div class="aui-btn an aui-btn-block "><a href="<?=base_url()?>index.php?d=api&c=project&m=create_basics">创建基础项目</a></div>
      <div class="aui-btn an aui-btn-block "><a href="<?=base_url()?>index.php?d=api&c=project&m=create_major">创建重大项目</a></div>
    </div>
  </div>
  <!--{创建项目结束}-->
  <div class="mc"> </div>
  <div class="set"> <i class="aui-iconfont aui-icon-edit"></i>
    <p><span>+</span>创建</p>
  </div>
  <?php } ?>
</section>
<?php $is_active = array('is_active'=>1); $this->load->view('/api/inc/footer.php',$is_active); ?>
<script type="text/javascript" src="<?=base_url()?>static/api/script/api.js"></script>
<script type="text/javascript" src="<?=base_url()?>static/api/script/aui-tab.js" ></script>
<script type="text/javascript" src="<?=base_url()?>static/api/script/jquery.js"></script>
<script type="text/javascript" src="<?=base_url()?>static/api/script/dropload.min.js" ></script> 
<script type="text/javascript">
    apiready = function(){
        api.parseTapmode();
    }
    var tab = new auiTab({
         },function(ret){
     });
$(".set").click(function(){
$(".mc").show();
$(".pro-task").show();
})
	$(".aui-icon-close").click(function(){
		$(".mc").hide();
		$(".pro-task").hide();
		})
		
$("#search").click(function(){
location.href="<?=base_url();?>index.php?d=api&c=index&m=seach";

})
		
</script>


<script>
$(function(){
    // 页数
    var page = 0;
    // 每页展示5个
    var size = 10;
    
    // dropload
    $('#wrap').dropload({
        scrollArea : window,
        loadDownFn : function(me){
            page++;
            // 拼接HTML
            var result = '';
            $.ajax({
                type: 'POST',
				
				url:'<?=base_url();?>index.php?d=api&c=project&ptype=<?=$_GET['ptype']?>',
				data:{limit:page*10,offset:size*page},
                dataType: 'json',
                success: function(data){
					var  data =data['data'];
					
                    var arrLen = data.length;
				    if(arrLen > 0){
					
					    $.each(data,
            function(index, el) {
 
	  result   +='<div class="aui-media-list-item-inner">';
          <?php if($_GET['ptype'] == 'header'){?>
     result   +='<img class="r-img" src="<?=base_url()?>static/api/images/yaoqing'+el['invitestatus']+'.png" />';
          <?php }else{ ?>
     result   +='<img class="r-img" src="<?=base_url()?>static/api/images/project-'+el['status']+'.png" />';
          <?php } ?>
     result   +='<div class="aui-list-item-media" style="width: 3rem;"> <img src="'+el['icon']+'" class="aui-img-round aui-list-img-sm"> </div>'
          +'<div class="aui-list-item-inner">'
            +'<div class="aui-list-item-text">'
              +'<div class="aui-list-item-title aui-font-size-14 aui-padded-b-10">';
                <?php if($_GET['ptype']=='own'){ ?>
				if( el['status'] == 1 &&  el['typeid']==2){
             result   +=' <a href="<?=base_url()?>?d=api&c=project&m=create_basics&proid='+el['id']+'">';
				}else{
			 result   +=' <a href="<?=base_url()?>?d=api&c=project&m=detail&proid='+el['id']+'&t=task">';
				}
              
                <?php }else{ ?>
             result   +='<a href="<?=base_url()?>?d=api&c=project&m=detail&proid='+el['id']+'<?=$_GET['ptype']=='own' || $_GET['ptype'] =='header'?'&t='.$_GET['ptype']:''?>">';
                <?php } ?>
                 result   +=''+el['title']+'';
                 result   +='</a></div></div>';
             
           result   +='<div class="aui-list-item-text">规模:'+el["scale"]+'难度:'+el["difficulty"]+'<span class="name"><img src="<?=base_url()?>static/api/images/user-'+el['roleid']+'.png" />'+el["header"]+'</span>'+el["createtime"]+'</div></div></div>';
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
});
</script>
<?php  $this->load->view('/api/inc/menu.php') ?>
</body>
</html>

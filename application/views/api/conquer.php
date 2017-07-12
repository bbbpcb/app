<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="maximum-scale=1.0,minimum-scale=1.0,user-scalable=0,width=device-width,initial-scale=1.0">
<title>奋斗者</title>
<link rel="stylesheet" type="text/css" href="<?=base_url()?>static/api/css/aui.css">
<link rel="stylesheet" type="text/css" href="<?=base_url()?>static/api/css/aui-slide.css" />
<link rel="stylesheet" type="text/css" href="<?=base_url()?>static/api/css/styles.css" />
<script type="text/javascript" src="<?=base_url()?>static/api/script/jquery.js"></script>
<link rel="stylesheet" type="text/css" href="<?=base_url()?>static/api/css/dropload.css" />
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
  <div class="aui-tab" id="tab">
    <div class="aui-tab-item <?=$_GET['type'] == '1'?'aui-active':''?>"> <a href="<?=base_url()?>index.php?d=api&c=conquer&type=1">讨论题目</a></div>
    <div class="aui-tab-item <?=$_GET['type'] == '2'?'aui-active':''?>"> <a href="<?=base_url()?>index.php?d=api&c=conquer&type=2">发起讨论</a></div>
    <div class="aui-tab-item <?=$_GET['type'] == '3'?'aui-active':''?>"> <a href="<?=base_url()?>index.php?d=api&c=conquer&type=3">参与讨论</a></div>
  </div>
  <ul class="aui-list aui-media-list conquer">
    <li class="aui-list-item aui-list-item-middle">
      <?php foreach($list as $k=>$v){ ?>
      <a href="<?=base_url()?>index.php?d=api&c=conquer&m=conquer_detail&cid=<?=$v['id']?><?php  if($_GET['type'] == '2'){?>&t=1<?php } ?>">
      <div class="aui-media-list-item-inner c-box"> <img class="r-img" src="<?=base_url()?>static/api/images/conquer<?=$v['status']?>.png" /> <img src="<?=$v['icon_no']!=1?$v['icon']:$v['icon'].'m.jpg'?>" class="oimg" />
        <div class="text">
          <div class="title">
            <?=$v['title']?>
            <div class="name">
              <?=$v['realname']?>
            </div>
          </div>
          <div class="canyu">参加：
            <?=$v['replytotal']?>
            人
            <div class="fenshu"> <i class="aui-iconfont aui-icon-laud c2"></i>
              <?=$v['total']?>
              分</div>
          </div>
        </div>
      </div>
      </a>
      <?php } ?>
      <div class="lists"></div>
      <div class="C"></div>
    </li>
  </ul>
  <?php  if($_GET['type'] == '2'){?>
  <div class="set"> <i class="aui-iconfont aui-icon-edit"></i>
    <p><span>+</span>创建</p>
  </div>
  <?php } ?>
</section>
<?php $is_active = array('is_active'=>3); $this->load->view('/api/inc/footer.php',$is_active); ?>
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

 	window.location.href="<?=base_url();?>index.php?d=api&c=conquer&m=conquer_create";

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

				

				url:'<?=base_url()?>index.php?d=api&c=conquer&type=<?=$_GET['type']?>',

				data:{limit:page*10,offset:size*page},

                dataType: 'json',

                success: function(data){

					var  data =data['data'];

					

                    var arrLen = data.length;

				    if(arrLen > 0){

					

					    $.each(data,

            function(index, el) {

 

	 

	  result   +='<div class="aui-media-list-item-inner c-box"> <img class="r-img" src="<?=base_url()?>static/api/images/conquer'+el['status']+'.png" />';

      result   +='<img src="'+el['icon']+'" class="oimg" />';

   

      result   +='<div class="text">';

       result   +='<div class="title">';

       result   +='<a href="<?=base_url()?>index.php?d=api&c=conquer&m=conquer_detail&cid='+el['id']+'">'+el['title']+'</a>';

       result   +='<div class="name"> '+el['realname']+'</div>';

       result   +='</div>';

        result   +='<div class="canyu">参加： '+el['replytotal']+'人';

            

        result   +='<div class="fenshu">  <i class="aui-iconfont aui-icon-laud c2"></i>'+el['total']+'分</div>';

        result   +='</div></div></div>';

	 

	 

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

                   // alert('Ajax error!');

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

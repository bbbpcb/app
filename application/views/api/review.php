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
      <div class="aui-list-item-media" > <img src="<?=$v['icon']?>" class="aui-img-round aui-list-img-sm">
        <?=$v['name']?>
      </div>
      <section class="aui-content pro_list">
        <div class="aui-card-list">
          <div class="aui-card-list-content swiper-container">
            <div class="aui-row aui-row-padded swiper-wrapper">
              <?php  if($v["modlist"]){ foreach($v["modlist"] as $k=>$val){  ?>
              <img class="r-img" src="<?=base_url()?>static/api/images/pingshen<?=$val['status']?>.png" />
              <div class="aui-col-xs-6 swiper-slide task-info">
              <span class="title"> 
                <?php if($val['status']=='3'){ ?>
                <a href="<?=base_url()?>index.php?d=api&c=review&m=get_review_finish_detail&modid=<?=$val["modid"]?>&proid=<?=$val["proid"]?>&revid=<?=$val["revid"]?>">
                <?php }else{ ?>
                <a href="<?=base_url()?>index.php?d=api&c=review&m=mod_detail&modid=<?=$val["modid"]?>&proid=<?=$val["proid"]?>">
                <?php } ?>
                <?= $val['m_name'] ?>
                </a> </span>
                <div class="r-start">
                  <?php for($i=1;$i<=5;$i++){?>
                  <div class="aui-col-xs-1"> <i data-id="<?=$i?>"  class="aui-iconfont aui-icon-star <?=$i<=$val['start']?'c2':''?>"></i>
                    <p>
                      <?=$i<=$val['start']?$i:''?>
                    </p>
                  </div>
                  <?php } ?>
                </div>
              </div>
              <?php } } ?>
            </div>
          </div>
        </div>
      </section>
      <?php } ?>
     <div class="lists"></div>
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
    $('#wrap').dropload({
        scrollArea : window,
        loadDownFn : function(me){
            page++;
            // 拼接HTML
            var result = '';
            $.ajax({
                type: 'POST',
				<?php if($_GET['types'] == 1){?>
				url:'<?=base_url();?>index.php?d=api&c=review&m=review_list&types=1',
				<?php }else{ ?>
				url:'<?=base_url();?>index.php?d=api&c=review&m=review_list&types=2',
				<?php } ?>
				data:{limit:page*10,offset:size*page},
                dataType: 'json',
                success: function(data){
					var  data =data['data'];
                    var arrLen = data.length;
				 
                    if(arrLen > 0){
					
					    $.each(data,
            function(index, el) {
			          result   +='<div class="aui-list-item-media" >'
                                    +'<img src="'+el['icon']+'" alt="">'+el['name']+''
                               +'</div>';
							   
				        $.each(el['modlist'],
                          function(index, els) {
			         result  +='<section class="aui-content pro_list">'
                                            +'<div class="aui-card-list">'
                                            +'<div class="aui-card-list-content swiper-container">'
                                            +'<div class="aui-row aui-row-padded swiper-wrapper">'
			                                +'<img class="r-img" src="<?=base_url()?>static/api/images/pingshen'+els['status']+'.png" />'
                                            +'<div class="aui-col-xs-6 swiper-slide task-info">'
                                            +'<span class="title">';
                                    if(els['status']=='3'){
                                   result  +='<a href="<?=base_url()?>index.php?d=api&c=review&m=get_review_finish_detail&modid='+els['modid']+'&proid='+els['proid']+'&revid='+els['revid']+'">';
                                   }else{ 
                                    result  +='<a href="<?=base_url()?>index.php?d=api&c=review&m=mod_detail&modid='+els['modid']+'&proid='+els['proid']+'">';
                                       } 
                                     result  +=els['m_name']+'</a></span>'
                                            +'<div class="r-start">'
             <?php for($i=1;$i<=5;$i++){?>
                  +'<div class="aui-col-xs-1"> <i class="aui-iconfont aui-icon-star <?=$i<=$val['start']?'c2':''?>"></i>'
                    +'<p>'
                      <?=$i<=$val['start']?$i:''?>
                    +'</p>'
                  +'</div>'
                  <?php } ?>
               +' </div>'
              +'</div>'
			          +'</div>'
                                            +'</div>'
                                            +'</div>';
                                           result  +='</section>';
			 
			 
			                    })   
							  })
					
					
                       /* for(var i=0; i<arrLen; i++){
                            result +=   '<div class="aui-list-item-media" >'
                                            +'<img src="'+data[i].icon+'" alt="">'+data[i].name+''
                                        +'</div>'
											+'<section class="aui-content pro_list">'
                                            +'<div class="aui-card-list">'
                                            +'<div class="aui-card-list-content swiper-container">'
                                            +'<div class="aui-row aui-row-padded swiper-wrapper">'
                                            for(var k=0; k< data[i].modlist.length;k++){ 
											
											
											   var mod =data[i].modlist;
                                            +'<img class="r-img" src="<?=base_url()?>static/api/images/pingshen'+mod[k].status+'.png" />'
                                            +'<div class="aui-col-xs-6 swiper-slide task-info">'
                                            +'<span class="title">'
                                    if(mod[k].status=='3'){
                                            +'<a href="<?=base_url()?>index.php?d=api&c=review&m=get_review_finish_detail&modid='+mod[k].modid+'&proid='+mod[k].proid+'&revid='+mod[k].revid+'">'
                                   }else{ 
                                            +'<a href="<?=base_url()?>index.php?d=api&c=review&m=mod_detail&modid='+mod[k].modid+'&proid='+mod[k].proid+'">'
                                       } 
                                            +''+mod[k].m_name+'</a></span>'
                                            +'<div class="r-start">'
             <?php for($i=1;$i<=5;$i++){?>
                  +'<div class="aui-col-xs-1"> <i data-id="<?=$i?>"  class="aui-iconfont aui-icon-star <?=$i<=$val['start']?'c2':''?>"></i>'
                    +'<p>'
                      <?=$i<=$val['start']?$i:''?>
                    +'</p>'
                  +'</div>'
                  <?php } ?>
               +' </div>'
              +'</div>'
											
										  
                                            } 
                                            +'</div>'
                                            +'</div>'
                                            +'</div>'
                                            +'</section>';
											
											
											
                             }*/
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

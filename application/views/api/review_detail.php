<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="maximum-scale=1.0,minimum-scale=1.0,user-scalable=0,width=device-width,initial-scale=1.0">
<title>APP</title>
<link rel="stylesheet" type="text/css" href="<?=base_url()?>static/api/css/aui.css">
<link rel="stylesheet" type="text/css" href="<?=base_url()?>static/api/css/aui-slide.css" />
<link rel="stylesheet" type="text/css" href="<?=base_url()?>static/api/css/styles.css" />
<link rel="stylesheet" type="text/css" href="<?=base_url()?>static/api/css/swiper.min.css" />
<script type="text/javascript" src="<?=base_url()?>static/api/script/jquery.js"></script>
<script type="text/javascript" src="<?=base_url()?>static/api/script/swiper.min.js"></script>
</head>
<body>
<header class="aui-bar aui-bar-nav aui-bar-warning" id="aui-header"> <a class="aui-pull-left aui-btn abs" href="javascript:history.go(-1);"> <span class="aui-iconfont aui-icon-left"></span> </a> 评审详情</header>
<section id="wrap" class="pro-det dotask rev-detail">
  <div class="page-info">
    <div class="aui-card-list aui-padded-b-15 sbox">
      <div class="aui-card-list-header">
        <h2>
          <?=$revinfo['m_name']?>
           <input type="hidden" value="<?=$revinfo['proid']?>" id="proid" />
          <input type="hidden" value="<?=$revinfo['id']?>" id="revid" />
          <input type="hidden" value="<?=$revinfo['modid']?>" id="modid" />
        </h2>
        <div class="C"></div>
        <div class="little" > 所属项目：
          <?=$revinfo['title']?>
          <br>
          参与人员：
          <?=$staffname?>
          
          <?=$revinfo['features']?>
          <span class="fzr">负责人：
          <?=$revinfo['realname']?>
          </span> </div>
      </div>
      <div class="C"></div>
      <div class="aui-card-list-content-padded cont">
        <?=$revinfo['intro']?>
      </div>
      <div class="m_list_g"> 评分：<span class="c1">
        <?=$ztotal?>
        分</span>
        <div class="C"></div>
        <?php foreach($memberlist as $m){?>
        <span class="name"><img src="<?=$m['headerurl']?>" />
        <?=$m['grade']?>
        分</span>
        <?php } ?>
      </div>
    </div>
    <div class="C"></div>
    
    
    <div class="dotask-box review-box">
      <ul class="tab">
        <li <?=!$_GET['s']?'class="act"':''?> data-id="1">项目评分</li>
        <li  data-id="2" <?=$_GET['s']==2?'class="act"':''?> >项目评级</li>
      </ul>
      <ul class="tab-ul <?=!$planinfo?'bg':''?>"  >
        <li class="act" id="t1"  <?=!$_GET['s']?'':'style="display:none"'?>  >
          <?php if($modgradestatus==0){?>
          <?php foreach($question as $v){?>
          <div class="title">
            <?= $v['revtitle'] ?>
          </div>
          <div class="lists">
            <div class="right-txt">
              <?=$v['revintro']?>
            </div>
            <div class="r-start clickstar"> <span class="LE">评分：</span>
              <input type="hidden" value="<?=$v['id']?>" class="qid" />
              <input type="hidden" value="" class="grade" />
              <?php for($i=1;$i<=5;$i++){?>
                <div class="aui-col-xs-1"> <i data-id="<?=$i?>"  class="aui-iconfont aui-icon-star"></i> </div>
              <?php } ?>
            </div>
          </div>
          <div class="C"></div>
          <?php } ?>
          <section class="aui-chat" id="chat">
            <div class="send">
              <div class="aui-btn an aui-btn-block " id="send">提交</div>
            </div>
          </section>
          <?php }else{ ?>
          
            <?php foreach($question_feedback as $v){?>
          <div class="title">
            <?= $v['revtitle'] ?>
          </div>
          <div class="lists">
            <div class="right-txt">
              <?=$v['revintro']?>
            </div>
            <div class="r-start "> <span class="LE">评分：</span>
             
              <?php for($i=1;$i<=5;$i++){?>
                <div class="aui-col-xs-1"> <i data-id="<?=$i?>"  class="aui-iconfont aui-icon-star <?=$i <= $v['grade']?'c3':''?>"></i> </div>
              <?php } ?>
            </div>
          </div>
          <div class="C"></div>
          <?php } ?>
          
         <section class="aui-chat" id="chat">
            <div class="send">总分 <?=$ztotal?>
              
            </div>
          </section>  
          
          
          <?php } ?>
        </li>
        <li id="t2"   <?=$_GET['s']==2?'':'style="display:none"'?>  >
          <?php if($taskgradestatus ==1){ ?>
          <?php foreach($tasklist as $v){?>
          <div class="title">
            <?= $v['title'] ?>
          </div>
          <div class="lists">
            <div class="right-txt">
              <?=$v['intro']?>
            </div>
            <div class="r-start  "> <span class="LE">评级：</span>
        
              <?php for($i=1;$i<=5;$i++){?>
              <div class="aui-col-xs-1"> <i data-id="<?=$i?>"   class="aui-iconfont aui-icon-star <?=$i <= $v['grade']?'c3':''?>" ></i> </div>
              <?php } ?>
            </div>
          </div>    <div class="C"></div>
          <?php } ?>
          
          
          <?php }else{ ?>
          <?php foreach($tasklist as $v){?>
          <div class="title">
            <?= $v['title'] ?>
          </div>
          <div class="lists">
            <div class="right-txt">
              <?=$v['intro']?>
            </div>
   
            <div class="r-start  clickstar"> <span class="LE">评分：</span>
              <input type="hidden" value="<?=$v['id']?>" class="taskid" />
              <input type="hidden" value="" class="taskgrade" />
              <?php for($i=1;$i<=5;$i++){?>
              <div class="aui-col-xs-1"> <i data-id="<?=$i?>"    class="aui-iconfont aui-icon-star <?=$i <= $v['grade']?'c3':''?>"  ></i> </div>
              <?php } ?>
            </div>
          </div>         <div class="C"></div>
          <?php } ?>
          <section class="aui-chat" id="chat">
            <div class="send">
              <div class="aui-btn an aui-btn-block " id="send1">提交</div>
            </div>
          </section>
          <?php } ?>
        </li>
      </ul>
    </div>
    
    
    
    
    
    
  </div>
  <div class="C"></div>
</section>
<div class="mc"></div>
<?php $is_active = array('is_active'=>4); $this->load->view('/api/inc/footer.php',$is_active); ?>
<script type="text/javascript" src="<?=base_url()?>static/api/script/api.js"></script> 
<script type="text/javascript" src="<?=base_url()?>static/api/script/aui-toast.js" ></script> 
<script type="text/javascript" src="<?=base_url()?>static/api/script/jquery.js" ></script> 
<script type="text/javascript">
  var toast = new auiToast({})
 $(".tab li").click(function(){
 $(".tab li").removeClass("act");
 $(this).addClass("act");
 var id = $(this).attr("data-id");
 $(".tab-ul li").hide();
 $("#t"+id).show();
  })
 
 
 $(".clickstar .aui-icon-star").click(function(){
    var star =  $(this).attr("data-id");
	 $(this).parents(".clickstar").find(".aui-icon-star").each(
            function(index, el) {
			if((index+1) <=  star ){
			 $(el).css("color","#fc0000");  
			}else{
			 $(el).css("color","#333333");  	
				}
	       });
		   
		  var qid = $(this).parents(".clickstar").find(".qid").val(); 
 		  $(this).parents(".clickstar").find(".grade").val(star);
		  
		  var qid = $(this).parents(".clickstar").find(".taskid").val(); 
 		  $(this).parents(".clickstar").find(".taskgrade").val(star);
			 
 
	 
 })
 
 
  $("#send").click(function(){
 
  var revid=$("#revid").val();
  var modid=$("#modid").val();
  var a =  new Array();
  var g = $(".grade");
   $(".qid").each(function(index, element) {
      if(g[index].value<=0){
		   alert('请设置评分');
		   return;
		   } 
		 a[$(this).val()]=g[index].value;
	 
	  });

  var url = "<?=base_url();?>index.php?d=api&c=review&m=modgrade";   
  var data ={revid:revid,modid:modid,review:a};
   $.post(url, data,
                   function(res) {
                   var res = jQuery.parseJSON(res);
				    if (res.errcode < 0) {
						  toast.fail({
                             title: res.errmsg,
                             duration: 2000
                                      });
                             } else {
							 toast.success({
                              title:"信息提交成功",
                              duration:2000
                           });
						   window.location.href = document.location.href;
				         
								 
			
			                 }
	   })
   })
   
   
   $("#send1").click(function(){
 
  var revid=$("#revid").val();
  var proid=$("#proid").val();
  var a =  new Array();
  var g = $(".taskgrade");
   $(".taskid").each(function(index, element) {
      if(g[index].value<=0){
		   alert('请设置评分');
		   return;
		   } 
		 a[$(this).val()]=g[index].value;
	 
	  });

  var url = "<?=base_url();?>index.php?d=api&c=review&m=taskgrade";   
  var data ={revid:revid,proid:proid,review:a};
   $.post(url, data,
                   function(res) {
                   var res = jQuery.parseJSON(res);
				    if (res.errcode < 0) {
						  toast.fail({
                             title: res.errmsg,
                             duration: 2000
                                      });
                             } else {
							 toast.success({
                              title:"信息提交成功",
                              duration:2000
                           });
						   window.location.href = document.location.href;
				         
								 
			
			                 }
	   })
   })
 
</script>
</body>
</html>

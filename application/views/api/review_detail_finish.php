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
<header class="aui-bar aui-bar-nav aui-bar-warning" id="aui-header"> <a class="aui-pull-left aui-btn abs" href="javascript:history.go(-1);"> <span class="aui-iconfont aui-icon-left"></span> </a> 评审结束</header>
<section id="wrap" class="pro-det  rev-detail">
  <div class="page-info">
    <div class="aui-card-list aui-padded-b-15 sbox">
      <div class="aui-card-list-header">
        <h2>
          <?=$revinfo['m_name']?>
 
          <input type="hidden" value="<?=$revinfo['id']?>" id="revid" />
 
        </h2>
        <div class="C"></div>
        <div class="aui-card-list aui-padded-b-15">
          <div class="aui-card-list-header" style="padding:0">
            <div class="C"></div>
            <div class="little" > 规模:
              <?=$revinfo['scale']?>
              难度:
              <?=$revinfo['difficulty']?>
              质量:
              <?=$revinfo['quality']?>
              特性:
              <?=$$revinfo['features']?>
              <span class="fzr">负责人：
              <?=$revinfo['realname']?>
              </span> </div>
          </div>
          <div class="C"></div>
          <div class="aui-card-list-content-padded cont" style="margin:0">
            <?=$revinfo['intro']?>
          </div>
          
        </div>
      </div>
      <div class="m_list_g fg"> 
      
      参与人员：</span>
        <div class="C"></div>
        <?php foreach($memberlist as $m){?>
        <span class="name"><img src="<?=$m['headerurl']?>" /> </span>
        <?php } ?>
      </div>
           <div class="C"></div>
    </div>
    <div class="C"></div>
    <div class="resend"> <span class="sh"></span>
      <div class="title">评审结果</div>
        <?php foreach($question_feedback as $v){?>
          <div class="titles">
            <?= $v['revtitle'] ?>
           
         <span class="R"> <?= $v['grade'] ?>分</span>
          </div>
          <div class="C"></div>
          <?php } ?>
  
    <?php foreach($tasklist as $v){?>
          <div class="titles">
            <?= $v['title'] ?>
          
          <span class="R">  <?= $v['grade'] ?> 分  </span>
       
          </div>    <div class="C"></div>
          <?php } ?>
          
  
    </div>
  </div>
  <div class="C"></div>
  
    <section class="aui-chat dz" id="chat">
            <div class="send">
              <span class="zan"><i class="aui-iconfont aui-icon-laud"></i>已有<?=$revinfo['praise']?>人点赞</span>
              <div class="aui-btn an aui-btn-block" id="send1" style="width:20%; float:right">点赞</div>
            </div>
          </section>
  
  
</section>
<div class="mc"></div>
 
 
 
 
<script type="text/javascript" src="<?=base_url()?>static/api/script/api.js"></script> 
<script type="text/javascript" src="<?=base_url()?>static/api/script/aui-toast.js" ></script> 
<script type="text/javascript" src="<?=base_url()?>static/api/script/jquery.js" ></script> 
<script type="text/javascript">
  var toast = new auiToast({})
  $("#send1").click(function(){
 
  var revid=$("#revid").val();
 
  var url = "<?=base_url();?>index.php?d=api&c=review&m=review_praise";   
  var data ={revid:revid};
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
                              title:"点赞成功",
                              duration:2000
                           });
						   window.location.href = document.location.href;
				         
								 
			
			                 }
	   })
   })
 
</script>
</body>
</html>

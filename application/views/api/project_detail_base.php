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
<a class="aui-pull-left aui-btn" href="javascript:history.go(-1);">
 <span class="aui-iconfont aui-icon-left"></span> </a> 项目详情 

<?php if($_GET['t']=='own' && $projectinfo['status'] == 2 ){?>
<a class="aui-pull-right aui-btn" href="javascript:;" onClick="closeproject(<?=$projectinfo['id']?>,2)">关闭</a>
<?php } ?>

</header>
<section id="wrap" class="pro-det">
  <?php if($invitstatus == 0){?>
  <img class="r-img" src="<?=base_url()?>static/api/images/yaoqing<?=$invitstatus?>.png" /> <span class="topnote">
  <?=$projectinfo['realname']?>
  邀请您为此项目负责人</span>
  <?php }else{ ?>
  <?php if($_GET['t']=='header'){?>
  <img class="r-img" src="<?=base_url()?>static/api/images/yaoqing<?=$invitstatus?>.png" />
  <?php }else{ ?>
  <img class="r-img" src="<?=base_url()?>static/api/images/project-<?=$projectinfo['status']?>.png" />
  <?php } ?>
  <?php } ?>
  <div class="aui-card-list  aui-padded-b-15  base">
    <div class="aui-card-list-header">
      <h2>
        <?=$projectinfo['title']?>
      </h2>
      <div class="C"></div>
      <div class="little" > 规模:
        <?=$projectinfo['scale']?>
        难度:
        <?=$projectinfo['difficulty']?>
        质量:
        <?=$projectinfo['quality']?>
        特性:
        <?=$projectinfo['features']?>
        <span class="fzr">负责人：
        <?=$projectinfo['header']?>
        </span> </div>
      <div class="little" > 标准分：
        <?=$projectinfo['total']?>
        领取人数：
        <?=$projectinfo['receive_num']?>
      </div>
    </div>
    <div class="C"></div>
    <div class="aui-card-list-content-padded">
      <?=$projectinfo['intro']?>
    </div>
    <div class="base-info">
      <?php if($receive){?>
      <?php foreach($receive as $k=>$v){ ?>
      <?php if($k=='duli'){?>
      <div class="list"> <span class="title"> 独立[
        <?=$v['grade']?>
        分]: </span> <span class="imb">
        <?php foreach($v['member'] as  $val){?>
        <img src="<?=$val['header']?>">
        <?=$val['realname']?>
        <?=$val['grade']?>
        分&nbsp;
        <?php } ?>
        </span> <br>
      </div>
      <?php } ?>
      <?php if($k=='hexin'){?>
      <div class="list"> <span class="title"> 核心[
        <?=$v['grade']?>
        分]: </span> <span class="imb">
        <?php foreach($v['member'] as  $val){?>
        <span class="imbt"> <img src="<?=$val['header']?>">
        <?=$val['realname']?>
        <?=$val['grade']?>
        分&nbsp;</span>
        <?php } ?>
        </span> <br>
      </div>
      <?php } ?>
      <?php if($k=='canyu'){?>
      <div class="list"> <span class="title"> 参与[
        <?=$v['grade']?>
        分]: </span> <span class="imb">
        <?php foreach($v['member'] as  $val){?>
        <span class="imbt"> <img src="<?=$val['header']?>">
        <?=$val['realname']?>
        <?=$val['grade']?>
        分&nbsp;</span>
        <?php } ?>
        </span> <br>
      </div>
      <?php } ?>
      <?php } ?>
      <?php } ?>
    </div>
    <div class="C"></div>
  </div>
  <section class="aui-chat" id="chat">
    <?php if($invitstatus == 0){?>
    <div class="send inv">
      <div class="aui-btn  aui-btn-block 	L" onClick="inv(<?=$projectinfo['id'] ?>,1)">接受邀请</div>
      <div class="aui-btn  aui-btn-block  R" onClick="inv(<?=$projectinfo['id'] ?>,2)">拒绝邀请</div>
    </div>
    <?php }else{?>
    <?php if(!$_GET['t']){?>
    <div class="send">
      <div class="aui-btn an aui-btn-block ">领取</div>
    </div>
    <?php } ?>
    <?php } ?>
  </section>
</section>
<!--{领取任务}-->
<div class="pro-task">
  <div class="title">领取任务<span class="cls"><i class="aui-iconfont aui-icon-close"></i></span></div>
  <div class="contents">
    <h2>
      <?=$projectinfo['title']?>
    </h2>
    <div class="text">
      <?=$projectinfo['intro']?>
    </div>
    <div class="pin">
      <div class="pin"> 规模:
        <?=$projectinfo['scale']?>
        难度:
        <?=$projectinfo['difficulty']?>
        <br>
        项目归属:
        <?=$projectinfo['title']?>
        <br>
        项目类型:
        <?=$projectinfo['title']?>
        <br>
        <?php if($receive){?>
        <?php foreach($receive as $k=>$v){ ?>
        <?php if($k=='duli'){?>
        独立[
        <?=$v['grade']?>
        分]:
        <?php foreach($v['member'] as  $val){?>
        <?=$val['realname']?>
        <?=$val['grade']?>
        分&nbsp;
        <?php } ?>
        <br>
        <?php } ?>
        <?php if($k=='hexin'){?>
        核心[
        <?=$v['grade']?>
        分]:
        <?php foreach($v['member'] as  $val){?>
        <?=$val['realname']?>
        <?=$val['grade']?>
        分&nbsp;
        <?php } ?>
        <br>
        <?php } ?>
        <?php if($k=='canyu'){?>
        参与[
        <?=$v['grade']?>
        分]:
        <?php foreach($v['member'] as  $val){?>
        <?=$val['realname']?>
        <?=$val['grade']?>
        分&nbsp;
        <?php } ?>
        <br>
        <?php } ?>
        <?php } ?>
        <?php } ?>
      </div>
    </div>
    <div class="choose">
      <div class="aui-list-item-input">
        <label>
        <input class="aui-radio" type="radio" value="1" name="roleid" checked>
        独立</label>
        <label>
        <input class="aui-radio" type="radio" value="2"  name="roleid">
        核心</label>
        <label>
        <input class="aui-radio" type="radio" value="3"  name="roleid">
        参与</label>
      </div>
      <div class="aui-btn an bn">领取</div>
    </div>
  </div>
</div>
<!--{领取任务结束}-->
<div class="note">
  <div class="title">领取任务<span class="cls"><i class="aui-iconfont aui-icon-close"></i></span></div>
  <div class="text"> 亲爱的任务领取人，此任务已被您成功领取！祝您玩的愉快！ </div>
  <div class="aui-btn bn">谢谢去完成任务</div>
</div>
<div class="mc"></div>
<script type="text/javascript" src="<?=base_url()?>static/api/script/api.js"></script>
<script type="text/javascript" src="<?=base_url()?>static/api/script/aui-toast.js" ></script>
<script type="text/javascript" src="<?=base_url()?>static/api/script/jquery.js" ></script>
<script type="text/javascript" src="<?=base_url()?>static/api/script/project.js"></script>
<script type="text/javascript">
  var toast = new auiToast({
  });	
	$(".an").click(function() {
    $(".mc").show();
	$(".pro-task").show();	
    var modid = $(this).find(".modid").val();
    var mid = <?=$projectinfo['mid'] ?>;
    var proid = <?=$projectinfo['id'] ?>;
    var typeid = <?=$projectinfo['typeid'] ?>;
    var company_id = <?=$projectinfo['company_id'] ?>;
    var url = "<?=base_url();?>index.php?d=api&c=task&m=detail";
   
		   $(".bn").click(function(){
				  var url = "<?=base_url();?>index.php?d=api&c=task&m=receive";   
				  var roleid =$('input:radio:checked').val();
				 
			 var datas = {
                   
                   'modid': modid,
                   'mid': mid,
				   'roleid':roleid,
                   'proid': proid,
                   'typeid': typeid,
                   'company_id': company_id
           };
				   $.post(url, datas,
                   function(res) {
                   var res = jQuery.parseJSON(res);
				    if (res.errcode < 0) {
						  toast.fail({
                             title: res.errmsg,
                             duration: 2000
                                      });
                             } else {
								 
			           toast.success({
                              title:"任务领取成功",
                              duration:2000
                           });
				        location.reload(); 
								 
			
			                 }
				           })
							 
				   })
							 //结束 
 
 
})
 
 $(".pro-task .aui-icon-close").click(function(){
		$(".mc").hide();
		$(".pro-task").hide();
		})
    <?php if($invitstatus == 0){?>	 
function inv(pid,type){
     var mid=<?=$projectinfo['mid'] ?>;
	 var headid=<?=$projectinfo['headid'] ?>;
	 var url = "<?=base_url();?>index.php?d=api&c=project&m=invitestatus";
	  $.post(url,{proid:pid,type:type,headid:headid,mid:mid},
                   function(res) {
                   var res = jQuery.parseJSON(res);
				    if (res.errcode < 0) {
						  toast.fail({
                             title: res.errmsg,
                             duration: 2000
                                  });
                             } else {
								 
			               toast.success({
                              title:"提交成功",
                              duration:2000
                           });
						   
				        location.reload(); 
			  }
				           })
							 
		 
	
}	
<?php } ?> 
	 
</script>
</body>
</html>

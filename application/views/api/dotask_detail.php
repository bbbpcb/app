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
<header class="aui-bar aui-bar-nav aui-bar-warning" id="aui-header"> <a class="aui-pull-left aui-btn abs" href="javascript:history.go(-1);"> <span class="aui-iconfont aui-icon-left"></span> </a> 任务指导</header>
<section id="wrap" class="pro-det dotask">
  <div class="page-info">
    <div class="member_zj">
      <div class="title">我的专家：</div>
      <div class="aui-row aui-row-padded">
        <?php foreach($member_ex as $k=>$v){?>
        <div class="aui-col-xs-4 ubox <?=($k+1)%3==0?'last':''?>">
          <input type="hidden" value="<?=$v['exid']?>" class="id" />
          <span class="aui-col-xs-6"> <img   src="<?=$v['headerurl']?>"> </span> <span class="aui-col-xs-6 name">
          <?=$v['realname']?>
          </span> </div>
        <?php } ?>
      </div>
    </div>
    <div class="aui-card-list aui-padded-b-15">
      <div class="aui-card-list-header">
        <h2>
          <?=$taskinfo['title']?>
          <input type="hidden" value="<?=$taskinfo['id']?>" id="taskid" />
          <input type="hidden" value="<?=$taskinfo['typeid']?>" id="typeid" />
          <input type="hidden" value="<?=$taskinfo['proid']?>" id="proid" />
          <input type="hidden" value="<?=$taskinfo['mid']?>" id="taskmid" />
        </h2>
        <div class="C"></div>
        <div class="little" > 项目：
          <?=$taskinfo['ptitle']?>
          <br>
          规模:
          <?=$taskinfo['scale']?>
          难度:
          <?=$taskinfo['difficulty']?>
          质量:
          <?=$taskinfo['quality']?>
          特性:
          <?=$taskinfo['features']?>
          <span class="fzr">负责人：
          <?=$taskinfo['headrealname']?>
          </span> </div>
      </div>
      <div class="C"></div>
      <div class="aui-card-list-content-padded cont">
        <?=$taskinfo['intro']?>
      </div>
    </div>
    <div class="C"></div>
    <div class="dotask-box">
      <ul class="tab">
        <li <?=!$_GET['s']?'class="act"':''?> data-id="1">立项与策划</li>
        <li  data-id="2" <?=$_GET['s']==2?'class="act"':''?> >问题与解决</li>
        <li data-id="3"  <?=$_GET['s']==3?'class="act"':''?>  >结果与反思</li>
      </ul>
      <ul class="tab-ul <?=!$planinfo?'bg':''?>"  >
        <li class="act" id="t1"  <?=!$_GET['s']?'':'style="display:none"'?>  >
          <div class="txt">
            <?php if($planinfo){?>
            <?=$planinfo['content']?>
            <?php }else{?>
            <textarea name="content" placeholder="请输入..." class="content" id="content">
           </textarea>
            <section class="aui-chat" id="chat">
              <div class="send">
                <div class="aui-btn an aui-btn-block " id="plan">提交</div>
              </div>
            </section>
            <?php } ?>
          </div>
          <?php if($planlist){?>
          <div class="title">专家点评</div>
          <?php foreach($planlist as $v){?>
          <div class="lists">
            <div class="left-name"> <img src="<?=$v['headerurl']?>" />
              <?=$v['realname']?>
            </div>
            <div class="right-txt">
              <?=date('Y-m-d',$v['createtime'])?>
              <br>
              <?=$v['content']?>
            </div>
          </div>
          <?php } ?>
          <?php } ?>
          <?php if($planstatus==1 && $exstatus==0){?>
          <input type="hidden" value="<?=$planinfo['id']?>" id="planid" />
          <section class="aui-chat" id="chat">
            <div class="send">
              <input type="text" name="msg" id="lmsg" class="msg"  placeholder="请输入您的点评" />
              <div class="aui-btn an aui-btn-block" id="send1" style="width:20%; float:right">发送</div>
            </div>
          </section>
          <?php } ?>
        </li>
        <li id="t2"   <?=$_GET['s']==2?'':'style="display:none"'?>  >
          <?php if($taskwentilist){ ?>
          <?php foreach($taskwentilist as $v){?>
          <div class="lists">
            <div class="left-name">
              <?=$v['realname']?>
            </div>
            <div class="right-txt">
              <?= $v['createtime'] ?>
              <span class="replay" ><i class="aui-iconfont aui-icon-comment"></i>
              <?=$v['replycount']?>
              </span> <br>
              <?=$v['content']?>
            </div>
          </div>
          <?php } ?>
          <?php if($fabustatus==1  && $exstatus ==0){?>
          <section class="aui-chat" id="chat">
            <div class="send">
              <input type="text" name="msg" id="msg"  placeholder="请输入..." />
              <div class="aui-btn an aui-btn-block" id="send" style="width:20%; float:right">发送</div>
            </div>
          </section>
          <?php } ?>
          <?php }else{ ?>
          <textarea name="content" placeholder="请输入..." class="content" id="content1">
           </textarea>
          <section class="aui-chat" id="chat">
            <div class="send">
              <div class="aui-btn an aui-btn-block " id="send">提交</div>
            </div>
          </section>
          <?php } ?>
        </li>
        <li id="t3"  <?=$_GET['s']==3?'':'style="display:none"'?>  >
          <?php if($resultinfo){?>
          <div class="btxt">
            <div class="btitle">完成情况：</div>
            <?=$resultinfo['qingkuang']?>
            <div class="btitle">实际费用：</div>
            <?=$resultinfo['feiyong']?>
            <div class="btitle">实际天数：</div>
            <?=$resultinfo['tianshu']?>
          </div>
          <div class="C"></div>
          <?php foreach($resultexlist as $v){?>
          <div class="lists">
            <div class="left-name"> <img src="<?=$v['headerurl']?>" />
              <?=$v['realname']?>
            </div>
            <div class="right-txt">
              <?= $v['createtime'] ?>
              <span class="replay" ><i class="aui-iconfont aui-icon-comment"></i>
              <?=$v['replycount']?>
              </span> <br>
              <?=$v['content']?>
            </div>
          </div>
          <div class="C"></div>
          <?php } ?>
          <div class="title">专家评分：</div>
          <?php foreach($task_markinglist as $v){?>
          <div class="pf">
            <?=$v['realname']?>
            : <span class="c1">
            <?=$v['score']?>
            分</span> </div>
          <?php } ?>
          <?php if($fentotal){?>
          <div class="jifen"> 积分：<span class="c1">
            <?=$fentotal?>
            分</span> </div>
          <?php } ?>
          <?php }else{  ?>
          <div class="btxt">
            <div class="btitle">完成情况：</div>
            <input type="text" id="qingkuang"  placeholder="请输入..."  />
            <div class="btitle">实际费用：</div>
            <input type="text" id="feiyong"  placeholder="请输入..."  />
            <div class="btitle">实际天数：</div>
            <input type="text" id="tianshu"  placeholder="请输入..."  />
          </div>
          <section class="aui-chat" id="chat">
            <div class="send">
              <div class="aui-btn an aui-btn-block " id="res">提交</div>
            </div>
          </section>
          <?php } ?>
          <?php if($_GET['make'] == 1 && $exgragestatus == 0 && $exstatus==0){ ?>
          <section class="aui-chat" id="chat">
            <div class="send">
              <div class="aui-btn an aui-btn-block " id="pingfen">我要评分</div>
            </div>
          </section>
          <?php  } ?>
          <?php if($resultstatus==1 && !$_GET['make'] && $exstatus ==0){?>
          <section class="aui-chat" id="chat">
            <div class="send">
              <input type="hidden" value="<?=$resultinfo['id']?>" id="resultid" />
              <input type="text" name="msg" class="msg" id="rmsg"  placeholder="请输入您的点评" />
              <div class="aui-btn an aui-btn-block" id="sendr" style="width:20%; float:right">发送</div>
            </div>
          </section>
          <?php } ?>
        </li>
      </ul>
    </div>
  </div>
  <div class="C"></div>
  <?php if($_GET['make'] == 1 && $exgragestatus == 0){ ?>
  <!--{打分}-->
  <div class="pro-task df">
    <div class="title">请打分<span class="cls"><i class="aui-iconfont aui-icon-close"></i></span></div>
    <div class="contents">
      <input type="hidden" value="" id="scale">
      <?php $n = array('不达标','基本达标','达标','优秀','超出'); ?>
      <?php for($i=1;$i<=5;$i++){?>
      <div class="aui-col-xs-1"> <i data-id="<?=$i?>" <?=$i<=$proinfo['scale']?'style="color: rgb(252, 0, 0);"':''?> class="aui-iconfont aui-icon-star"><p><?=$n[$i-1]?></p></i> </div>
      <?php } ?>
      <div class="aui-btn an " id="tj" >提交</div>
    </div>
  </div>
  <!--{打分结束}-->
  <?php } ?>
</section>
<div class="mc"></div>
<?php $is_active = array('is_active'=>2); $this->load->view('/api/inc/footer.php',$is_active); ?>
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
  
  $("#plan").click(function(){
  var content = $("#content").val();
 
  var taskid=$("#taskid").val();
  var url = "<?=base_url();?>index.php?d=api&c=dotask&m=dotask_plan";   
  var data ={taskid:taskid,content:content};
  
   $.post(url, data,
                   function(res) {
                   var res = jQuery.parseJSON(res);
				    if (res.errcode < 0) {
						  toast.fail({
                             title: res.errmsg,
                             duration: 2000
                                      });
							 return;
                             } else {   
							   toast.success({
                              title:"信息提交成功",
                              duration:2000
                           });
				        location.reload(); 
								 
			
			                 }
	   })
   })
   
   
  $("#send").click(function(){
  
  var content = $("#content1").val();
  if(!content){
  content = $("#msg").val();
  }
  var taskid=$("#taskid").val();
  var url = "<?=base_url();?>index.php?d=api&c=dotask&m=dotask_wenti";   
  var data ={taskid:taskid,content:content};
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
						   window.location.href = document.location.href+'&s=2';
				  }
	   })
   })
   
   
   $("#send1").click(function(){
   var content = $("#lmsg").val();
  
  var planid=$("#planid").val();
  var url = "<?=base_url();?>index.php?d=api&c=dotask&m=dotask_plan_reply";   
  var data ={planid:planid,content:content};
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
                              title:"点评提交成功",
                              duration:2000
                           });
						   window.location.href = document.location.href;
				  }
	   })
   })
   
   
   
      $("#sendr").click(function(){
   var content = $("#rmsg").val();
  
  var planid=$("#resultid").val();
  var url = "<?=base_url();?>index.php?d=api&c=dotask&m=dotask_result_reply";   
  var data ={fansiid:planid,content:content};
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
                              title:"点评提交成功",
                              duration:2000
                           });
						  // window.location.href = document.location.href+'&s=3';
				  }
	   })
   })
   
  
      
   
   
     $("#res").click(function(){
   
  var taskid=$("#taskid").val();
  var qingkuang=$("#qingkuang").val();
  var feiyong=$("#feiyong").val();
  var tianshu=$("#tianshu").val();
  var url = "<?=base_url();?>index.php?d=api&c=dotask&m=dotask_result";   
  var data ={taskid:taskid,qingkuang:qingkuang,feiyong:feiyong,tianshu:tianshu};
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
						   window.location.href = document.location.href+'&s=3';
				         
								 
			
			                 }
	   })
   })
   
   $("#pingfen").click(function(){
	  $(".mc").show();
	  $(".pro-task").show(); 
	 
	   })
  $(".contents .aui-icon-star").click(function(){
    var star =  $(this).attr("data-id");
       $(".contents .aui-icon-star").each(
            function(index, el) {
			if((index+1) <=  star ){
			 $(el).css("color","#fc0000");  
			 
			}
			 });
	 $("#scale").val(star); 
	  var taskid=$("#taskid").val();
	  var typeid = $("#typeid").val();//1为重大项目2位基础项目
	  var projectid = $("#proid").val();//项目id
	  var taskmid =$("#taskmid").val();//任务或所属项目mid
      var score= $("#scale").val();//分数
	  $("#tj").click(function(){
		  
  var url = "<?=base_url();?>index.php?d=api&c=dotask&m=dotask_marking";   
  var data ={taskid:taskid,typeid:typeid,proid:projectid,taskmid:taskmid,score:score};
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
                              title:"分数提交成功",
                              duration:2000
                           });
						   window.location.href = document.location.href+'&s=3';
				         
								 
			
			                 }
	   })
		  
		  })
	 
 })
</script>
</body>
</html>

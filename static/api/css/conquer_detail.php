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
<header class="aui-bar aui-bar-nav aui-bar-warning" id="aui-header"> <a class="aui-pull-left aui-btn" href="javascript:history.go(-1);"> <span class="aui-iconfont aui-icon-left"></span> </a>
  <div class="aui-title">复盘详情</div>
</header>
<section id="wrap" class="pro-det dotask conquer-detail">
  <div class="page-info">
    <div class="de-imgbox">   <img src="<?=$info['icon_no']!=1?$info['icon']:$info['icon'].'m.jpg'?>" style="width:100%; " class="oimg" />
      <div class="txt"> 所属项目：
        <?=$info['proname']?>
      </div>
    </div>
    <div class="aui-card-list aui-padded-b-15">
      <div class="aui-card-list-header">
        <h2>
          <?=$info['title']?>
          <input type="hidden" value="<?=$info['id']?>" id="cid" />
          <input type="hidden" value="<?=$info['uid']?>" id="mid" />
        </h2>
        <div class="C"></div>
        <div class="little" >
          <?=$info['ptitle']?>
          <?=$info['realname']?>
        </div>
        <?=$info['content']?>
      </div>
      <div class="C"></div>
      <div class="aui-card-list-content-padded cont">
        <?=$taskinfo['intro']?>
      </div>
    </div>
    <?php if(strlen($info['summary'])>1){ ?>
    <div class="C"></div>
    <div class="height"></div>
    <div class="dotask-box">
      <ul class="tab-ul"   >
        <li class="act" id="t1" >
          <div class="txt">
          <div class="title">专家总结 </div>
          <div class="lists">
            <?=$info['summary']?>
            <br>
            <?=date('Y-m-d',$info['endtime'])?>
          </div>
        </li>
      </ul>
    </div>
    <?php }else{ ?>
    <?php if($zjstatus == 1){?>
    <div class="C"></div>
    <div class="heightbox">
      <div class="aui-btn an aui-btn-block " id="zj">总结</div>
    </div>
    <?php } ?>
    <?php } ?>
    <div class="C"></div>
    <div class="height"></div>
    <div class="dotask-box">
      <ul class="tab-ul"   >
        <li class="act" id="t1" >
          <div class="txt">
          <div class="title">讨论专区 <span>参加:<span>人</span><span class="c1">
            <?=$total?>
            </span></span></div>
          <?php foreach($replylist as $v){?>
          <div class="lists">
            <div class="left-name" data-id="<?=$v['id']?>"> <img src="<?=$v['headerurl']?>" />
              <?=$v['realname']?>
            </div>
            <div class="right-txt">
              <?=date('Y-m-d',$v['createtime'])?><?php if($v['isbest']==1){?>&nbsp;<div class="aui-label aui-label-info">最优</div> <?php } ?>
              <br>
              <?=$v['content']?>
            </div>
          </div>
          <?php } ?>
        </li>
      </ul>
    </div>
    <section class="aui-chat" id="chat">
      <div class="send">
        <input type="text" name="msg" id="msg"  placeholder="请输入您的回答" />
        <div class="aui-btn an aui-btn-block" id="msgb" style="width:20%; float:right">发送</div>
      </div>
    </section>
  </div>
  <div class="C"></div>
</section>
<?php if($zjstatus == 1){?>
<div class="c-content pro-det">
  <textarea  id="content" > </textarea>
  <span class="note c2">注意：字数限制在500字以内！</span>
  <section class="aui-chat" id="chat">
    <div class="send">
      <div class="aui-btn an aui-btn-block " id="res">提交</div>
    </div>
  </section>
</div>
<?php } ?>
<div class="mc"></div>
<?php $is_active = array('is_active'=>3); $this->load->view('/api/inc/footer.php',$is_active); ?>
<script type="text/javascript" src="<?=base_url()?>static/api/script/api.js"></script> 
<script type="text/javascript" src="<?=base_url()?>static/api/script/aui-toast.js" ></script> 
<script type="text/javascript" src="<?=base_url()?>static/api/script/jquery.js" ></script> 
<script type="text/javascript" src="<?=base_url()?>static/api/script/aui-dialog.js" ></script>
<script type="text/javascript">

  var toast = new auiToast({})
    $("#zj").click(function(){
      var cid =$("#cid").val();

      $(".aui-title").html('总结');

	  $(".conquer-detail").hide();

	  $(".c-content").show(); 

	  $("#res").click(function(){

	   var content =$("#content").val();

		var url = "<?=base_url();?>index.php?d=api&c=conquer&m=summary";  

		var data={cid:cid,content:content};

		

		      $.post(url, data,

                   function(res) {

                   var res = jQuery.parseJSON(res);

				    if (res.errcode < 0) {

						  toast.fail({

                             title: res.errmsg,

                             duration: 2000

                                      });

                             } else {     toast.success({

                              title:"信息提交成功",

                              duration:2000

                           });

				        location.reload(); 

						  }

						  

	                  })

		             })

	  

	  }) 

 $("#msgb").click(function(){

	 var cid =$("#cid").val();

	 var mid =$("#mid").val();

	 var content =$("#msg").val();

	 var url = "<?=base_url();?>index.php?d=api&c=conquer&m=reply";  

		var data={cid:cid,content:content,mid:mid};

		

		      $.post(url, data,

                   function(res) {

                   var res = jQuery.parseJSON(res);

				    if (res.errcode < 0) {

						  toast.fail({

                             title: res.errmsg,

                             duration: 2000

                                      });

                             } else {     toast.success({

                              title:"信息提交成功",

                              duration:2000

                           });

				        location.reload(); 

						  }

				  })

		 })

 var dialog = new auiDialog({})	 
$(".left-name").click(function(){
	var id=$(this).attr('data-id');
	  dialog.alert({
                    title:"弹出提示",
                    msg:'是否设为最优',
                    buttons:['取消','确定']
                },function(ret){
					console.log(ret.buttonIndex);
                    if(ret.buttonIndex == 2){
						var url ="<?=base_url();?>index.php?d=api&c=conquer&m=conquer_isbest";
						var data={replyid:id};
						
						
						 $.post(url, data,

                   function(res) {

                   var res = jQuery.parseJSON(res);

				    if (res.errcode < 0) {

						  toast.fail({

                             title: res.errmsg,

                             duration: 2000

                                      });

                             } else {     toast.success({

                              title:"设置成功",

                              duration:2000

                           });

				        location.reload(); 

						  }

				  })
						
						
						}
                })
	
	})
 

</script>
</body>
</html>

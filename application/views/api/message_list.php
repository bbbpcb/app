<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="maximum-scale=1.0,minimum-scale=1.0,user-scalable=0,width=device-width,initial-scale=1.0">
<title>APP</title>
<link rel="stylesheet" type="text/css" href="<?=base_url()?>static/api/css/aui.css">
<link rel="stylesheet" type="text/css" href="<?=base_url()?>static/api/css/aui-slide.css" />
<link rel="stylesheet" type="text/css" href="<?=base_url()?>static/api/css/styles.css" />
<style type="text/css">
 
#chat {
	display:none
}
</style>
</head>
<body>
<header class="aui-bar aui-bar-nav aui-bar-warning" id="aui-header"> <a class="aui-btn aui-btn-warning aui-pull-left"  href="javascript:;" onClick="window.history.go(-1)" > <i class="aui-iconfont aui-icon-left"></i></a>
  <div class="aui-title">问答箱</div>
  <a class="aui-btn aui-btn-warning aui-pull-right"  onClick="javascript:void(0)" id="plus" > <i class="aui-iconfont aui-icon-my"></i>
  <div class="aui-label top-plus">+</div>
  </a> </header>
<section id="wrap">
  <div class="aui-content" id="mag_list">
    <ul class="aui-list aui-media-list">
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
    </ul>
  </div>
  
  <ul class="aui-list aui-media-list" id="msg_list">
   <?php foreach($messages_list as $k=>$v){  ?>
    <li class="aui-list-item aui-list-item-middle ubox">
    <input type="hidden" value="<?=$v['send_id']?>" class="id">
      <div class="aui-media-list-item-inner">
        <div class="aui-list-item-media" style="width: 3rem;"> <img src="<?=$v['sendheaderurl']?>" class="aui-img-round aui-list-img-sm"> </div>
        <div class="aui-list-item-inner aui-list-item-arrow">
          <div class="aui-list-item-text">
            <div class="aui-list-item-title aui-font-size-14"><?=$v['sendrealname']?></div>
          </div>
          <div class="aui-list-item-text"> <?=$v['msg']?></div>
        </div>
      </div>
    </li>
      <?php } ?>
  </ul>
  
  <div class="aui-content aui-margin-b-15" id="mem_list">
    <ul class="aui-list aui-media-list">
    </ul>
 
    
        <section class="aui-chat" >
 
    <div class="send inv">
      <div class="aui-btn  aui-btn-block  L" id="fail">取消</div>
      <div class="aui-btn  aui-btn-block  R" id="me_sub">提交</div>
    </div>
   
  </section>
    
    
  </div>
  <section class="aui-chat" id="chat">
    <div class="send">
      <input type="hidden" value="" id="sendid" />
      <input type="text" name="msg" id="msg"  placeholder="请输入..." />
      <div class="aui-btn an aui-btn-block">发送</div>
    </div>
  </section>
</section>
<?php $is_active = array('is_active'=>5); $this->load->view('/api/inc/footer.php',$is_active); ?>
<script type="text/javascript" src="<?=base_url()?>static/api/script/api.js"></script>
<script type="text/javascript" src="<?=base_url()?>static/api/script/jquery.js"></script>
<script type="text/javascript" src="<?=base_url()?>static/api/script/aui-toast.js" ></script>
<script type="text/javascript">
var toast = new auiToast({})

$("#plus").click(function() {
    $(".aui-list-item-btn").hide();
    $("#mem_list").show();

    toast.loading({
        title: "加载中",
        duration: 2000
    })

    var url = "<?=base_url();?>index.php?d=api&c=userinfo&m=member_lists";
    $.post(url,{},
    function(res) {
        var res = jQuery.parseJSON(res);
        if (res.errcode < 0) {
            toast.fail({
                title: res.errmsg,
                duration: 2000
            });
        } else {
            toast.hide();
            var html = '';
            $("#plus").html('');
            $("#mag_list").html('');
            $("#msg_list").html('');
            $.each(res.data.list,
            function(index, el) {
                html += '<li class="aui-list-item aui-list-item-middle "><div class="aui-media-list-item-inner"><div class=" aui-col-xs-5 aui-list-item-left"><div class=" aui-col-xs-5"><img src="' + el['headerurl'] + '" class="aui-img-round aui-list-img-sm"></div><div class="aui-col-xs-6"><span class="aui-font-size-16">' + el['realname'] + '</span><span class="aui-font-size-14"><h5>' + el['role'] + '</h5></span></div></div><div class="aui-list-item-right aui-col-xs-7"><div class="aui-col-xs-7 aui-font-size-18">' + el['phone'] + '</div><input class="aui-checkbox aui-list-item-right" type="checkbox" value="' + el['id'] + '" name="member_ex"></div></div></li>';
            }) 
			$(".aui-list-item-btn").show();
             html += '<div class="C"></div><span class="note">您已邀请过' + res.data.ex_num + '人，剩下只能在邀请' + res.data.ex_surplus + '人</span>';
            $("#mem_list ul").html(html);

        }

    })
})

$("#me_sub").click(function() {

    var st = [];
    $('input[name="member_ex"]:checked').each(function() {
        st.push($(this).val())
    });
    var url = "<?=base_url();?>index.php?d=api&c=userinfo&m=invite_member_ex";

    var data = {
        ex_list: st
    };
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
                title: "提交成功",
                duration: 2000
            });
            location.reload();
        }

    })

})

$(".ubox").click(function() {
    $("#mag_list").hide();
    $("#msg_list").html('');
    $("#chat").show();
    var send_id = $(this).find(".id").val();
    var uid = $("#uid").val();
    var data = {
        sendid: send_id
    };
    var url = "<?=base_url();?>index.php?d=api&c=userinfo&m=messages";

    $.post(url, data,
    function(res) {
        var res = jQuery.parseJSON(res);
        if (res.errcode < 0) {
            toast.fail({
                title: res.errmsg,
                duration: 2000
            });
        } else {
            var html = '';
            $(".aui-title").html(res.data.username);
            $("#plus").html('');
            $("#sendid").val(send_id);
            var l = '';

            $.each(res.data.messages_list,
            function(index, el) {

                if (res.data.uid == el['send_id']) {
                    l = 'left';

                } else {
                    l = 'right';

                }
                html += '<div class="aui-chat-item aui-chat-' + l + '"><div class="aui-chat-media"> <img src="' + el['sendheaderurl'] + '" /> </div><div class="aui-chat-inner"><div class="aui-chat-name">' + el['sendrealname'] + ' <span class="aui-label">' + el['createtime'] + '</span></div><div class="aui-chat-content"><div class="aui-chat-arrow"></div>' + el['msg'] + '</div></div></div>';

            });
            $("#chat").prepend(html);

        }

    })

})

$(".an").click(function() {
    var msg = $("#msg").val();
    var sendid = $("#sendid").val();
    var url = "<?=base_url();?>index.php?d=api&c=userinfo&m=messages_send";
    var data = {
        msg: msg,
        sendid: sendid
    };
    $.post(url, data,
    function(res) {
        var res = jQuery.parseJSON(res);
        if (res.errcode < 0) {
            toast.fail({
                title: res.errmsg,
                duration: 2000
            });
        } else {
            $("#msg").html('');
            toast.success({
                title: "留言成功",
                duration: 2000
            });

        }

    })

})
 
</script>
</body>
</html>

<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="maximum-scale=1.0,minimum-scale=1.0,user-scalable=0,width=device-width,initial-scale=1.0">
<title>APP</title>
<link rel="stylesheet" type="text/css" href="<?=base_url()?>static/api/css/aui.css">
<link rel="stylesheet" type="text/css" href="<?=base_url()?>static/api/css/aui-slide.css" />
<link rel="stylesheet" type="text/css" href="<?=base_url()?>static/api/css/styles.css" />
<script type="text/javascript" src="<?=base_url()?>static/api/script/jquery.js"></script>
</head>

<body>
<section id="main"> </section>
<section id="main-info">
  <header class="aui-bar aui-bar-nav aui-bar-warning" id="aui-header"> <a class="aui-pull-left aui-btn abs" href="javascript:;window.history.go(-1)"> <span class="aui-iconfont aui-icon-left"></span> </a>
    <?=$_GET['proid']?'修改':'创建'?>
    <?php if($_GET['proid']){?>
    <a class="aui-pull-right aui-btn" href="javascript:;" onClick="delproject(<?=$projectinfo['id']?>,2)">删除</a>
    <?php } ?>
  </header>
  <section id="wrap" class="pro-det">
    <div class="page-main">
      <div class="from-main">
        <div class="list">
          <input type="hidden" value="<?=$proinfo['proid']?>" id="proid" />
          <span class="name">请选择您的项目</span>
          <?php if($_GET['proid']){?>
          <span class="choo">
          <?=$proinfo['header']?>
          &nbsp;></span>
          <?php }else{ ?>
          <div id="list" class="listbox"> </div>
          <span class="choo"> 点击选择&nbsp;></span>
          <?php } ?>
        </div>
        <div class="list"> <span class="name">创建复盘</span>
          <input type="text" class="inp" value="<?=$proinfo['title']?>" name="title" id="title" placeholder="请输入标题名" />
        </div>
        <div class="list"> <span class="name">复盘描述</span>
          <input type="text" class="inp" value="<?=$proinfo['intro']?>" name="intro" id="content" placeholder="请输入项目描述" />
        </div>
        <div class="list"> <span class="name">添加配图</span>
          <div class="pic-box">
            <div class="pic-box1">
              <div class="picbox"> <i class="aui-iconfont aui-icon-plus"></i> </div>
            </div>
            <div id="tupian1" style="position:absolute"></div>
            <form id="galleryForm" enctype="multipart/form-data"  >
              <input type="file"  name="userfile" id="pic" />
            </form>
          </div>
        </div>
        <div class="list"> <span class="name">最优秀回答获得分数</span>
          <input type="text" class="inp" value="<?=$proinfo['intro']?>" name="total" id="total" placeholder="请输入分数" />
        </div>
      </div>
    </div>
    <section class="aui-chat" id="chat">
      <div class="send">
        <div class="aui-btn an aui-btn-block" id="basics">提交</div>
      </div>
    </section>
  </section>
</section>
<script type="text/javascript" src="<?=base_url()?>static/api/script/api.js"></script> 
<script type="text/javascript" src="<?=base_url()?>static/api/script/aui-toast.js" ></script> 
<script type="text/javascript" src="<?=base_url()?>static/api/script/jquery.js"></script> 
<script type="text/javascript" src="<?=base_url()?>static/api/script/jquery.form.js"></script> 
<script type="text/javascript">

var toast = new auiToast({})

 

 $(".choo").click(function(){

   var url = "<?=base_url();?>index.php?d=api&&c=conquer&m=conquer_project";

   $("#list").show();

  $.post(url,{},function(res){

	    var res = jQuery.parseJSON(res);

		var html='';

		 $.each(res.data.list,

            function(index, el) {

				html += '<span data-id="'+el['id']+'">'+el['title']+'</span>'

				}); 

	 

	 $("#list").html(html);

     $("#list span").click(function(){

		 $("#list").hide();

	   var id =$(this).attr("data-id");

	   var name =$(this).html();

	   $("#proid").val(id);

	   $(".choo").html(name+'&nbsp;>');

    })

  

  });

 })

 $(".picbox").click(function(){

     $('#pic').click();

	 });

	 

  $(document).on("change", '#pic',

	 function() {

		  if ($("#pic").val() != '') {

            $("#galleryForm").ajaxForm({

                target: '#tupian1',

                url: '<?=base_url();?>index.php?d=api&&c=conquer&m=uploadimg',

                dataType: 'html',

                type: 'POST',

                success: function(data) {

				 

			     },

               

            }).submit();

		  }

	 

	 }

	 )

 $("#basics").click(function(){

	 var proid =$("#proid").val();

	 var title =$("#title").val();

	 var content =$("#content").val();

	 var typeid=1;

	 var total=$("#total").val();

	 var icon=$("#icon").val();

	 

	 var url = "<?=base_url();?>index.php?d=api&c=conquer&m=conquer_create";

     var data={'proid':proid,'title':title,'content':content,'typeid':typeid,'total':total,'icon':icon};

	 

	 

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

			       <?php if($_GET['cid']){?>

				    title:"项目修改成功",

				   <?php }else{ ?>

                    title:"项目创建成功",

					<?php } ?>

					

                    duration:2000

                });

			window.location.href="<?=base_url()?>index.php?d=api&c=conquer&type=2";

		 }

		 

		})

 

	 

	 

	 })

 

</script>
</body>
</html>

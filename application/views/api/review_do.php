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
    发起 
  
  </header>
  <section id="wrap" class="pro-det">
  
  
    <div class="page-main">
      <div class="from-main">
        <div class="list">
          <input type="hidden" value="<?=$company_id?>" id="company_id" />
          <input type="hidden" value="<?=$_GET['proid']?>" id="proid" />
  
          <span class="name">请选择评审项目</span>
          <?php if($_GET['proid']){?>
          <span class="choo">
          <?=$proinfo['title']?>
          </span>
          <?php }else{ ?>
          <div id="list"  class="listbox"> </div>
          <span class="choo" id="choo"> 点击选择&nbsp;></span>
          <?php } ?>
        </div>
        
     <div class="list" id="mod">
          <input type="hidden" value="<?=$proinfo['modid']?>" id="modid" />
          <span class="name">请选择评审模块</span>
          <?php if($_GET['modid']){?>
          <span class="choo">
          <?=$proinfo['m_name']?>
          &nbsp;></span>
          <?php }else{ ?>
          <div id="list_mod"  class="listbox"> </div>
          <span class="choo" id="choo_mod"> 点击选择&nbsp;></span>
          <?php } ?>
        </div>
        
       <div class="list"> <span class="name">复盘描述</span>
          <input type="text" class="inp" value="<?=$proinfo['intro']?>" name="intro" id="content" placeholder="请输入项目描述" />
        </div>
        
       <div class="list">
          <input type="hidden" value="<?=$proinfo['staff']?>" id="staff" />
          <span class="name">请选择参与人员</span>
          <?php if($_GET['proid']){?>
          <span class="choo" id="m_l">
          <?=$proinfo['name']?>
          &nbsp;></span>
          <?php }else{ ?>
          <span class="choo" id="m_l"> 点击选择&nbsp;></span>
          <?php } ?>
        </div>
       
      <div class="qlist"></div>
      
      
       <div class="list"> <span class="name">请选择评审截止时间</span>
          <input type="date" class="inp" value="<?=$proinfo['endtime']?>" name="endtime" id="endtime" placeholder="" />
        </div>
      
       </div>
       
    </div>
    <section class="aui-chat" id="chat">
      <div class="send">
        <div class="aui-btn an aui-btn-block" id="basics">提交</div>
      </div>
    </section>
    <div id="main"></div>
    
    
    
  </section>
  
  
  
  
</section>
<script type="text/javascript" src="<?=base_url()?>static/api/script/api.js"></script> 
<script type="text/javascript" src="<?=base_url()?>static/api/script/aui-toast.js" ></script> 
<script type="text/javascript" src="<?=base_url()?>static/api/script/jquery.js"></script> 
<script type="text/javascript" src="<?=base_url()?>static/api/script/jquery.form.js"></script> 
<script type="text/javascript">
var toast = new auiToast({})
 
 $("#choo").click(function(){
   var url = "<?=base_url();?>index.php?d=api&c=review&m=get_review_project";
   $("#list").show();
  $.post(url,{},function(res){
	    var res = jQuery.parseJSON(res);
		var html='';
		 $.each(res.data,
            function(index, el) {
				html += '<span data-id="'+el['id']+'" typeid="'+el['typeid']+'" >'+el['title']+'</span>'
				}); 
	 
	 $("#list").html(html);
     $("#list span").click(function(){
	   $("#list").hide();
	   var id =$(this).attr("data-id");
	   var typeid =$(this).attr("typeid");
 
	     if(typeid == 2){
		   $("#mod").hide();
		   }else{
			 $("#mod").show();   
		   }
	   var name =$(this).html();
	   $("#proid").val(id);
	   $("#choo").html(name+'&nbsp;>');
    })
  
  });
 })
 
 
 
 
$("#choo_mod").click(function() {
    var company_id = $("#company_id").val();
    var url = "<?=base_url();?>index.php?d=api&c=mod";
    $("#list_mod").show();
    $.post(url, {
        company_id: company_id
    },
    function(res) {
        var res = jQuery.parseJSON(res);
        var html = '';
        $.each(res.data,
        function(index, el) {
            html += '<span class="m_list" data-id="' + el['id'] + '">' + el['m_name'] + '</span>'
        });

        $("#list_mod").html(html);
        $("#list_mod span").click(function() {
            $("#list_mod").hide();
          
 
            var id = $(this).attr("data-id");
            var name = $(this).html();
            $("#modid").val(id);
            $("#choo_mod").html(name + '&nbsp;>');
            var urls = "<?=base_url();?>index.php?d=api&c=review&m=mod_review_question";
            var datas = {
              
                'modid': id
            };
           
           $.post(urls, datas,
            function(res) {
            var res = jQuery.parseJSON(res);
                if (res.errcode < 0) {
                    toast.fail({
                        title: res.errmsg,
                        duration: 2000
                    });
                } else {
					
					
				 var html = '';
        $.each(res.data,
        function(index, el) {
            html += '<div class="list"> <span class="name">评审题目</span><input type="text" class="inp" value="'+el['revtitle']+'" /></div><div class="list"><span class="name">评审描述</span><input type="text" class="inp" value="'+el['revintro']+'" /></div>'
        });	
				
				$(".qlist").html(html);  
       
 
 
                } 

            })

        })

    });
})
 
 
  $("#m_l").click(function(){
 $("#main-info").hide();
 $("#main").show();
  var url = "<?=base_url();?>index.php?d=api&c=review&m=review_member";
  $("#main").load(url+" #member_list ",function(res){
 
	$("#fail").click(function(){
	   $("#main-info").show();
       $("#main").hide(); 
	 })
	 $("#succ").click(function(){
		var arrs='';
		var names='';
	  $('input[name="member_ex"]:checked').each(function(){ 
            arrs += $(this).val()+',';
			names += $(this).parents("li").find(".aui-font-size-16").html()+',';
         }); 
	    names=names.substring(0,names.length-1);
		arrs=arrs.substring(0,arrs.length-1);
	   $("#main-info").show();
	   $("#main").hide();
	   $("#staff").val(arrs);
	   $("#m_l").html(names+'&nbsp;>');
		
		 })
	
	
  
  });
 }) 
 
 
 $("#basics").click(function(){
	 var proid =$("#proid").val();
	 var content =$("#content").val();
	 var modid =$("#modid").val();
	 var staff =$("#staff").val();
	 var endtime=$("#endtime").val();
	 
 
	 
	 var url = "<?=base_url();?>index.php?d=api&c=review&m=do_review";
     var data={'proid':proid,'intro':content,'modid':modid,'staff':staff,'endtime':endtime};
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
				    title:"评审修改成功",
				   <?php }else{ ?>
                    title:"评审创建成功",
					<?php } ?>
					
                    duration:2000
                });
			window.location.href="<?=base_url()?>index.php?d=api&c=review&types=2";
		 }
		 
		})
   })
   

   
 
</script>
</body>
</html>

<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="maximum-scale=1.0,minimum-scale=1.0,user-scalable=0,width=device-width,initial-scale=1.0">
<title>奋斗者</title>
<link rel="stylesheet" type="text/css" href="<?=base_url()?>static/api/css/aui.css">
<link rel="stylesheet" type="text/css" href="<?=base_url()?>static/api/css/aui-slide.css" />
<link rel="stylesheet" type="text/css" href="<?=base_url()?>static/api/css/styles.css" />
<style type="text/css">
#chat {
	display: none
}
</style>
</head>
<body>

<header class="aui-bar aui-bar-nav aui-bar-warning" id="aui-header">
 <a class="aui-btn aui-btn-warning aui-pull-left abs"  href="javascript:;" onClick="window.history.go(-1)" > 
 <i class="aui-iconfont aui-icon-left"></i></a>
  <div class="aui-title">分组</div>
 </header>
 <section id="main"></section>
<section id="member_lists">
<section id="wrap">
  <ul class="aui-list aui-list-in" id="group_list">
    <?php foreach($list as $k=>$v){  ?>
    <li class="aui-list-item">
     
      <div class="aui-list-item-inner aui-col-xs-8">
        <?=$v['title']?>
        （
        <?=$v['member_count']?>
        人）</div>
        <div class="aui-col-xs-4 aui-list-item-arrow">
        <div class="aui-btn an aui-btn-block aui-btn-sm add" ><input type="hidden" class="groupid" value="<?=$v['id']?>" />添加</div>
      </div>
    </li>
    <ul class="member_lists" style="display:none">
      <?php foreach($v['member_list'] as $k=> $val){?>
      <li style="float:left;height: 2.5rem;
    margin: 0.5rem 0 0 0; width:100%; border-bottom:1px solid #eee"> <a href="<?=base_url();?>index.php?d=api&c=userinfo&m=integral_list&id=<?=$val['mid']?>&typeid=1"><img style="margin-top:0" src="<?=$val['headerurl']?>" /> 
        <span class="name" style="width:20%; font-size:14px; line-height:1rem">
        <?=$val['realname']?><br>
         <?=$val['role']?>
        
        </span>  <span style="float:right; font-size:14px"><?=$val['mobile']?></span> </a></li>
      <?php } ?>
    </ul>
    <?php } ?>
  </ul>
  <div class="aui-btn an aui-btn-block aui-btn-sm aui-margin-t-15 addnew" >添加新分组</div>
  <div class="aui-list-item aui-content-padded " id="new">
    <div class="aui-list-item-inner">
    <div class="from-main">
        <div class="list"> <span class="name">创建新群组</span>
          <input type="text" class="inp" value="<?=$proinfo['title']?>" name="title" id="title" placeholder="请输入群组名" />
        </div>
   
      <div class="send">
        <div class="aui-btn an aui-btn-block qx" id="qx">取消</div>
        <div class="aui-btn an aui-btn-block LE" id="wc">完成</div>
      </div>
    </div>
  </div>
</section>
</section>
<script type="text/javascript" src="<?=base_url()?>static/api/script/api.js"></script> 
<script type="text/javascript" src="<?=base_url()?>static/api/script/jquery.js"></script> 
<script type="text/javascript" src="<?=base_url()?>static/api/script/aui-toast.js" ></script> 
<script type="text/javascript">
var toast = new auiToast({})
 
$(".addnew").click(function(){ 
$(".aui-title").html("添加新分组");
$("#group_list").hide();
$("#new").show();
$(".aui-pull-left").addClass("qx");
$("#")
})

$(".qx").click(function(){
$(".aui-title").html("分组");
$("#new").hide();	
$("#group_list").show();
$(".aui-pull-left").removeClass("qx");
 })
 
$("#wc").click(function(){
  var title =$("#title").val();
  var url="<?=base_url();?>index.php?d=api&c=userinfo&m=create_group"; 
  var data = {title:title};

  $.post(url,
        data,
		function(res){
			var res = jQuery.parseJSON(res);  
		if(res.errcode< 0){
			 toast.fail({
             title:res.errmsg,
             duration:2000
             });
			}else{
			 toast.success({
                    title:"创建成功",
                    duration:2000
                });
			 location.reload(); 
			
			}
			})

})
$(".add").click(function(){
	var groupid =$(this).find(".groupid").val();
 
 $("#member_lists").hide();
 $("#main").show();
  var url = "<?=base_url();?>index.php?d=api&c=userinfo&m=group_addmember1";
  var data={groupid:groupid};
  $("#main").load(url+" #member_list ",data,function(res){
 
  $("#succ").click(function(){
		  var a =  new Array();
		  $('input[name="member_ex"]:checked').each(function(i){ 
            a[i]=$(this).val();
          }); 
        
   var url = "<?=base_url();?>index.php?d=api&c=userinfo&m=group_member_add";
   var data={groupid:groupid,member_list:a};
      
     $.post(url,
        data,
		function(res){
			var res = jQuery.parseJSON(res);  
		if(res.errcode< 0){
			 toast.fail({
             title:res.errmsg,
             duration:2000
             });
			}else{
			 toast.success({
                    title:"会员添加成功",
                    duration:2000
                });
			 location.reload(); 
			
			}
			})
		
		 })
	
 $("#fail").click(function(){ 
 location.reload(); 
 })
	
  
  });
 
	
	
	
	})
$(".aui-list-item").click(function(){
 
$(this).next().toggle();

})	   
</script>
</body>
</html>

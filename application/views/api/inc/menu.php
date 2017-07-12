<?php  
 $member = $this->session->userdata('member') ;
?>

<div class="menu">
  <?php if($member){?>
  <div class="menutop">
    <div class="pic"><img src="<?=$member['headerurl']?>" /></div>
    <div class="name">
      <?=$member['realname']?>
      <br>
      部门：
      <?=$member['dep_name']?>
    </div>
  </div>
  <?php } ?>
  <ul class="aui-list aui-list-in">
    <li class="aui-list-item">
      <div class="aui-list-item-label-icon"> <i class="aui-iconfont aui-icon-my"></i> </div>
      <div class="aui-list-item-inner"> <a style="color:#fff" href="<?=base_url();?>index.php?d=api&c=userinfo&m=user">个人信息</a> </div>
    </li>
    <li class="aui-list-item">
      <div class="aui-list-item-label-icon"> <i class="aui-iconfont aui-icon-lock"></i> </div>
      <div class="aui-list-item-inner"> <a style="color:#fff" href="<?=base_url();?>index.php?d=api&c=userinfo&m=changepwd">修改密码</a> </div>
    </li>
    <li class="aui-list-item">
      <div class="aui-list-item-label-icon"> <i class="aui-iconfont aui-icon-share"></i> </div>
      <div class="aui-list-item-inner"> 分享好友 </div>
    </li>
    <li class="aui-list-item">
      <div class="aui-list-item-label-icon"> <i class="aui-iconfont aui-icon-info"></i> </div>
      <div class="aui-list-item-inner"> <a style="color:#fff" href="<?=base_url();?>index.php?d=api&c=aboutsys">系统说明</a> </div>
    </li>
    <li class="aui-list-item">
      <div class="aui-list-item-label-icon"> <i class="aui-iconfont aui-icon-comment"></i> </div>
      <div class="aui-list-item-inner"> <a style="color:#fff" href="<?=base_url();?>index.php?d=api&c=feedback"> 意见反馈</a> </div>
    </li>
    <li class="aui-list-item">
      <div class="aui-list-item-label-icon"> <i class="aui-iconfont aui-icon-cert"></i> </div>
      <div class="aui-list-item-inner"> <a style="color:#fff" href="<?=base_url();?>index.php?d=api&c=aboutus"> 关于我们</a> </div>
    </li>
  </ul>
  <a href="<?=base_url();?>index.php?d=api&c=login&m=oulogin"><div class="an">退出</div></a>
</div>
<div class="mc2"></div>


<!-- JiaThis Button BEGIN -->
<div class="share">
<!-- JiaThis Button BEGIN -->

<div class="jiathis_style_32x32">
<a class="jiathis_button_qzone"></a>
<a class="jiathis_button_tsina"></a>
<a class="jiathis_button_tqq"></a>
<a class="jiathis_button_renren"></a>
<a class="jiathis_button_kaixin001"></a>
<a class="jiathis_button_weixin"></a>
<a class="jiathis_button_cqq"></a>
<a class="jiathis_button_email"></a>
 
 
</div>
<script type="text/javascript" >
var jiathis_config={
	summary:"",
	shortUrl:false,
	hideMore:false
}
</script>
<script type="text/javascript" src="http://v3.jiathis.com/code/jia.js" charset="utf-8"></script>
<!-- JiaThis Button END -->

</div>
<!-- JiaThis Button END -->

<script type="text/javascript">
  $("#menu").click(function(){
       $(".mc2").show();
	  $(".menu").show();
  })
 $(".mc2").click(function(){
	 $(".menu").hide();
	  $(".mc2").hide();
	 }) 
$(".aui-icon-share").click(function(){
	$(".share").toggle();
	
	})	 
</script>
 
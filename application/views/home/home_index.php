<!DOCTYPE HTML>
<html>
 <head>
  <title>后台管理</title>
   <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <link href="<?=base_url()?>static/assets/css/dpl-min.css" rel="stylesheet" type="text/css" />
  <link href="<?=base_url()?>static/assets/css/bui-min.css" rel="stylesheet" type="text/css" />
   <link href="<?=base_url()?>static/assets/css/main-min.css" rel="stylesheet" type="text/css" />
 </head>
 <body>

  <div class="header">
    
      <div class="dl-title">
       <!--<img src="/chinapost/Public/assets/img/top.png">-->
      </div>

    <div class="dl-log">欢迎您，<span class="dl-log-user"><?=$userinfo['username']?></span><a href="<?=base_url()?>index.php?d=home&c=login&m=logout" title="退出系统" class="dl-log-quit">[退出]</a>
    </div>
  </div>
   <div class="content">
    <div class="dl-main-nav">
      <div class="dl-inform"><div class="dl-inform-title"><s class="dl-inform-icon dl-up"></s></div></div>
      <ul id="J_Nav"  class="nav-list ks-clear">
       <li class="nav-item dl-selected"><div class="nav-item-inner nav-home">系統管理</div></li>		<!--<li class="nav-item dl-selected"><div class="nav-item-inner nav-order">业务管理</div></li>-->       

      </ul>
    </div>
    <ul id="J_NavContent" class="dl-tab-conten">

    </ul>
   </div>
  <script type="text/javascript" src="<?=base_url()?>static/assets/js/jquery-1.8.1.min.js"></script>
  <script type="text/javascript" src="<?=base_url()?>static/assets/js/bui-min.js"></script>
  <script type="text/javascript" src="<?=base_url()?>static/assets/js/common/main-min.js"></script>
  <script type="text/javascript" src="<?=base_url()?>static/assets/js/config-min.js"></script>
  <script>
    BUI.use('common/main',function(){
      var config = [
	  //{id:'1',
//	  	menu:
//			[
//				{text:'会员管理',
//					items:[
//							{id:'1',text:'员工列表',href:'index.php?d=home&c=member&roleid=1'},
//							{id:'2',text:'专家列表',href:'index.php?d=home&c=member&roleid=2'},
//							{id:'3',text:'领导列表',href:'index.php?d=home&c=member&roleid=3'},
//							{id:'3',text:'部门管理',href:'index.php?d=home&c=department'},
//						]
//					
//					},
//
//				{text:'项目池',
//					items:[
//							{id:'19',text:'公式设置',href:'index.php?d=home&c=gongshi'},
//							{id:'20',text:'重大项目',href:'index.php?d=home&c=project&typeid=1'},
//							{id:'21',text:'基础项目',href:'index.php?d=home&c=project&typeid=2'},
//							{id:'22',text:'模块列表',href:'index.php?d=home&c=mod'},
//							{id:'24',text:'任务类型',href:'index.php?d=home&c=tasktype'},
//							{id:'40',text:'任务列表',href:'index.php?d=home&c=task'},
//							{id:'23',text:'问题箱',href:'index.php?d=home&c=question'},
//						]
//					
//					},
//
//				{text:'复盘',
//					items:[
//							
//							{id:'41',text:'复盘类型',href:'index.php?d=home&c=replay_type'},
//							{id:'42',text:'复盘列表',href:'index.php?d=home&c=conquer'},
//						]
//					
//					},
//
//				{text:'系统相关',
//					items:[
//							{id:'61',text:'系统说明',href:'index.php?d=home&c=aboutsys'},
//							{id:'62',text:'意见反馈',href:'index.php?d=home&c=feedback'},
//							{id:'63',text:'关于我们',href:'index.php?d=home&c=aboutus'},
//							{id:'64',text:'图片库',href:'index.php?d=home&c=pics'},
//							{id:'65',text:'轮播图',href:'index.php?d=home&c=advs'},
//						]
//					
//					},
//
//				{text:'系统',
//					items:[
//							{id:'80',text:'密碼修改',href:'index.php?d=home&c=password'},
//							{id:'81',text:'备份数据库',href:'index.php?d=home&c=backupdb'},
//							
//						]
//					
//					},
//				{text:'管理员',
//					items:[
//							{id:'90',text:'管理员',href:'index.php?d=home&c=user'},
//							{id:'91',text:'角色管理',href:'index.php?d=home&c=user_role'},
//						]
//					
//					},
//			]
//					
//		},	
		<?=$munelist?>		
	];
					
      new PageUtil.MainPage({
        modulesConfig : config
      });
    });
  </script>
  
  <ul class="popup">
  <li <?php if($membernum == 1){ ?> <?php }else{?>style="display:none"<?php }?> >您的会员数量已满，请联系管理员增加。</li>
  <li <?php if($userdatestatus == 1){ ?> <?php }else{?>style="display:none"<?php }?> >您的项目将于<?=$end_time?>到期，请尽快续费。</li>
</ul>
<script>
setTimeout(function(){
	$('.popup').fadeOut();
}, 5000);
$('.popup li').on('click', function(){
	$(this).fadeOut();
});
</script>
 </body>
</html>
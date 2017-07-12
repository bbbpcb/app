<?php Widget::head();?>
<script>
function flush(msg,url){
  art.dialog(
    msg, 
    function () {
      
      window.location = url;
    },
    function(){
      
    }
  );
}



</script>
<body>
<nav class="navbar navbar-default" role="navigation">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav" style="display:none;">
        <a href="<?=base_url()?>index.php?d=home&c=aboutsys&m=add"><li class="active"><button type="button" class="btn btn-default navbar-btn">添加</button></li></a>

      </ul>


    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>
<ol class="breadcrumb">
  <li>任务领取</li>
  
</ol>

<form name="form2" method="post" action="<?=base_url()?>index.php?d=home&c=aboutsys&m=rank">
<table class="table table-bordered table-hover definewidth m10">
    <thead>
    <tr>

        <th>ID</th>      
    
        <th>领取人姓名</th>
         <th>角色</th>
        <th>管理操作</th>
    </tr>
    </thead>
	<?php
		foreach($list as $k => $v){
	?>
    <tr>
	 	<td><?=$v['id']?></td>   
  
		<td><?=$v['realname']?></td>   
    <td><? if($v['roleid']==1){?>独立<? }else if($v['roleid']==2){?>核心<? }else{ ?>参与<? }?></td>    
    <td width="113" valign="middle">
      <a style="display:none" href="<?=base_url()?>index.php?d=home&c=execution&id=<?=$v['id']?>&taskid=<?=$v['taskid']?>&mid=<?=$v['mid']?>">完成情况</a> |
          
    <a href="javascript:void(0);" onClick="flush('删除后不能恢复，确定删除吗?','<?=base_url()?>index.php?d=home&c=member_task&m=del&id=<?=$v['id']?>');">删除</a> 
    </td>
    </tr>
	<?php
		}
	?>
    <tr>
      
	 	<td colspan="4"><?=$page?></td>   
    </tr>
	</table>
</form>
</body>
</html>

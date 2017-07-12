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
<ol class="breadcrumb">
  <li><a href="<?=base_url()?>index.php?d=home&c=member">专家列表</a></li>
  <li>相关员工</li>
</ol>


<table class="table table-bordered table-hover definewidth m10">
    <thead>
    <tr>

        <th>ID</th>
        <th >员工姓名</th>
         <th >头像</th>
        <th>手机号</th>
        <th>注册时间</th>
        <th>管理操作</th>
    </tr>
    </thead>

	<?php
		foreach($list as $k => $v){
	?>
    <tr>
        <td valign="middle"><?=$v['id']?></td>
       
        <td valign="middle"><?=$v['realname']?></td>
         <td valign="middle"><img src="<?=base_url()?>uploads/member/header/<?=$v['headerurl']?>" width="40xp" height="40px"/></td>
        <td valign="middle"><?=$v['mobile']?></td>
  
		 <td><?=date("Y-m-d H:i:s",$v['extime'])?></td>
        <td>
		
         <a href="javascript:void(0);" onClick="flush('删除后不能恢复，确定删除吗?','<?=base_url()?>index.php?d=home&c=expert&m=del_ex&id=<?=$v['id']?>&exid=<?=$v['exid']?>');">删除</a> 
		</td>
    </tr>

	<?php
	}
	?>
	<tr>
        <td colspan="7"></td>
    </tr>
</table>

</body>
</html>

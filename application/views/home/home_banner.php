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

<form class="form-inline definewidth m20" >
    <a href="<?=base_url()?>index.php?d=home&c=banner&m=add"><button type="button" class="btn btn-success" id="addnew">添加</button></a>  
	<!-- <a href="<?=base_url()?>index.php?d=home&c=banner&m=html"><button type="button" class="btn btn-success" id="addnew">首页静态化</button></a>-->

</form>

<table class="table table-bordered table-hover definewidth m10">
    <thead>
    <tr>

        <th>ID</th>
       
        <th>图片</th>
		<th>URL</th>
		 <th>排序</th>
        <th>创建时间</th>
       
        <th>管理操作</th>
    </tr>
    </thead>

	<?php
		foreach($list as $k => $v){
	?>
    <tr>
        <td valign="middle"><?=$v['id']?></td>
        <td><img src="<?=base_url();?>uploads/banner/<?=$v['pic']?>" width="40px" height="40px"/></td>
		 <td><?=$v['url']?></td>
		 <td valign="middle"><input type="text" name="rank[]" value="<?=$v['rank']?>" /></td>
        <td valign="middle"><?=date('Y-m-d',$v['createtime'])?></td>

        <td><a href="<?=base_url()?>index.php?d=home&c=banner&m=del&id=<?=$v['id']?>">删除</a></td>
    </tr>

	<?php
	}
	?>
	<tr>
        <td colspan="7"><?=$page?></td>
    </tr>
</table>

</body>
</html>

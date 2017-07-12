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
      <ul class="nav navbar-nav">
        <a href="<?=base_url()?>index.php?d=home&c=user_role&m=add"><li class="active"><button type="button" class="btn btn-default navbar-btn">添加</button></li></a>

      </ul>
      <form class="navbar-form navbar-left" role="search" method="post"  action="<?=base_url()?>index.php?d=home&c=user_role&m=index">
        <div class="form-group">
          <input type="text" class="form-control" placeholder="Search" id="keyword" name="keyword" value="<?=$keyword ?>">
        </div>
        <button type="submit" class="btn btn-default">Submit</button>
      </form>

    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>


<table class="table table-bordered table-hover definewidth m10">
    <thead>
    <tr>

        <th>ID</th>
      <th >名称</th>
	   <th >分配权限</th>
        <th>管理操作</th>
    </tr>
    </thead>

	<?php
		foreach($list as $k => $v){
	?>
    <tr>
        <td valign="middle"><?=$v['rid']?></td>
       
        <td valign="middle"><?=$v['name']?></td>
		<td valign="middle"><?php if($v['rid'] != 1){ ?> <a href="<?=base_url()?>index.php?d=home&c=user_role&m=roleright&id=<?=$v['rid']?>">分配权限</a><? }?></td>
        <td>
      
		<a href="<?=base_url()?>index.php?d=home&c=user_role&m=update&id=<?=$v['rid']?>">编辑</a>  <?php if($v['rid'] != 1){ ?> | 
		<a href="javascript:void(0);" onClick="flush('删除后不可恢复，确定删除吗','<?=base_url()?>index.php?d=home&c=user_role&m=del&id=<?=$v['rid']?>');">删除</a> <?php } ?>
		</td>
    </tr>

	<?php
	}
	?>
	<tr>
        <td colspan="9"><?=$page?></td>
    </tr>
</table>

</body>
</html>

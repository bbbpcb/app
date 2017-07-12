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
        <a href="<?=base_url()?>index.php?d=home&c=expert&m=add"><li class="active"><button type="button" class="btn btn-default navbar-btn">添加专家</button></li></a>

      </ul>
      <form class="navbar-form navbar-left" role="search">
        <div class="form-group">
          <input type="text" class="form-control" placeholder="Search">
        </div>
        <button type="button" class="btn btn-default">Submit</button>
      </form>

    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>
<ol class="breadcrumb">
  <li>专家列表</li>
  
</ol>


<table class="table table-bordered table-hover definewidth m10">
    <thead>
    <tr>

        <th>ID</th>
        <th >用户名</th>
		 <th>部门</th>
		 <th>真实姓名</th>
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
       
        <td valign="middle"><?=$v['username']?></td>
        <td valign="middle"><?=$v['dep_name']?></td>
        <td valign="middle"><?=$v['realname']?></td>
        <td><?=$v['mobile']?></td>
		 <td><?=date("Y-m-d H:i:s",$v['createtime'])?></td>
        <td>
      <a href="<?=base_url()?>index.php?d=home&c=expert&m=mem&id=<?=$v['id']?>">关联员工</a> | 
		<a href="<?=base_url()?>index.php?d=home&c=expert&m=update&id=<?=$v['id']?>">编辑</a> | 

    <a href="javascript:void(0);" onclick="flush('删除后不能恢复，确定删除吗?','<?=base_url()?>index.php?d=home&c=expert&m=del&id=<?=$v['id']?>')">删除</a>
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

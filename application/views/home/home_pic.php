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
        <a href="<?=base_url()?>index.php?d=home&c=pics&m=add"><li class="active"><button type="button" class="btn btn-default navbar-btn">添加</button></li></a>

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


<table class="table table-bordered table-hover definewidth m10">
    <thead>
    <tr>

        <th>ID</th>
        <th >图片</th>
		    <th>所属类别</th>
		    <th>难度</th>
			 <th>规模</th>
        <th>管理操作</th>
    </tr>
    </thead>

	<?php
		foreach($list as $k => $v){
	?>
    <tr>
        <td valign="middle"><?=$v['id']?></td>      
        <td valign="middle"><img src="<?=base_url()?>uploads/pics/<?=$v['picname']?>" /></td>
        <td valign="middle"><?=$v['typeid']?></td>
        <td valign="middle"><?=$v['nandu']?></td>     
		<td valign="middle"><?=$v['guimo']?></td>      
        <td>    
    		<a href="<?=base_url()?>index.php?d=home&c=pics&m=update&id=<?=$v['id']?>">编辑</a> | 
    		<a href="<?=base_url()?>index.php?d=home&c=pics&m=del&id=<?=$v['id']?>">删除</a> |       
    	</td>
    </tr>

	<?php
	}
	?>
	<tr>
        <td colspan="11"><?=$page?></td>
    </tr>
</table>

</body>
</html>

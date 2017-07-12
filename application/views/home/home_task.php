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
<script language="javascript" type="text/javascript">
	function selectAll(obj) {
            var allInput = document.getElementsByTagName("input");
            var loopTime = allInput.length;
            for (i = 0; i < loopTime; i++) {
                if (allInput[i].type == "checkbox") {
                    allInput[i].checked = obj.checked;
                }
            }
        }
	function judgeSelect() {
		var result = false;
		var ids="";
		var allInput = document.getElementsByName("cheid");
		for (i = 0; i < allInput.length; i++) {
			if (allInput[i].checked) {
				if(ids==""){
					ids=allInput[i].value;
				}else{
					ids=ids+ "-"+allInput[i].value ;
				}
				result = true;
			}
		}
		if (!result) {
			alert("提示：请先选择要删除的记录！");
			return result;
		}else{
			if(confirm("提示：确认要删除选定的记录吗？")){
				$.ajax({
					type : "POST",
					url : "<?=base_url()?>index.php?d=home&c=task&m=delall",
					data : {ids:ids},
					cache:false,
					success : function(data){
						alert("删除成功");
						location.href = "<?=base_url()?>index.php?d=home&c=task&page=<?=$pagesize ?>";
					}
				});
			}
		}
	}
</script>
<body>
<nav class="navbar navbar-default" role="navigation">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <a href="<?=base_url()?>index.php?d=home&c=task&m=add&pid=<?=$pid?>&mid=<?=$mid?>"><li class="active"><button type="button" class="btn btn-default navbar-btn">添加</button></li></a>

      </ul>
       <form class="navbar-form navbar-left" role="search" method="post"  action="<?=base_url()?>index.php?d=home&c=task&m=index">
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
			<th>选择</th>
        <th>ID</th>
        <th >任务名称</th>
		 <th>所属项目</th>
		 <th>所属模块</th>
        <th>任务参数</th>
        <th>状态</th>
        <th>管理操作</th>
    </tr>
    </thead>

	<?php
		foreach($list as $k => $v){
	?>
    <tr>
		<td width="50"><label class="check" for="<?=$v['id']?>"><input class="" name="cheid" id="<?=$v['id']?>"  value="<?=$v['id']?>" type="checkbox"></label></td>
        <td valign="middle"><?=$v['id']?></td>
       
        <td valign="middle"><?=$v['title']?></td>
        <td valign="middle"><?=$v['ptitle']?></td>
        <td valign="middle"><?=$v['m_name']?></td>
        <td valign="middle">
          规模:<?=$v['scale']?> 难度:<?=$v['difficulty']?><br/>
          质量:<?=$v['quality']?> 特性:<?=$v['features']?>
        </td>
        <td valign="middle"><?=$v['status']?></td>
       
    <td>
  
		<a href="<?=base_url()?>index.php?d=home&c=task&m=update&id=<?=$v['id']?>">编辑</a> | 
		<a href="<?=base_url()?>index.php?d=home&c=task&m=del&id=<?=$v['id']?>">删除</a> |
    <a href="<?=base_url()?>index.php?d=home&c=member_task&taskid=<?=$v['id']?>&type_id=<?=$v['typeid']?>&proid=<?=$v['proid'] ?>&modid=<?=$v['modid'] ?>&tab=home">领取人员</a>
		</td>
    </tr>

	<?php
	}
	?>
	<tr>
        <td colspan="8"><div class="btn_check pt10" style="float:left"><input  onClick="selectAll(this)"  id="che" name="che" type="checkbox">全选/取消&nbsp;&nbsp;<a href="javascript:;" onClick="return judgeSelect();" class="btn_del">删除所选</a></div><div class="btn_check pt10" style="float:right"><?=$page?></div></td>
    </tr>
</table>

</body>
</html>

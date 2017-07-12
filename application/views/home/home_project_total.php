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
					url : "<?=base_url()?>index.php?d=home&c=projecttotal&m=delall",
					data : {ids:ids},
					cache:false,
					success : function(data){
						alert("删除成功");
						location.href = "<?=base_url()?>index.php?d=home&c=projecttotal&page=<?=$pagesize ?>";
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
      <form class="navbar-form navbar-left" role="search" method="post"  action="<?=base_url()?>index.php?d=home&c=projecttotal&m=index">
        <div class="form-group">
          <input type="text" class="form-control" placeholder="Search" id="keyword" name="keyword" value="<?=$keyword ?>">
		  <input type="hidden" class="form-control" id="typeid" name="typeid" value="<?=$typeid ?>">
        </div>
        <button type="submit" class="btn btn-default">Submit</button>
		<a href="javascript:;" id="abtn_export_excel" class="btn btn-default">打印输出</a>
      </form>

    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>

<!--
<form class="form-inline definewidth m20" >
    <a href="<?=base_url()?>index.php?d=home&c=project&m=add"><button type="button" class="btn btn-success" id="addnew">添加</button></a>

</form>
-->

<table class="table table-bordered table-hover definewidth m10">
    <thead>
    <tr>
		<th>ID</th>
		<th >项目名称</th>
		<th>负责人</th>
		<th>负责人类型</th>
		<th>模块名称</th>
		<th>任务名称</th>
		<th>规模<span style="color:#FF0000">(前)</span></th>
		<th>难度<span style="color:#FF0000">(前)</span></th>
		<th>质量<span style="color:#FF0000">(前)</span></th>
		<th>特性<span style="color:#FF0000">(前)</span></th>
		<th>任务分数<span style="color:#FF0000">(前)</span></th>
		<th>领取人姓名<span style="color:#FF0000">(前)</span></th>
		<th>领取分<span style="color:#FF0000">(前)</span>数</th>
		<th>规模<span style="color:#FF0000">(后)</span></th>
		<th>难度<span style="color:#FF0000">(后)</span></th>
		<th>质量<span style="color:#FF0000">(后)</span></th>
		<th>特性<span style="color:#FF0000">(后)</span></th>
		<th>任务分数<span style="color:#FF0000">(后)</span></th>
		<th>领取人姓名<span style="color:#FF0000">(后)</span></th>
		<th>领取人分数<span style="color:#FF0000">(后)</span></th>
        <th>管理操作</th>
    </tr>
    </thead>

	<?php
		foreach($list as $k => $v){
	?>
    <tr>
		<td width="50"><label class="check" for="<?=$v['id']?>"><input class="" name="cheid" id="<?=$v['id']?>"  value="<?=$v['id']?>" type="checkbox"></label></td>
        <td valign="middle"><?=$v['proname']?></td>
        <td valign="middle"><?=$v['realname']?></td>
		<td valign="middle"><?=$v['rolename']?></td>
        <td valign="middle"><?=$v['modtitle']?> </td>
		<td><?=$v['taskname']?></td>
		<td><?=$v['scale']?></td>
		<td><?=$v['difficulty']?></td>
		<td><?=$v['quality']?></td>
		<td><?=$v['features']?></td>
		<td><?=$v['taskgrand']?></td>
		<td><?=$v['lingname']?></td>
		<td><?=$v['linggrand']?></td>
		<td><?=$v['gscale']?></td>
		<td><?=$v['gdifficulty']?></td>
		<td><?=$v['gquality']?></td>
		<td><?=$v['gfeatures']?></td>
		<td><?=$v['gtaskgrand']?></td>
		<td><?=$v['glingname']?></td>
		<td><?=$v['glinggrand']?></td>
        <td>
    <a href="javascript:void(0);" onClick="flush('删除后不能恢复，确定删除吗?','<?=base_url()?>index.php?d=home&c=projecttotal&m=del&id=<?=$v['id']?>');">删除</a>
		</td>
    </tr>
	<?php
	}
	?>
	<tr>
        <td colspan="21"><div class="btn_check pt10" style="float:left"><input  onClick="selectAll(this)"  id="che" name="che" type="checkbox">全选/取消&nbsp;&nbsp;<a href="javascript:;" onClick="return judgeSelect();" class="btn_del">删除所选</a></div><div class="btn_check pt10" style="float:right"><?=$page?></div></td>
    </tr>
</table>

</body>
</html>
 <script type="text/javascript">
$(document).ready(function(){
  /*导出*/
  $("#abtn_export_excel").click(function(){
      var url = "<?=base_url()?>index.php?d=home&c=projecttotal&m=daochu";
	//location.href = url; 
	jQuery.ajax({
		 type:'post',
		 url: url,
		 data:{},
		 dataType:'json',
		 cache:false,
		 async:false,
		 success:function(res){
		 	if (res.success <= 0) {
		 		layer.alert(res.msg, 3, !1);
		 		return;
		 	}
		 },
		 error:function(){
		 	location.href = url + "&ty=1";
		 }
	 });

  })
})
 </script>
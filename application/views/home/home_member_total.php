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
					url : "<?=base_url()?>index.php?d=home&c=member&m=delall",
					data : {ids:ids},
					cache:false,
					success : function(data){
						alert("删除成功");
						location.href = "<?=base_url()?>index.php?d=home&c=member&roleid=<?=$roleid ?>&page=<?=$pagesize ?>";
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

      </ul>
      <form class="navbar-form navbar-left" role="search"  method="post"  action="<?=base_url()?>index.php?d=home&c=membertotal&m=index">
        <div class="form-group">
          <input type="text" class="form-control" placeholder="Search" id="keyword" name="keyword" value="<?=$keyword ?>">
		  <input type="hidden" class="form-control" id="roleid" name="roleid" value="<?=$roleid ?>">
		  <select name="depid">
		 	<option value="0">==选择部门==</option>
		  <?php
			foreach($dep as $dk => $dv){
		  ?>
			<option value="<?=$dv['id']?>" <?php if($depid == $dv['id']){ ?> selected <?php } ?>><?=$dv['dep_name']?></option>
			<?php
		  }
			?>
		 </select>
		  <select name="zhiwei">
		 	<option value="0">==选择职位==</option>
			  <?php
				foreach($jobs as $dk => $dv){
			  ?>
				<option value="<?=$dv['id']?>" <?php if($zhiweiid == $dv['id']){ ?> selected <?php } ?>><?=$dv['dep_name']?></option>
				<?php
			  }
				?>
		 </select>
		  <select name="type">
		 	<option value="0">==选择类型==</option>
				<option value="1" <?php if($type_id == 1){ ?> selected <?php } ?>>重大项目</option>
				<option value="2"  <?php if($type_id == 2){ ?> selected <?php } ?>>基础项目</option>
		 </select>
        </div>
        <button type="submit" class="btn btn-default">Submit</button>
      </form>

    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>
<ol class="breadcrumb">
  <li>统计管理</li>
  
</ol>

<table class="table table-bordered table-hover definewidth m10">
    <thead>
    <tr>
         <th>真实姓名</th>
		 <th>部门</th>
		  <th>职位</th>
        <th>手机号</th>
        <th>难度一星</th>
		<th>难度二星</th>
		<th>难度三星</th>
		<th>难度四星</th>
		<th>难度五星</th>
    </tr>
    </thead>

	<?php
		foreach($list as $k => $v){
	?>
    <tr>
         <td valign="middle"><?=$v['realname']?></td>
        <td valign="middle"><?=$v['dep_name']?></td>
  		 <td valign="middle"><?=$v['jobs_name']?></td>
        <td><?=$v['mobile']?></td>
		 <td><?=$v['star1']?></td>
		 <td><?=$v['star2']?></td>
		 <td><?=$v['star3']?></td>
		 <td><?=$v['star4']?></td>
		 <td><?=$v['star5']?></td>
        
    </tr>

	<?php
	}
	?>
	<tr>
        <td colspan="9"><div class="btn_check pt10" style="float:right"><?=$page?></div></td>
    </tr>
</table>


</body>
</html>

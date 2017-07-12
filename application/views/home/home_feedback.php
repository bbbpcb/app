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
					url : "<?=base_url()?>index.php?d=home&c=feedback&m=delall",
					data : {ids:ids},
					cache:false,
					success : function(data){
						alert("删除成功");
						location.href = "<?=base_url()?>index.php?d=home&c=feedback&page=<?=$pagesize ?>";
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


    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>
<ol class="breadcrumb">
  <li>意见反馈</li>
  
</ol>

<form name="form2" method="post" action="<?=base_url()?>index.php?d=home&c=aboutsys&m=rank">
<table class="table table-bordered table-hover definewidth m10">
    <thead>
    <tr>
		<th>选择</th>
        <th>ID</th>      
        <th>用户</th>
        <th>内容</th>
        
        <th>管理操作</th>
    </tr>
    </thead>
	<?php
		foreach($list as $k => $v){
	?>
    <tr>
		<td width="50"><label class="check" for="<?=$v['id']?>"><input class="" name="cheid" id="<?=$v['id']?>"  value="<?=$v['id']?>" type="checkbox"></label></td>
	 	<td><?=$v['id']?></td>   
    <td><?=$v['realname']?></td>      
		<td><?=$v['content']?></td>    
              
        <td width="113" valign="middle"><a href="<?=base_url()?>index.php?d=home&c=feedback&m=update&id=<?=$v['id']?>">编辑</a> |
          
            <a href="javascript:void(0);" onClick="flush('删除后不能恢复，确定删除吗?','<?=base_url()?>index.php?d=home&c=feedback&m=del&id=<?=$v['id']?>');">删除</a> 
          </td>
    </tr>
	<?php
		}
	?>
       <tr>
        <td colspan="8"><div class="btn_check pt10" style="float:left"><input  onClick="selectAll(this)"  id="che" name="che" type="checkbox">全选/取消&nbsp;&nbsp;<a href="javascript:;" onClick="return judgeSelect();" class="btn_del">删除所选</a></div><div class="btn_check pt10" style="float:right"><?=$page?></div></td>
    </tr>
	</table>
</form>
</body>
</html>

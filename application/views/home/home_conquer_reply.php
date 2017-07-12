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
					url : "<?=base_url()?>index.php?d=home&c=Conquer&m=replydelall",
					data : {ids:ids},
					cache:false,
					success : function(data){
						alert("删除成功");
						location.href = "<?=base_url()?>index.php?d=home&c=Conquer&page=<?=$pagesize ?>";
					}
				});
			}
		}
	}
</script>
<body>

<form class="form-inline definewidth m20" >
   <!-- <a href="<?=base_url()?>index.php?d=home&c=project&m=add"><button type="button" class="btn btn-success" id="addnew">添加</button></a>-->

</form>

<table class="table table-bordered table-hover definewidth m10">
    <thead>
    <tr>
		<th>选择</th>
        <th>ID</th>
		<th >解答员工</th>
		<th >头像</th>
		<th >内容</th>
		<th >是否最优</th>
        <th>管理操作</th>
    </tr>
    </thead>

	<?php
		foreach($list as $k => $v){
	?>
    <tr>
		<td width="50"><label class="check" for="<?=$v['id']?>"><input class="" name="cheid" id="<?=$v['id']?>"  value="<?=$v['id']?>" type="checkbox"></label></td>
        <td valign="middle"><?=$v['id']?></td>      
        <td valign="middle"><?=$v['realname']?></td>
		 <td valign="middle"><img src="<?=base_url()?>uploads/member/header/<?=$v['headerurl']?>"  width="40px" height="40px"/></td>
        <td><?=$v['content']?></td>
		<td >
		<?php if($v['isbest']==1){?>是<?php }else{ ?>否<?php } ?>
		</td>
        <td>
		<!--<a href="<?=base_url()?>index.php?d=home&c=project&m=update&id=<?=$v['id']?>">编辑</a> | -->
		<a href="javascript:void(0);" onClick="flush('删除后不能恢复，确定删除吗?','<?=base_url()?>index.php?d=home&c=conquer&m=replydel&id=<?=$v['id']?>');">删除</a> 
		</td>
    </tr>

	<?php
	}
	?>
	<tr>
        <td colspan="8"><div class="btn_check pt10" style="float:left"><input  onClick="selectAll(this)"  id="che" name="che" type="checkbox">全选/取消&nbsp;&nbsp;<a href="javascript:;" onclick="return judgeSelect();" class="btn_del">删除所选</a></div><div class="btn_check pt10" style="float:right"><?=$page?></div></td>
    </tr>
</table>

</body>
</html>

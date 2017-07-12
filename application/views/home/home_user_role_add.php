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
<script  type="text/javascript" src="<?=base_url() ?>static/js/My97DatePicker/WdatePicker.js"></script>
<script language="javascript" type="text/javascript">
function CheckAll(paramId) 
{
	var items = document.getElementsByTagName("input"); 
    for(i=0; i<items.length;i++)
    {
        var e = items[i];
		var eId = e.id;//获得当前控件元素的Id
		var m = eId.indexOf('_chk');
		var n = paramId.indexOf('_chk');
		//判断控件类型是否是checkbox,父子节点Id是否匹配,以控制只选中该父节点对应的子节点	
		if(eId.substring(0,m)==paramId.substring(0,n) &&e.type=='checkbox')
		{
			e.checked = document.getElementById(paramId).checked;
		}
     }		
}
function CheckOnly(paramId)
{
    var items = document.getElementsByTagName("input"); 
	for(i=0; i<items.length;i++)
	{
        var e = items[i];
		var eId = e.id;
		var m = eId.indexOf('_chk');
		var n = paramId.indexOf('_chk');	
		//判断控件类型是否是checkbox,父子节点Id是否匹配,以控制只选中该子节点对应的父节点
		if(eId.substring(0,m) == paramId.substring(0,n) && e.type=='checkbox')							
		{
            if(eId.indexOf('chkParentMenu')!=-1){document.getElementById(eId).checked =true;}
		}
	}
}
</script>
<style>
	.cssli li{  list-style:none;}
	.radio input[type="radio"], .radio-inline input[type="radio"], .checkbox input[type="checkbox"], .checkbox-inline input[type="checkbox"]{
		margin-left: -20px;
		position:static;
	}
</style>
<body>


<form method="post" action="<?=base_url()?>index.php?d=home&c=user_role&m=add" enctype="multipart/form-data">
<table width="511" class="table table-bordered table-hover definewidth m10">
    <thead>
    <tr>

        <th width="64"></th>
        <th width="332"></th>
		<th width="99"></th>
    </tr>
    </thead>
    <tr>
        <td class="tableleft">名称</td>       
        <td colspan="2">
         <input type="text" name="txt_name" id="txt_name">        </td>
	</tr>
	<tr>
				<td class="tableleft">选择权限</td>
				<td class="td_left">
					<ul class="cssli">
				 <?php  foreach ($mune as $v) { ?>
				<li style="margin-bottom:15px;"><label class='checkbox inline' ><input type="checkbox" name="D_ids-add[]" onclick="CheckAll(this.id)" value="<?=$v['nodeId'] ?>" class="D_ids-add" id="<?=$v['nodeId'] ?>_chkParentMenu"  /><?=$v['displayName'] ?></label>
					<p style="">
						 <ul id="<?=$v['nodeId'] ?>_chklstChildMenu">
							 <?php  foreach ($v['items'] as $v1) {    ?>
							<li style="margin-left:30px; margin-top:10px; margin-bottom:15px;">
							<label class='checkbox inline'><input type="checkbox" name="D_ids-add[]" value="<?=$v1['nodeId'] ?>" class="D_ids-add" onclick="CheckOnly(this.id)" id="<?=$v['nodeId'] ?>_chklstChildMenu_<?=$v1['nodeId'] ?>" /><?=$v1['displayName'] ?></label>
							 </li>
							 <?php }  ?>
						</ul>
					</p>
				</li>
				 <?php }  ?>
				 </ul>
				</td>
			</tr>
    <tr>
      <td class="tableleft">
	  
        <input type="submit" name="Submit" value="提交" onClick="return checkAllInputData()">      </td>
      <td colspan="2">&nbsp;</td>
    </tr>
</table>
</form>
<script language="javascript" type="text/javascript">
	function checkAllInputData(){
 		 var txt_name = $("#txt_name").val();
		 if(txt_name.length == 0){
		 	alert('请输入名称');
			return false;
		 }
		
	}

</script>
</body>
</html>

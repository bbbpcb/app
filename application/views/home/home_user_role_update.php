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
<body>


<form method="post" action="<?=base_url()?>index.php?d=home&c=user_role&m=update" enctype="multipart/form-data">
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
         <input type="text" name="txt_name" id="txt_name" value="<?=$info['name']?>">       </td>
	</tr>
      
    <tr>
      <td class="tableleft">
	       <input type="hidden" name="id" value="<?=$info['rid']?>" />
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

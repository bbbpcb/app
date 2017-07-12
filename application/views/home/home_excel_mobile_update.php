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


<form method="post" action="<?=base_url()?>index.php?d=home&c=excelmobile&m=update" enctype="multipart/form-data">
<table width="511" class="table table-bordered table-hover definewidth m10">
    <thead>
    <tr>

        <th width="64"></th>
        <th width="332"></th>
		<th width="99"></th>
    </tr>
    </thead>


    <tr>
        <td class="tableleft">手机号</td>       
        <td colspan="2">
         <input type="text" name="txt_mobile" id="txt_mobile" value="<?=$info['mobile']?>">       </td>
	</tr>
       
    <tr>
      <td class="tableleft">
	       <input type="hidden" name="id" value="<?=$info['id']?>" />
        <input type="submit" name="Submit" value="提交" onClick="return checkAllInputData()">      </td>
      <td colspan="2">&nbsp;</td>
    </tr>
</table>
</form>

<script language="javascript" type="text/javascript">
	function checkAllInputData(){
 		 var txt_mobile = $("#txt_mobile").val();
		 if(txt_mobile.length == 0){
		 	alert('请输入手机号');
			return false;
		 }
		
	}

</script>
</body>
</html>

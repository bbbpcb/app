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


<form method="post" action="<?=base_url()?>index.php?d=home&c=excelmobile&m=exceladd" enctype="multipart/form-data">
<table width="511" class="table table-bordered table-hover definewidth m10">
    <thead>
    <tr>

        <th width="64"></th>
        <th width="332"></th>
		<th width="99"></th>
    </tr>
    </thead>


    <tr>
        <td class="tableleft">导入文件</td>       
        <td colspan="2">
         <input  type="file" name="file_stu" />       </td>
	</tr>
       
    <tr>
      <td class="tableleft">
	  
        <input type="submit" name="Submit" value="提交" >      </td>
      <td colspan="2">&nbsp;</td>
    </tr>
</table>
</form>
</body>
</html>

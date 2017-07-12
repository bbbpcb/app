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


<form method="post" action="<?=base_url()?>index.php?d=home&c=banner&m=add" enctype="multipart/form-data">
<table width="511" class="table table-bordered table-hover definewidth m10">
    <thead>
    <tr>

        <th width="64"></th>
        <th width="332"></th>
		<th width="99"></th>
    </tr>
    </thead>



    <tr>
      <td>图片</td>
      <td colspan="2">
        <input type="file" name="userfile">      </td>
    </tr>
   <tr>
        <td>链接地址</td>       
       <td colspan="2">
         <input type="text" name="url">
       </td>
	</tr>
       <tr>
        <td>排序</td>       
        <td colspan="2">
          <input type="text" name="rank">
        </td>
	</tr>
    <tr>
      <td>

        <input type="submit" name="Submit" value="提交">      </td>
      <td colspan="2">&nbsp;</td>
    </tr>
</table>
</form>
</body>
</html>

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


<form method="post" action="<?=base_url()?>index.php?d=home&c=tasktype&m=add" enctype="multipart/form-data">
<table width="511" class="table table-bordered table-hover definewidth m10">
    <thead>
    <tr>

        <th width="64"></th>
        <th width="332"></th>
		<th width="99"></th>
    </tr>
    </thead>


    <tr>
        <td class="tableleft">类型名称</td>       
        <td colspan="2">
         <input type="text" name="type_name">       </td>
	</tr>
 <tr>
        <td class="tableleft">所属模块</td>       
        <td colspan="2">
    	 <select name="t_type">
            <?php
              foreach($list as $k => $v){
            ?>
            <option value="<?=$v['id']?>"><?=$v['m_name']?></option>
            <?php
              }
            ?>
         </select>     
		 
	    </td>
	</tr>
        
      <tr>
      <td class="tableleft">排序</td>
      <td colspan="2">
         <input type="text" name="rank">      </td>
    </tr>
       
    <tr>
      <td class="tableleft">
	  
        <input type="submit" name="Submit" value="提交">      </td>
      <td colspan="2">&nbsp;</td>
    </tr>
</table>
</form>
</body>
</html>

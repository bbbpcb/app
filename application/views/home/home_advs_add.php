<?php Widget::head();?>
<body>
	

<form name="form1" method="post" action="<?=base_url()?>index.php?d=home&c=advs&m=add" enctype="multipart/form-data"/>
<table class="table table-bordered table-hover definewidth m10">
    <thead>
    <tr>

        <th></th>      
        <th></th>


    </tr>
    </thead>
	 <tr>
        <td>标题</td>   
        <td><input type="text" name="title" /></td>      
    </tr>
    <tr>
        <td>图片</td>   
        <td><input type="file" name="userfile" /></td>      
    </tr>
    <tr style="display:none">
	 	<td>类型:</td>   
        <td>
         <select name="typeid">
            <option value="0">=项目类型=</option>
            <option value="1">重大项目</option>
            <option value="2">基础项目</option>
            <option value="3">复盘</option>
            <option value="4">任务</option>

         </select>
        </td>       	 
    </tr>
     <tr>
        <td>链接地址</td>   
        <td><input type="text" name="links"  value="#"/></td>      
    </tr>


    <tr>
	 	<td colspan="4"><input type="submit" value="提交"/></td>   
    </tr>
	</table>
</form>
</body>
</html>

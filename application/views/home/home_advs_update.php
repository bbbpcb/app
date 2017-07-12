<?php Widget::head();?>
<body>
	

<form name="form1" method="post" action="<?=base_url()?>index.php?d=home&c=advs&m=update" enctype="multipart/form-data"/>
<table class="table table-bordered table-hover definewidth m10">
    <thead>
    <tr>

        <th></th>      
        <th></th>


    </tr>
    </thead>
	<tr>
        <td>标题</td>   
        <td><input type="text" name="title"  value="<?=$info['title']?>"/></td>      
    </tr>
    <tr>
        <td>图片</td>   
        <td><input type="file" name="userfile" /><img src="<?=base_url()?>uploads/pics/<?=$info['img1']?>"  width="40px" height="40px"/></td>     
		<input type="hidden" id="fileimg" name="fileimg" value="<?=$info['img1']?>"> 
    </tr>
    <tr style="display:none;">
	 	<td>类型:</td>   
        <td>
         <select name="typeid">
            <option value="0" <?php if($info['typeid'] == 0){?> selected <?php } ?>>=项目类型=</option>
            <option value="1" <?php if($info['typeid'] == 1){?> selected <?php } ?>>重大项目</option>
            <option value="2" <?php if($info['typeid'] == 2){?> selected <?php } ?>>基础项目</option>
            <option value="3" <?php if($info['typeid'] == 3){?> selected <?php } ?>>复盘</option>
            <option value="4" <?php if($info['typeid'] == 4){?> selected <?php } ?>>任务</option>


         </select>
        </td>       	 
    </tr>
    <tr>
        <td>链接地址</td>   
        <td><input type="text" name="links"  value="<?=$info['links']?>"/></td>      
    </tr>



    <tr>
        <input type="hidden" name="id" value="<?=$info['id']?>" />
	 	<td colspan="4"><input type="submit" value="提交"/></td>   
    </tr>
	</table>
</form>
</body>
</html>

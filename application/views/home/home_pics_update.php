<?php Widget::head();?>
<body>
	

<form name="form1" method="post" action="<?=base_url()?>index.php?d=home&c=pics&m=update" enctype="multipart/form-data"/>
<table class="table table-bordered table-hover definewidth m10">
    <thead>
    <tr>

        <th></th>      
        <th></th>


    </tr>
    </thead>
    <tr>
        <td>图片</td>   
        <td><input type="file" name="userfile" /><img src="<?=base_url()?>uploads/pics/<?=$info['picname']?>"  width="40px" height="40px"/></td>     
		<input type="hidden" id="fileimg" name="fileimg" value="<?=$info['picname']?>">  
    </tr>
    <tr>
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
        <td>难度:</td>   
        <td>
         <select name="nandu">
            <option value="0">=难度星级=</option>
            <option value="1" <?php if($info['nandu'] == 1){?> selected <?php } ?>>1</option>
            <option value="2" <?php if($info['nandu'] == 2){?> selected <?php } ?>>2</option>
            <option value="3" <?php if($info['nandu'] == 3){?> selected <?php } ?>>3</option>
            <option value="4" <?php if($info['nandu'] == 4){?> selected <?php } ?>>4</option>
            <option value="5" <?php if($info['nandu'] == 5){?> selected <?php } ?>>5</option>

         </select>
        </td>           
    </tr>
	<tr>
        <td>规模:</td>   
        <td>
         <select name="guimo">
            <option value="0">=规模星级=</option>
            <option value="1" <?php if($info['guimo'] == 1){?> selected <?php } ?>>1</option>
            <option value="2" <?php if($info['guimo'] == 2){?> selected <?php } ?>>2</option>
            <option value="3" <?php if($info['guimo'] == 3){?> selected <?php } ?>>3</option>
            <option value="4" <?php if($info['guimo'] == 4){?> selected <?php } ?>>4</option>
            <option value="5" <?php if($info['guimo'] == 5){?> selected <?php } ?>>5</option>

         </select>
        </td>           
    </tr>


    <tr>
        <input type="hidden" name="id" value="<?=$info['id']?>" />
	 	<td colspan="4"><input type="submit" value="提交"/></td>   
    </tr>
	</table>
</form>
</body>
</html>

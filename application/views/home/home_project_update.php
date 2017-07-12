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


<form method="post" action="<?=base_url()?>index.php?d=home&c=project&m=add" enctype="multipart/form-data">
<table width="511" class="table table-bordered table-hover definewidth m10">
    <thead>
    <tr>

        <th width="64"></th>
        <th width="332"></th>
		<th width="99"></th>
    </tr>
    </thead>


    <tr>
        <td class="tableleft">项目名称</td>       
       <td colspan="2">
         <input type="text" name="title" value="<?=$info['title']?>" id="title">
       </td>
	</tr>
      <tr>
        <td class="tableleft">项目类型</td>       
       <td colspan="2">
         <select name="typeid" id="typeid">
            <option value="0">=项目类型=</option>
            <option value="1" <?php if($info['typeid'] == 1){ ?> selected <?php } ?>>重大项目</option>
            <option value="2" <?php if($info['typeid'] == 2){ ?> selected <?php } ?>>基础项目</option>
         </select>
       </td>
  </tr>
        <tr>
        <td class="tableleft">创建人</td>       
       <td colspan="2">
           <?=$info['realname']?>
       </td>
  </tr>
  <tr>
        <td class="tableleft">负责人</td>       
       <td colspan="2">
           <?=$info['header']?>
       </td>
  </tr>


      <tr>
      <td class="tableleft">规模</td>
      <td colspan="2">
        <select name="scale" id="scale">
            <option value="0">=规模=</option>
            <option value="1" <?php if($info['scale'] == 1){ ?> selected <?php } ?>>1</option>
            <option value="2" <?php if($info['scale'] == 2){ ?> selected <?php } ?>>2</option>
            <option value="3" <?php if($info['scale'] == 3){ ?> selected <?php } ?>>3</option>
            <option value="4" <?php if($info['scale'] == 4){ ?> selected <?php } ?>>4</option>
            <option value="5" <?php if($info['scale'] == 5){ ?> selected <?php } ?>>5</option>
         </select>
      </td>
    </tr>
        <tr>
        <td class="tableleft">难度</td>       
       <td colspan="2">
          <select name="difficulty" id="difficulty">
            <option value="0">=难度=</option>
            <option value="1" <?php if($info['difficulty'] == 1){ ?> selected <?php } ?>>1</option>
            <option value="2" <?php if($info['difficulty'] == 2){ ?> selected <?php } ?>>2</option>
            <option value="3" <?php if($info['difficulty'] == 3){ ?> selected <?php } ?>>3</option>
            <option value="4" <?php if($info['difficulty'] == 4){ ?> selected <?php } ?>>4</option>
            <option value="5" <?php if($info['difficulty'] == 5){ ?> selected <?php } ?>>5</option>
         </select>
       </td>
  </tr>
   <tr>
        <td class="tableleft">质量</td>       
       <td colspan="2">
          <select name="quality" id="quality">
            <option value="0">=质量=</option>
            <option value="1" <?php if($info['quality'] == 1){ ?> selected <?php } ?>>1</option>
            <option value="2" <?php if($info['quality'] == 2){ ?> selected <?php } ?>>2</option>
            <option value="3" <?php if($info['quality'] == 3){ ?> selected <?php } ?>>3</option>
            <option value="4" <?php if($info['quality'] == 4){ ?> selected <?php } ?>>4</option>
            <option value="5" <?php if($info['quality'] == 5){ ?> selected <?php } ?>>5</option>
         </select>
       </td>
  </tr>
     <tr>
      <td class="tableleft">特性</td>       
       <td colspan="2">
          <select name="features" id="features">
            <option value="0">=特性=</option>
            <option value="1" <?php if($info['features'] == 1){ ?> selected <?php } ?>>1</option>
            <option value="2" <?php if($info['features'] == 2){ ?> selected <?php } ?>>2</option>
            <option value="3" <?php if($info['features'] == 3){ ?> selected <?php } ?>>3</option>
            <option value="4" <?php if($info['features'] == 4){ ?> selected <?php } ?>>4</option>
            <option value="5" <?php if($info['features'] == 5){ ?> selected <?php } ?>>5</option>
         </select>
       </td>
  </tr>
   <tr>
        <td class="tableleft">简介</td>       
       <td colspan="2">
         <textarea name="intro" class="form-control" rows="3"><?=$info['intro']?></textarea>
       </td>
  </tr>


    <tr>
      <td class="tableleft">状态</td>
      <td colspan="2">
        <input type="radio" name="status" value="1"  checked="checked"/>正常  <input type="radio" name="status" value="0" />停用
      </td>
    </tr>
    <tr>
      <td class="tableleft">
        <input type="hidden" name="id" value="<?=$info['id']?>" />
        <input type="submit" name="Submit" value="提交" class="btn btn-default" onclick="return checkAllInputData()">
      </td>
      <td colspan="2">&nbsp;</td>
    </tr>
</table>
</form>
<script language="javascript" type="text/javascript">
	function checkAllInputData(){
 		 var title = $("#title").val();
		 if(title.length == 0){
		 	alert('请输入项目名称');
			return false;
		 }
		 var typeid = $("#typeid").val();
		 if(typeid == 0){
		 	alert('请选择项目类型');
			return false;
		 }
		 var scale = $("#scale").val();
		 if(scale == 0){
		 	alert('请选择规模');
			return false;
		 }
		 var difficulty = $("#difficulty").val();
		 if(difficulty == 0){
		 	alert('请选择难度');
			return false;
		 }
		 var quality = $("#quality").val();
		 if(quality == 0){
		 	alert('请选择质量');
			return false;
		 }
		 var features = $("#features").val();
		 if(features == 0){
		 	alert('请选择特性');
			return false;
		 }
	}

</script>
</body>
</html>

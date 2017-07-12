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


<form method="post" action="<?=base_url()?>index.php?d=home&c=task&m=add" enctype="multipart/form-data">
<table width="511" class="table table-bordered table-hover definewidth m10">
    <thead>
    <tr>

        <th width="64"></th>
        <th width="332"></th>
		<th width="99"></th>
    </tr>
    </thead>


    <tr>
        <td>任务名称</td>       
       <td colspan="2">
         <input type="text" name="t_name" value="<?=$info['title']?>">
       </td>
	</tr>
        <tr>
      <td class="tableleft">ICON</td>
      <td colspan="2">
	   <?php if (!empty($info['icon'])) { ?>
            <img src="<?=base_url()?>/uploads/task/<?=$info['icon']?>" class="zj_img bord_1" id="img"  width="150" heigth="100"   alt="">
          <?php } ?>
        <input type="file" name="userfile">    
		 <input type="hidden" name="img" id="img" value="<?=$info['icon']?>"/><br>        
		  </td>
    </tr>
	 <tr>
        <td>模块类型</td>       
       <td colspan="2">
         <select name="t_typemod" id="t_typemod">
            <option value="0">=模块类型=</option>
            <?php
              foreach($typemod as $k => $v){
            ?>
            <option value="<?=$v['id']?>" <?php if($info['modid'] == $v['id']){ ?> selected <?php } ?>><?=$v['m_name']?></option>
            <?php
              }
            ?>
         </select>
		  <input type="hidden" id="vmod" name="vmod" value="<?=$info['modid']?>" />
       </td>
  </tr>
      <tr>
        <td>任务类型</td>       
       <td colspan="2">
         <select name="t_type" id="t_typemod1">
            <option value="0">=任务类型=</option>

         </select>
		  <input type="hidden" id="vtype" name="vtype" value="<?=$info['task_type']?>" />
       </td>
  </tr>
   <tr>
        <td>所属项目</td>       
       <td colspan="2">
         <select name="t_proid" id="t_proid">
            <?php
              foreach($prolist as $k => $v){
            ?>
            <option value="<?=$v['id']?>" <?php if($info['proid'] == $v['id']){ ?> selected <?php } ?>><?=$v['title']?></option>
            <?php
              }
            ?>
         </select>
		 <input type="hidden" id="vmod" name="vmod" value="" />
       </td>
  </tr>
     <tr>
      <td>规模</td>
      <td colspan="2">
         <input type="text" name="t_scale" value="<?=$info['scale']?>">
      </td>
    </tr>
        <tr>
        <td>难度</td>       
       <td colspan="2">
         <input type="text" name="t_difficulty" value="<?=$info['quality']?>">
       </td>
  </tr>
   <tr>
        <td>质量</td>       
       <td colspan="2">
         <input type="text" name="t_quality" value="<?=$info['difficulty']?>">
       </td>
  </tr>
   <tr>
        <td>特性</td>       
       <td colspan="2">
         <input type="text" name="t_features" value="<?=$info['features']?>">
       </td>
  </tr>
   <tr>
        <td>简介</td>       
       <td colspan="2">
         <textarea name="t_content"><?=$info['intro']?></textarea>
       </td>
  </tr>


    <tr>
      <td>状态</td>
      <td colspan="2">
        <input type="radio" name="status" value="1"  checked="checked"/>正常  <input type="radio" name="status" value="0" />停用
      </td>
    </tr>
    <tr>
      <td>
        <input type="hidden" name="id" value="<?=$info['id']?>" />
         <input type="hidden" name="mid" value="<?=$info['modid']?>" />
          <input type="hidden" name="pid" value="<?=$info['proid']?>" />
        <input type="submit" name="Submit" value="提交">
      </td>
      <td colspan="2">&nbsp;</td>
    </tr>
</table>
</form>
</body>
</html>
<script>
	var hostname ='<?=base_url() ?>';
</script>
<script type="text/javascript" src="<?=base_url() ?>static/js/public.js"></script>

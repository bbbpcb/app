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
         <input type="text" name="t_name">
       </td>
	</tr>
      <tr>
      <td class="tableleft">ICON</td>
      <td colspan="2">
        <input type="file" name="userfile">      </td>
    </tr>
     
        <tr>
        <td>模块类型</td>       
       <td colspan="2">
         <select name="t_typemod" id="t_typemod">
            <option value="0">=模块类型=</option>
            <?php
              foreach($typemod as $k => $v){
            ?>
            <option value="<?=$v['id']?>"><?=$v['m_name']?></option>
            <?php
              }
            ?>
         </select>
		 <input type="hidden" id="vmod" name="vmod" value="" />
       </td>
  </tr>
   <tr>
        <td>任务类型</td>       
       <td colspan="2">
         <select name="t_type" id="t_typemod1">
           <option value="0">=任务类型=</option>
         </select>
       </td>
  </tr>
   <tr>
        <td>所属项目</td>       
       <td colspan="2">
         <select name="t_proid" id="t_proid">
            <?php
              foreach($prolist as $k => $v){
            ?>
            <option value="<?=$v['id']?>"><?=$v['title']?></option>
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
         <input type="text" name="t_scale">
      </td>
    </tr>
        <tr>
        <td>难度</td>       
       <td colspan="2">
         <input type="text" name="t_difficulty">
       </td>
  </tr>
   <tr>
        <td>质量</td>       
       <td colspan="2">
         <input type="text" name="t_quality">
       </td>
  </tr>
   <tr>
        <td>特性</td>       
       <td colspan="2">
         <input type="text" name="t_features">
       </td>
  </tr>
   <tr>
        <td>简介</td>       
       <td colspan="2">
         <textarea name="t_content"></textarea>
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
        <input type="hidden" name="mid" value="<?=$mid?>" />
         <input type="hidden" name="pid" value="<?=$pid?>" />
        <input type="submit" name="Submit" value="提交">
      </td>
      <td colspan="2">&nbsp;</td>
    </tr>
</table>
</form>
<script>
	var hostname ='<?=base_url() ?>';
</script>
<script type="text/javascript" src="<?=base_url() ?>static/js/public.js"></script>
</body>
</html>

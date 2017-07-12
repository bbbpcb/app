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
<ol class="breadcrumb">
  <li><a href="<?=base_url()?>index.php?d=home&c=member">公式设置</a></li>
  <li>查看</li>
</ol>

<form method="post" action="<?=base_url()?>index.php?d=home&c=gongshi&m=update" enctype="multipart/form-data">
<table width="511" class="table table-bordered table-hover definewidth m10">
    <thead>
    <tr>

    <th width="64"></th>
        <th width="332"></th>
    <th width="99"></th>
    </tr>
    </thead>


    <tr>
        <td class="tableleft">规模</td>       
       <td colspan="2">
	   				<input type="hidden" id="gmid" name="gmid" value="<?=$list[0]['id']?>">
			一颗星：<input type="text" name="gmstar[]" id="gmstar1" value="<?=$list[0]['star1']?>">
			二颗星：<input type="text" name="gmstar[]" id="gmstar2" value="<?=$list[0]['star2']?>">
			三颗星：<input type="text" name="gmstar[]" id="gmstar3" value="<?=$list[0]['star3']?>">
			四颗星：<input type="text" name="gmstar[]" id="gmstar4" value="<?=$list[0]['star4']?>">
			五颗星：<input type="text" name="gmstar[]" id="gmstar5" value="<?=$list[0]['star5']?>">
       </td>
  </tr>
<tr>
        <td class="tableleft">难度</td>       
       <td colspan="2">
	   <input type="hidden" id="ndid" name="ndid" value="<?=$list[1]['id']?>">
			一颗星：<input type="text" name="ndstar[]" id="ndstar1" value="<?=$list[1]['star1']?>">
			二颗星：<input type="text" name="ndstar[]" id="ndstar2" value="<?=$list[1]['star2']?>">
			三颗星：<input type="text" name="ndstar[]" id="ndstar3" value="<?=$list[1]['star3']?>">
			四颗星：<input type="text" name="ndstar[]" id="ndstar4" value="<?=$list[1]['star4']?>">
			五颗星：<input type="text" name="ndstar[]" id="ndstar5" value="<?=$list[1]['star5']?>">
       </td>
  </tr>
  <tr>
        <td class="tableleft">质量</td>       
       <td colspan="2">
	   <input type="hidden" id="zlid" name="zlid" value="<?=$list[2]['id']?>">
			一颗星：<input type="text" name="zlstar[]" id="zlstar1" value="<?=$list[2]['star1']?>">
			二颗星：<input type="text" name="zlstar[]" id="zlstar2" value="<?=$list[2]['star2']?>">
			三颗星：<input type="text" name="zlstar[]" id="zlstar3" value="<?=$list[2]['star3']?>">
			四颗星：<input type="text" name="zlstar[]" id="zlstar4" value="<?=$list[2]['star4']?>">
			五颗星：<input type="text" name="zlstar[]" id="zlstar5" value="<?=$list[2]['star5']?>">
       </td>
  </tr>
  <tr>
        <td class="tableleft">特性</td>       
       <td colspan="2">
	   <input type="hidden" id="txid" name="txid" value="<?=$list[3]['id']?>">
			一颗星：<input type="text" name="txstar[]" id="txstar1" value="<?=$list[3]['star1']?>">
			二颗星：<input type="text" name="txstar[]" id="txstar2" value="<?=$list[3]['star2']?>">
			三颗星：<input type="text" name="txstar[]" id="txstar3" value="<?=$list[3]['star3']?>">
			四颗星：<input type="text" name="txstar[]" id="txstar4" value="<?=$list[3]['star4']?>">
			五颗星：<input type="text" name="txstar[]" id="txstar5" value="<?=$list[3]['star5']?>">
       </td>
  </tr>
      <tr>
        <td class="tableleft">系数换算</td>       
       <td colspan="2">
         规模 <input type="text" name="j[]" value="<?=$j[0]?>">难度 <input type="text" name="j[]" value="<?=$j[1]?>"> 质量 <input type="text" name="j[]" value="<?=$j[2]?>">特性
       </td>

		 <tr>
        <td class="tableleft">人气分数</td>       
       <td colspan="2">
         分值 <input type="text" name="renqigrade" value="<?=$renqifen?>">
       </td>


    <tr>
      <td class="tableleft">
        <input type="submit" name="button" value="提交" class="btn btn-default">
      </td>
      <td colspan="2">&nbsp;</td>
    </tr>
</table>
</form>
</body>
</html>

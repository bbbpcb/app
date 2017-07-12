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

<form method="post" action="<?=base_url()?>index.php?d=home&c=member&m=add" enctype="multipart/form-data">
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
			一颗星：<?=$list[0]['star1']?>
			二颗星：<?=$list[0]['star2']?>
			三颗星：<?=$list[0]['star3']?>
			四颗星：<?=$list[0]['star4']?>
			五颗星：<?=$list[0]['star5']?>
       </td>
  </tr>
	<tr>
        <td class="tableleft">难度</td>       
       <td colspan="2">
			一颗星：<?=$list[1]['star1']?>
			二颗星：<?=$list[1]['star2']?>
			三颗星：<?=$list[1]['star3']?>
			四颗星：<?=$list[1]['star4']?>
			五颗星：<?=$list[1]['star5']?>
       </td>
  </tr>
  	<tr>
        <td class="tableleft">质量</td>       
       <td colspan="2">
			一颗星：<?=$list[2]['star1']?>
			二颗星：<?=$list[2]['star2']?>
			三颗星：<?=$list[2]['star3']?>
			四颗星：<?=$list[2]['star4']?>
			五颗星：<?=$list[2]['star5']?>
       </td>
  </tr>
  	<tr>
        <td class="tableleft">特性</td>       
       <td colspan="2">
			一颗星：<?=$list[3]['star1']?>
			二颗星：<?=$list[3]['star2']?>
			三颗星：<?=$list[3]['star3']?>
			四颗星：<?=$list[3]['star4']?>
			五颗星：<?=$list[3]['star5']?>
       </td>
  </tr>

      <tr>
        <td class="tableleft">系数换算</td>       
       <td colspan="2">
         规模<?=$j[0]?>难度<?=$j[1]?>质量<?=$j[2]?>特性
       </td>
    <tr>
	 <tr>
        <td class="tableleft">人气分数</td>       
       <td colspan="2">
         <?=$renqifen?>
       </td>
    <tr>
      <td class="tableleft">
        <input type="button" name="button" value="修改" class="btn btn-default" onClick="window.location='<?=base_url()?>index.php?d=home&c=gongshi&m=update'">
      </td>
      <td colspan="2">&nbsp;</td>
    </tr>
</table>
</form>
</body>
</html>

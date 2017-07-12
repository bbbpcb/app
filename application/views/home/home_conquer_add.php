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
  <li><a href="<?=base_url()?>index.php?d=home&c=conquer">复盘</a></li>
  <li>添加</li>
</ol>

<form method="post" action="<?=base_url()?>index.php?d=home&c=conquer&m=add" enctype="multipart/form-data">
<table width="511" class="table table-bordered table-hover definewidth m10">
    <thead>
    <tr>

        <th width="64"></th>
        <th width="332"></th>
		<th width="99"></th>
    </tr>
    </thead>


    <tr>
        <td class="tableleft">复盘名称</td>       
       <td colspan="2">
         <input type="text" name="title">
       </td>
	</tr>
	<tr>
        <td class="tableleft">项目归属</td>       
       <td colspan="2">
         <select name="proid">
            <?php
              foreach($project as $k => $v){
            ?>
            <option value="<?=$v['id']?>"><?=$v['title']?></option>
            <?php
              }
            ?>
         </select>
       </td>
  </tr>
      <tr>
        <td class="tableleft">复盘类型</td>       
       <td colspan="2">
         <select name="typeid">
            <?php
              foreach($type as $k => $v){
            ?>
            <option value="<?=$v['id']?>"><?=$v['type_name']?></option>
            <?php
              }
            ?>
         </select>
       </td>
  </tr>
      <tr>
      <td class="tableleft">发起人</td>
      <td colspan="2">
        <select class="" name="uid">

          <option value="0">=发起人=</option>
          <?php
            foreach($ex as $k => $v){
          ?>
          <option value="<?=$v['id']?>"><?=$v['realname']?></option>
          <?php
            }
          ?>
        </select>
      </td>
    </tr>
    <tr>
      <td class="tableleft">图片</td>
      <td colspan="2">
        <input type="file" name="userfile">      </td>
    </tr>
   <tr>
        <td class="tableleft">最优得分</td>       
       <td colspan="2">
         <input type="text" name="total">
       </td>
  </tr>
   <tr>
        <td class="tableleft">简介</td>       
       <td colspan="2">
         <textarea name="content" class="form-control" rows="3"></textarea>
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
        <input type="submit" name="Submit" value="提交" class="btn btn-default">
      </td>
      <td colspan="2">&nbsp;</td>
    </tr>
</table>
</form>
</body>
</html>

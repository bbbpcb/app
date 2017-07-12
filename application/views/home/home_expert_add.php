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
  <li><a href="<?=base_url()?>index.php?d=home&c=expert">专家列表</a></li>
  <li>添加专家</li>
</ol>

<form method="post" action="<?=base_url()?>index.php?d=home&c=expert&m=add" enctype="multipart/form-data">
<table width="511" class="table table-bordered table-hover definewidth m10">
    <thead>
    <tr>

        <th width="64"></th>
        <th width="332"></th>
		<th width="99"></th>
    </tr>
    </thead>


    <tr>
        <td class="tableleft">用户名</td>       
       <td colspan="2">
         <input type="text" name="username"><span class="label label-danger">必填</span>
       </td>
	</tr>
      <tr>
        <td class="tableleft">真是姓名</td>       
       <td colspan="2">
         <input type="text" name="realname"><span class="label label-danger">必填</span>
       </td>
  </tr>
      <tr>
      <td class="tableleft">头像</td>
      <td colspan="2">
        <input type="file" name="userfile">
      </td>
    </tr>
        <tr>
        <td class="tableleft">密码</td>       
       <td colspan="2">
         <input type="password" name="passwd"><span class="label label-danger">必填</span>
       </td>
  </tr>
   <tr>
        <td class="tableleft">手机号</td>       
       <td colspan="2">
         <input type="text" name="mobile"><span class="label label-danger">必填</span>
       </td>
  </tr>
     <tr>
        <td class="tableleft">验证电话</td>       
       <td colspan="2">
         <input type="text" name="check_mobile"><span class="label label-danger">必填</span>
       </td>
  </tr>
       <tr>
        <td class="tableleft">部门</td>       
       <td colspan="2">
         <select name="depid">
		 	<option value="0">==选择部门==</option>
      <?php
        foreach($dep as $dk => $dv){
      ?>
        <option value="<?=$dv['id']?>" ><?=$dv['dep_name']?></option>
        <?php
      }
        ?>
		 </select><span class="label label-danger">必填</span>
       </td>
  </tr>

         <tr>
        <td class="tableleft">专业</td>       
       <td colspan="2">
         <input type="text" name="profession">
       </td>
  </tr>
           <tr>
        <td class="tableleft">行业</td>       
       <td colspan="2">
         <input type="text" name="industry">
       </td>
  </tr>

    <tr>
      <td class="tableleft">简介</td>
      <td colspan="2">
        <textarea name="content"></textarea>
      </td>
    </tr>
    <tr>
      <td class="tableleft">帐号状态</td>
      <td colspan="2">
        <input type="radio" name="enabled" value="1"  checked="checked"/>正常  <input type="radio" name="enabled" value="0" />停用
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

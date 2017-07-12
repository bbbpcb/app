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
  <li>修改</li>
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
        <td>用户名</td>       
       <td colspan="2">
         <input type="text" name="username" value="<?=$info['username']?>">
       </td>
	</tr>
      <tr>
        <td>真实姓名</td>       
       <td colspan="2">
         <input type="text" name="realname" value="<?=$info['realname']?>">
       </td>
  </tr>
      <tr>
      <td>头像</td>
      <td colspan="2">
        <input type="file" name="userfile"><img src="<?=base_url()?>uploads/member/header/<?=$info['headerurl']?>" width="40px" height="40px" />
      </td>
    </tr>
        <tr>
        <td>密码</td>       
       <td colspan="2">
         <input type="password" name="passwd">
       </td>
  </tr>
   <tr>
        <td>手机号</td>       
       <td colspan="2">
         <input type="text" name="mobile" value="<?=$info['mobile']?>">
       </td>
  </tr>
     <tr>
        <td>验证电话</td>       
       <td colspan="2">
         <input type="text" name="check_mobile" value="<?=$info['check_mobile']?>">
       </td>
  </tr>
       <tr>
        <td>部门</td>       
       <td colspan="2">
         <select name="depid">
		 	<option value="0">==选择部门==</option>
      <?php
        foreach($dep as $dk => $dv){
      ?>
				<option value="<?=$dv['id']?>" <?php if($info['depid'] == $dv['id']){ ?> selected <?php } ?>><?=$dv['dep_name']?></option>
        <?php
      }
        ?>
		 </select>
       </td>
  </tr>

         <tr>
        <td>专业</td>       
       <td colspan="2">
         <input type="text" name="profession" value="<?=$info['profession']?>">
       </td>
  </tr>
           <tr>
        <td>行业</td>       
       <td colspan="2">
         <input type="text" name="industry" value="<?=$info['industry']?>">
       </td>
  </tr>

    <tr>
      <td>简介</td>
      <td colspan="2">
        <textarea name="content"><?=$info['content']?></textarea>
      </td>
    </tr>
    <tr>
      <td>帐号状态</td>
      <td colspan="2">
        <input type="radio" name="enabled" value="1"  <?php if($info['enabled'] == 1){?>checked="checked" <?php } ?>/>正常  
        <input type="radio" name="enabled" value="0" <?php if($info['enabled'] == 0){?>checked="checked" <?php } ?>/>停用
      </td>
    </tr>
    <tr>
      <td>
        <input type="hidden" name="id" value="<?=$info['id']?>">
        <input type="submit" name="Submit" value="提交">
      </td>
      <td colspan="2">&nbsp;</td>
    </tr>
</table>
</form>
</body>
</html>

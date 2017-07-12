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
  <li><a href="<?=base_url()?>index.php?d=home&c=member">员工列表</a></li>
  <li>修改</li>
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
        <td class="tableleft">真实姓名</td>       
       <td colspan="2">
         <input type="text" name="realname" value="<?=$info['realname']?>"><span class="label label-danger">必填</span>
       </td>
  </tr>
  <tr>
        <td class="tableleft">角色</td>       
       <td colspan="2">
         <select name="roleid">
          <option value="0" >==用户角色==</option>
          <option value="1" <?php if($info['roleid']==1){ ?> selected <?php } ?>>员工</option>
          <option value="2" <?php if($info['roleid']==2){ ?> selected <?php } ?>>专家</option>
          <option value="3" <?php if($info['roleid']==3){ ?> selected <?php } ?>>领导</option>
     </select><span class="label label-danger">必填</span>
       </td>
  </tr>

  <tr>
        <td class="tableleft">分配专家</td>       
       <td colspan="2">
        <?php
			foreach($experts as $k => $v){
		?>
         <input type="checkbox" name="exid[]" value="<?=$v['id']?>" <?php if(in_array($v['id'],$exid)){?>checked="checked"<?php } ?>><?=$v['realname']?>
		 <?php
		 	}
		 ?>
             </td>
  </tr>
      <tr>
      <td class="tableleft">头像</td>
      <td colspan="2">
        <input type="file" name="userfile"><img src="<?=base_url()?>uploads/member/header/<?=$info['headerurl']?>" width="40px" height="40px" />
		<input type="hidden" id="fileimg" name="fileimg" value="<?=$info['headerurl']?>">
      </td>
    </tr>
        <tr>
        <td class="tableleft">密码</td>       
       <td colspan="2">
         <input type="password" name="passwd">(修改时输入)
       </td>
  </tr>
   <tr>
        <td class="tableleft">手机号</td>       
       <td colspan="2">
         <input type="text" name="mobile" value="<?=$info['mobile']?>"><span class="label label-danger">必填</span>
       </td>
  </tr>
  <tr style="display:none;">
        <td class="tableleft">性别</td>       
       <td colspan="2">
         <input type="radio" name="sex"  value="1" <?php if($info['sex'] == 1){ ?> checked="checked"<?php } ?>>男
		 <input type="radio" name="sex"  value="0" <?php if($info['sex'] == 0){ ?> checked="checked"<?php } ?>>女
       </td>
  </tr>
   <tr>
        <td class="tableleft">单位</td>       
       <td colspan="2">
         <input type="text" name="company" value="<?=$info['company']?>"><span class="label label-danger">必填</span>
       </td>
  </tr>
   <tr style="display:none;">
        <td class="tableleft">邮箱</td>       
       <td colspan="2">
         <input type="text" name="email" value="<?=$info['email']?>">
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
				<option value="<?=$dv['id']?>" <?php if($info['depid'] == $dv['id']){ ?> selected <?php } ?>><?=$dv['dep_name']?></option>
        <?php
      }
        ?>
		 </select><span class="label label-danger">必填</span>
       </td>
  </tr>

         <tr>
        <td class="tableleft">专业</td>       
       <td colspan="2">
         <input type="text" name="profession" value="<?=$info['profession']?>">
       </td>
  </tr>
           <tr style="display:none;">
        <td class="tableleft">行业</td>       
       <td colspan="2">
         <input type="text" name="industry" value="<?=$info['industry']?>">
       </td>
  </tr>
<tr>
        <td class="tableleft">职位</td>       
       <td colspan="2">
         <select name="zhiwei">
		 	<option value="0">==选择职位==</option>
      <?php
        foreach($jobs as $dk => $dv){
      ?>
        <option value="<?=$dv['id']?>"  <?php if($info['zhiwei'] == $dv['id']){ ?> selected <?php } ?>><?=$dv['dep_name']?></option>
        <?php
      }
        ?>
		 </select><span class="label label-danger">必填</span>
       </td>
  </tr>
    <tr>
      <td class="tableleft">简介</td>
      <td colspan="2">
        <textarea name="intro"><?=$info['intro']?></textarea>
      </td>
    </tr>
    <tr>
      <td class="tableleft">帐号状态</td>
      <td colspan="2">
        <input type="radio" name="enabled" value="1"  <?php if($info['enabled'] == 1){?>checked="checked" <?php } ?>/>正常  
        <input type="radio" name="enabled" value="0" <?php if($info['enabled'] == 0){?>checked="checked" <?php } ?>/>停用
      </td>
    </tr>
    <tr>
      <td class="tableleft">
        <input type="hidden" name="id" value="<?=$info['id']?>">
       <input type="hidden" name="typeid" value="<?=$info['roleid']?>">
        <input type="submit" name="Submit" value="提交" class="btn btn-default">
      </td>
      <td colspan="2">&nbsp;</td>
    </tr>
</table>
</form>
</body>
</html>

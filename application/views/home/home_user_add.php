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
<script  type="text/javascript" src="<?=base_url() ?>static/js/My97DatePicker/WdatePicker.js"></script>
<body>


<form method="post" action="<?=base_url()?>index.php?d=home&c=user&m=add" enctype="multipart/form-data">
<table width="511" class="table table-bordered table-hover definewidth m10">
    <thead>
    <tr>

        <th width="64"></th>
        <th width="332"></th>
		<th width="99"></th>
    </tr>
    </thead>
    <tr>
        <td class="tableleft">名称</td>       
        <td colspan="2">
         <input type="text" name="txt_name" id="txt_name">        </td>
	</tr>
	 <tr>
        <td class="tableleft">邮箱</td>       
        <td colspan="2">
         <input type="text" name="txt_email" id="txt_email">       </td>
	</tr>
       <tr>
        <td class="tableleft">密码</td>       
        <td colspan="2">
         <input type="text" name="txt_pwd" id="txt_pwd">       </td>
	</tr>
	<tr>
        <td class="tableleft">所属角色</td>       
        <td colspan="2">
    	 <select name="txt_role" id="txt_role">
            <?php
              foreach($rolelist as $k => $v){
            ?>
            <option value="<?=$v['rid']?>"><?=$v['name']?></option>
            <?php
              }
            ?>
         </select>     
		 
	    </td>
	</tr>
	<tr>
        <td class="tableleft">注册会员人数</td>       
        <td colspan="2">
         <input type="text" name="txt_usernum"  id="txt_usernum"  value="1"></td>
	</tr>
	<tr>
        <td class="tableleft">域名</td>       
        <td colspan="2">
         <input type="text" name="txt_domain"  id="txt_domain" >(格式如:http://dewei.gumei.com/)    </td>
	</tr>
	<tr>
        <td class="tableleft">过期日期</td>       
        <td colspan="2">
         <input type="text" name="txt_date"  id="txt_date" onFocus="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm'})">       </td>
	</tr>
	
    <tr>
      <td class="tableleft">
	  
        <input type="submit" name="Submit" value="提交" onClick="return checkAllInputData()">      </td>
      <td colspan="2">&nbsp;</td>
    </tr>
</table>
</form>
<script language="javascript" type="text/javascript">
	function checkAllInputData(){
 		 var txt_name = $("#txt_name").val();
		 if(txt_name.length == 0){
		 	alert('请输入名称');
			return false;
		 }
		 var txt_email = $("#txt_email").val();
		 if(txt_email.length == 0){
		 	alert('请输入邮箱');
			return false;
		 }
		 var txt_pwd = $("#txt_pwd").val();
		 if(txt_pwd.length == 0){
		 	alert('请输入密码');
			return false;
		 }
		 var txt_date = $("#txt_date").val();
		 if(txt_date.length == 0){
		 	alert('请选择过期时间');
			return false;
		 }
		 if(txt_usernum.length == 0){
		 	alert('请输入注册会员人数');
			return false;
		 }
		 if(txt_domain.length == 0){
		 	alert('请输入域名');
			return false;
		 }
	}

</script>
</body>
</html>

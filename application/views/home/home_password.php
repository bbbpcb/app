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

function changepwd(){
	var oldpwd = $("#oldpwd").val();
	var newpwd = $("#newpwd").val()
	var renewpwd = $("#renewpwd").val();
	if(oldpwd != '' && newpwd != '' && renewpwd != ''){
			$.ajax({
					url : 'index.php?d=home&c=password',
					data : {oldpwd:oldpwd,newpwd:newpwd,renewpwd:renewpwd},
					type : 'post',
					success : function(data) {
							if(data == 1){
								alert('密码修改成功!');
								oldpwd = $("#oldpwd").val('');
								newpwd = $("#newpwd").val('')
								renewpwd = $("#renewpwd").val('');						
							}else{
								 alert(data);
							}
					}
									
			});
	}else{
		alert('信息填写不完整');
	}
}

</script>

<body>


<form name="form1" method="post" action="<?=base_url()?>index.php?d=home&c=password">
<table class="table table-bordered table-hover definewidth m10">
    <thead>
    <tr>

        <th colspan="2">&nbsp;</th>
      </tr>
    </thead>


    <tr>
       
        <td>原密码:</td>
        <td>
          <input type="password" name="oldpwd" id="oldpwd">
          </td>
    </tr>
    <tr>
       
        <td>新密码:</td>
        <td>
          <input type="password" name="newpwd" id="newpwd">
        </td>
    </tr>
	    <tr>
       
        <td>再次输入新密码:</td>
        <td><label>
          <input type="password" name="renewpwd" id="renewpwd">
          </label></td>
    </tr>

    <tr>

        <td colspan="2"><label>
          <input type="button" name="Submit" value="提交" onClick="changepwd();">
        </label></td>
      </tr>
</table>
</form>
</body>
</html>

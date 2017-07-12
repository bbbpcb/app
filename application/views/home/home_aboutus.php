<?php Widget::head();?>
<link rel="stylesheet" href="<?=base_url()?>static/kindeditor/themes/default/default.css" />
<link rel="stylesheet" href="<?=base_url()?>static/kindeditor/plugins/code/prettify.css" />
<script charset="utf-8" src="<?=base_url()?>static/kindeditor/kindeditor.js"></script>
<script charset="utf-8" src="<?=base_url()?>static/kindeditor/lang/zh_CN.js"></script>
<script charset="utf-8" src="<?=base_url()?>static/kindeditor/plugins/code/prettify.js"></script>
<script>
		KindEditor.ready(function(K) {
			var editor1 = K.create('textarea[name="newsContent"]', {
				cssPath : '<?=base_url()?>static/kindeditor/plugins/code/prettify.css',
				uploadJson : '<?=base_url()?>static/kindeditor/php/upload_json.php',
				fileManagerJson : '<?=base_url()?>static/kindeditor/php/file_manager_json.php',
				allowFileManager : true,
				filterMode: true,//是否开启过滤模式

			});
			prettyPrint();
		});
</script>

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
  <li><a href="<?=base_url()?>index.php?d=home&c=aboutus">关于我们</a></li>
  <li>修改</li>
</ol>

<form name="form1" method="post" action="<?=base_url()?>index.php?d=home&c=aboutus" enctype="multipart/form-data">
<table width="511" class="table table-bordered table-hover definewidth m10">
    <thead>
    <tr>

        <th width="64"></th>
        <th width="332"></th>
		<th width="99"></th>
    </tr>
    </thead>
    <tr>
      <td class="tableleft">说明</td>
      <td colspan="2">
   <!-- <?=$fcf?>-->
    <textarea name="content" class="form-control" rows="4"><?=$info['content']?></textarea>
    </td>
    </tr>

    <tr>
        <td class="tableleft">官网</td>       
       <td colspan="2"><label>
         <input type="text" name="website" value="<?=$info['website']?>">
       </label></td>
	</tr>
      <tr>
        <td class="tableleft">联系电话</td>       
       <td colspan="2"><label>
         <input type="text" name="tel" value="<?=$info['tel']?>">
       </label></td>
  </tr>

        <tr>
      <td class="tableleft">版本号</td>
      <td colspan="2"><label>
        <input type="text" name="version" value="<?=$info['version']?>">
      </label></td>
    </tr>
    
    <tr>
      <td>
	 
        <input type="submit" name="Submit" value="提交" class="btn btn-default">      </td>
      <td colspan="2">&nbsp;</td>
    </tr>
</table>
</form>
</body>
</html>

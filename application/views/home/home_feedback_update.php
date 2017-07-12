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
  <li><a href="<?=base_url()?>index.php?d=home&c=aboutsys">意见反馈</a></li>
  <li>添加</li>
</ol>

<form name="form1" method="post" action="<?=base_url()?>index.php?d=home&c=feedback&m=add" enctype="multipart/form-data">
<table width="511" class="table table-bordered table-hover definewidth m10">
    <thead>
    <tr>

        <th width="64"></th>
        <th width="332"></th>
		<th width="99"></th>
    </tr>
    </thead>



    <tr>
      <td class="tableleft">内容</td>
      <td colspan="2">
	 <!-- <?=$fcf?>-->
	  <textarea name="content" class="form-control" rows="4"><?=$info['content']?></textarea>
	  </td>
    </tr>


    
    <tr>
      <td>
	     <input type="hidden" name="id" value="<?=$info['id']?>" />
        <input type="submit" name="Submit" value="提交" class="btn btn-default">      </td>
      <td colspan="2">&nbsp;</td>
    </tr>
</table>
</form>
</body>
</html>

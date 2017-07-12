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
  <li>问题箱-专家回复</li>
  
</ol>

<form name="form2" method="post" action="<?=base_url()?>index.php?d=home&c=aboutsys&m=rank">
<table class="table table-bordered table-hover definewidth m10">
    <thead>
    <tr>

        <th>ID</th>      
        <th>用户</th>
        <th>问题</th>
        
        <th>管理操作</th>
    </tr>
    </thead>
	<?php
		foreach($list as $k => $v){
	?>
    <tr>
	 	<td><?=$v['id']?></td>   
    <td><?=$v['realname']?></td>      
		<td><?=$v['content']?></td>    
              
        <td width="113" valign="middle">
          <!--<a href="<?=base_url()?>index.php?d=home&c=question&m=update&id=<?=$v['id']?>">编辑</a> | -->
            
            <a href="javascript:void(0);" onClick="flush('删除后不能恢复，确定删除吗?','<?=base_url()?>index.php?d=home&c=question&m=del_reply&id=<?=$v['id']?>&qid=<?=$qid?>');">删除</a> 
          </td>
    </tr>
	<?php
		}
	?>
    <tr>
      
	 	<td colspan="5"><?=$page?></td>   
    </tr>
	</table>
</form>
</body>
</html>

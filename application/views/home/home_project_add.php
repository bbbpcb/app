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
  <li><a href="<?=base_url()?>index.php?d=home&c=project">项目列表</a></li>
  <li>添加项目</li>
</ol>

<form method="post" action="<?=base_url()?>index.php?d=home&c=project&m=add" enctype="multipart/form-data">
<table width="511" class="table table-bordered table-hover definewidth m10">
    <thead>
    <tr>

        <th width="64"></th>
        <th width="332"></th>
    <th width="99"></th>
    </tr>
    </thead>


    <tr>
        <td class="tableleft">项目名称</td>       
       <td colspan="2">
         <input type="text" name="title"  id="title">
       </td>
  </tr>
      <tr>
        <td class="tableleft">项目类型</td>       
       <td colspan="2">
         <select name="typeid" id="typeid">
            <option value="0">=项目类型=</option>
            <option value="1">重大项目</option>
            <option value="2">基础项目</option>
         </select>
       </td>
  </tr>
        <tr>
        <td class="tableleft">创建人</td>       
       <td colspan="2">
          <?php
            foreach($member as $k => $v){
          ?>
          <input type="radio" name="mid" value="<?=$v['id']?>" <?php if($k ==0){ ?> checked="checked" <?php } ?>/><?=$v['realname']?>
          <span class="label label-danger">
            <?php
              if($v['roleid'] == 1){
                echo '员工';
              }elseif($v['roleid'] == 2){
                echo '专家';
              }elseif($v['roleid'] == 3){
                echo '领导';
              }else{
                echo '未知';
              }
            ?>
          </span>     
          <?php
            }
          ?>
       </td>
  </tr>
  <tr>
        <td class="tableleft">负责人</td>       
       <td colspan="2">
                    <?php
            foreach($member as $k => $v){
          ?>
          <input type="radio" name="headid" value="<?=$v['id']?>"  <?php if($k == 0){ ?> checked="checked" <?php } ?>/><?=$v['realname']?>
          <span class="label label-danger">
            <?php
              if($v['roleid'] == 1){
                echo '员工';
              }elseif($v['roleid'] == 2){
                echo '专家';
              }elseif($v['roleid'] == 3){
                echo '领导';
              }else{
                echo '未知';
              }
            ?>
          </span>     
          <?php
            }
          ?>
       </td>
  </tr>


      <tr>
      <td class="tableleft">规模</td>
      <td colspan="2">
        <select name="scale" id="scale">
            <option value="0">=规模=</option>
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">5</option>
         </select>
      </td>
    </tr>
        <tr>
        <td class="tableleft">难度</td>       
       <td colspan="2">
          <select name="difficulty" id="difficulty">
            <option value="0">=难度=</option>
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">5</option>
         </select>
       </td>
  </tr>
   <tr>
        <td class="tableleft">质量</td>       
       <td colspan="2">
          <select name="quality" id="quality"> 
            <option value="0">=质量=</option>
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">5</option>
         </select>
       </td>
  </tr>
     <tr>
      <td class="tableleft">特性</td>       
       <td colspan="2">
          <select name="features" id="features">
            <option value="0">=特性=</option>
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4" >4</option>
            <option value="5">5</option>
         </select>
       </td>
  </tr>
   <tr>
        <td class="tableleft">简介</td>       
       <td colspan="2">
         <textarea name="intro" class="form-control" rows="3"></textarea>
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
      
        <input type="submit" name="Submit" value="提交" class="btn btn-default" onclick="return checkAllInputData()">
      </td>
      <td colspan="2">&nbsp;</td>
    </tr>
</table>
</form>

<script language="javascript" type="text/javascript">
	function checkAllInputData(){
 		 var title = $("#title").val();
		 if(title.length == 0){
		 	alert('请输入项目名称');
			return false;
		 }
		 var typeid = $("#typeid").val();
		 if(typeid == 0){
		 	alert('请选择项目类型');
			return false;
		 }
		 var scale = $("#scale").val();
		 if(scale == 0){
		 	alert('请选择规模');
			return false;
		 }
		 var difficulty = $("#difficulty").val();
		 if(difficulty == 0){
		 	alert('请选择难度');
			return false;
		 }
		 var quality = $("#quality").val();
		 if(quality == 0){
		 	alert('请选择质量');
			return false;
		 }
		 var features = $("#features").val();
		 if(features == 0){
		 	alert('请选择特性');
			return false;
		 }
	}

</script>

</body>
</html>

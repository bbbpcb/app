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



    <div style=" margin-top:15px;"> 
        <!-- Nav tabs -->
        <ul class="nav nav-tabs" role="tablist">
          <li <?php if($tab == 'home'){ ?>class="active" <?php } ?> ><a href="#home" role="tab" data-toggle="tab">立项与策划</a></li>
          <li <?php if($tab == 'profile'){ ?>class="active" <?php } ?>><a href="#profile" role="tab" data-toggle="tab">问题与解决</a></li>
          <li <?php if($tab == 'messages'){ ?>class="active" <?php } ?>><a href="#messages" role="tab" data-toggle="tab">结果与反思</a></li>

        </ul>

        <!-- Tab panes -->
        <div class="tab-content">
          <div class="tab-pane <?php if($tab == 'home'){ ?>active<?php } ?>" id="home">

              <form name="form2" method="post" action="<?=base_url()?>index.php?d=dandy&c=manager&m=update&act=images&tab=home">
              <table width="511" class="table table-bordered table-hover definewidth m10">
                  <thead>
                  <tr>
					<th width="64">ID</th>
                      <th>员工</th>
                      <th>解决内容 </th>
                  	<th></th>
                  </tr>
				  
                  </thead>
				  
                  <?php
                    foreach($cehua as $k => $v){
                  ?>
                  <tr>
                    <td><?=$v['id']?></td>
                    <td > <?=$v['realname']?></td>
					 <td > <?=$v['content']?></td>
                      <td>
                       <a href="<?=base_url()?>index.php?d=home&c=execution&m=update&id=<?=$v['id']?>&tab=home">修改</a> | 
						
           			 <a href="javascript:void(0);" onClick="flush('删除后不能恢复，确定删除吗?','<?=base_url()?>index.php?d=home&c=execution&m=del&id=<?=$v['id']?>');">删除</a> |

                 <a href="javascript:void(0);" data-toggle="modal" data-target=".bs-example-modal-lg">专家解答</a>
                       </td>
                  </tr>
                  <?php
                    }
                  ?>


                  <tr>
                

                    </td>
                      <td colspan="4">

                       </td>
                  </tr>
              </table>
			  </form>
          </div>


          <div class="tab-pane <?php if($tab == 'profile'){ ?>active<?php } ?> " id="profile">

            <!--添加图片 -->
            <form name="form2" method="post" action="<?=base_url()?>index.php?d=dandy&c=manager&m=update&act=music&tab=profile">
              <table width="511" class="table table-bordered table-hover definewidth m10">
                  <thead>
                  <tr>
          <th width="64">ID</th>
                      <th>员工</th>
                      <th>问题 </th>
                    <th></th>
                  </tr>
          
                  </thead>
          
                  <?php
                    foreach($wenti as $k => $v){
                  ?>
                  <tr>
                    <td><?=$v['id']?></td>
                    <td > <?=$v['realname']?></td>
           <td > <?=$v['content']?></td>
                      <td>
                       <a href="<?=base_url()?>index.php?d=home&c=execution&m=update&id=<?=$v['id']?>&tab=home">修改</a> | 
            
                 <a href="javascript:void(0);" onClick="flush('删除后不能恢复，确定删除吗?','<?=base_url()?>index.php?d=home&c=execution&m=del&id=<?=$v['id']?>');">删除</a> |

                 <a href="javascript:void(0);" data-toggle="modal" data-target=".bs-example-modal-lg">专家解答</a>
                       </td>
                  </tr>
                  <?php
                    }
                  ?>


                  <tr>
                

                    </td>
                      <td colspan="4">

                       </td>
                  </tr>
              </table>
            </form>
          </div>
		  
		      <div class="tab-pane <?php if($tab == 'messages'){ ?>active<?php } ?> " id="messages">

            <!--添加图片 -->
            <form name="form2" method="post" action="<?=base_url()?>index.php?d=dandy&c=manager&m=update&act=music&tab=profile">
              <table width="511" class="table table-bordered table-hover definewidth m10">
                  <thead>
                  <tr>
                      <th>ID</th>
                      <th>员工</th>
                      <th>完成情况 </th>
                      <th>实际费用 </th>
                       <th>实际天数 </th>
                       <th>得分 </th>
                      <th></th>
                  </tr>
          
                  </thead>
          
                  <?php
                    foreach($fansi as $k => $v){
                  ?>
                  <tr>
                    <td><?=$v['id']?></td>
                    <td > <?=$v['realname']?></td>
                    <td > <?=$v['qingkuang']?></td>
                    <td > <?=$v['feiyong']?></td>
                    <td > <?=$v['tianshu']?></td>
                    <td > <?=$v['total']?></td>
                      <td>
                       <a href="<?=base_url()?>index.php?d=home&c=execution&m=update&id=<?=$v['id']?>&tab=home">修改</a> | 
            
                 <a href="javascript:void(0);" onClick="flush('删除后不能恢复，确定删除吗?','<?=base_url()?>index.php?d=home&c=execution&m=del&id=<?=$v['id']?>');">删除</a> |

                 <a href="javascript:void(0);" data-toggle="modal" data-target=".bs-example-modal-lg">专家解答</a>
                       </td>
                  </tr>
                  <?php
                    }
                  ?>


                  <tr>
                

                   
                      <td colspan="7">

                       </td>
                  </tr>
              </table>
            </form>
          </div>

    </div>
<!-- Large modal -->

<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
          <table class="table table-bordered table-hover definewidth m10">
        <thead>
        <tr>

            <th>专家姓名</th>      
            <th>头像</th>
            <th>内容</th>
            <th>管理操作</th>
        </tr>
        </thead>
        <?php
          foreach($task_plan_reply as $k => $v){
        ?>
        <tr>
        <td><?=$v['realname']?></td>   
        <td><img src="<?=base_url()?>uploads/member/header/<?=$v['headerurl']?>" width="60px" height="60px"/></td>      
        <td><?=$v['content']?></td>    
        
        <td width="113" valign="middle">
              <a href="javascript:void(0);">删除</a>
        </td>
        </tr>
     <?php
    }
     ?>
        <tr>
          
        <td colspan="5"></td>   
        </tr>
      </table>
    </div>
  </div>
</div>


<script>
  function delpic(id)
  {
    $("#"+id).remove();
  }
</script>
</body>
</html>

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
<nav class="navbar navbar-default" role="navigation">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        

      </ul>


    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>
<ol class="breadcrumb">
  <li><a href="<?=base_url()?>index.php?d=home&c=backupdb&m=bak">备份</a></li>
  
</ol>

<form name="form2" method="post" action="<?=base_url()?>index.php?d=home&c=aboutsys&m=rank">
<table class="table table-bordered table-hover definewidth m10">
    <thead>
    <tr>

        <th>表名</th>      

    </tr>
    </thead>
	<?php
		foreach($list as $k => $v){
	?>
    <tr>
	 	<td><?=$v?></td>   

    </tr>
	<?php
		}
	?>
    <tr>
      
	 	<td></td>   
    </tr>
	</table>
</form>
</body>
</html>

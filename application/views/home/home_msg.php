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
<table class="table table-bordered table-hover definewidth m10">
    <thead>
    <tr>
        <th><font color="#FF0000">消息</font></th>
      </tr>
    </thead>

    <tr>
        <td>
		<?=$msg?>
		</td>
    </tr>
</table>


</body>
</html>

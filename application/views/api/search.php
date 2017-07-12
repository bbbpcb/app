<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="maximum-scale=1.0,minimum-scale=1.0,user-scalable=0,width=device-width,initial-scale=1.0">
<title>APP</title>
<link rel="stylesheet" type="text/css" href="<?=base_url()?>static/api/css/aui.css">
<link rel="stylesheet" type="text/css" href="<?=base_url()?>static/api/css/aui-slide.css" />
<link rel="stylesheet" type="text/css" href="<?=base_url()?>static/api/css/styles.css" />
<script type="text/javascript" src="<?=base_url()?>static/api/script/jquery.js"></script>
 
</head>
<body>
<header class="aui-bar aui-bar-nav aui-bar-warning" id="aui-header"> 
 <a class="aui-pull-left aui-btn" href="<?=base_url()?>"> <span class="aui-iconfont aui-icon-home"></span> </a>

 <div class="aui-searchbar" id="search">
    <div class="aui-searchbar-input aui-border-radius" tapmode > <i onClick="doSearch()" class="aui-iconfont aui-icon-search"></i>
      <form action="javascript:search();">
        <input type="search" placeholder="请输入搜索内容" id="search-input">
      </form>
    </div>
    
    </div>
 <a class="aui-btn aui-btn-warning aui-pull-right" href="javascript:;" id="menu" >
  <i class="aui-iconfont aui-icon-my"></i>
   </a> 
   
   
 </header>
<section id="wrap">

 <ul class="aui-list aui-list-in">
 
            
           
 </ul>
  
  
</section>




<?php  $this->load->view('/api/inc/footer.php') ?>

<script type="text/javascript" src="<?=base_url()?>static/api/script/api.js"></script> 
<script type="text/javascript" src="<?=base_url()?>static/api/script/aui-slide.js"></script> 

<script type="text/javascript">
 function doSearch(){
 var  title = $("#search-input").val();
 var  company_id=1;
 var url="<?=base_url()?>index.php?d=api&c=index&m=seach";
 var data ={title:title,company_id:company_id};
 var html='';
 
  $.post(url, data,
                   function(res) {
                   var res = jQuery.parseJSON(res);
				    if (res.errcode < 0) {
						  toast.fail({
                             title: res.errmsg,
                             duration: 2000
                                      });
							 return;
                             } else { 
							 
							    $.each(res.data,
            function(index, el) {
			    html +='<li class="aui-list-item aui-list-item-middle">';
                html +='<div class="aui-list-item-inner aui-list-item-arrow">';
				if(el['type'] == 1){ 
				html +='<a href="<?=base_url()?>?d=api&c=project&m=detail&proid='+el['id']+'">';
				}else if(el['type'] == 2){ 
				html +='<a href="<?=base_url()?>?d=api&c=project&m=detail&proid='+el['id']+'">';
				}else{
				html +='<a href="<?=base_url()?>index.php?d=api&c=conquer&m=conquer_detail&cid='+el['id']+'">';	
					}
                html +=''+el['title']+'';
				html +='</a>';
                html +='</div></li>';
			
			           })  
				 $('.aui-list').html(html);	 
				              }
	   })
 
 }

</script>
<?php  $this->load->view('/api/inc/menu.php') ?>
</body>
</html>

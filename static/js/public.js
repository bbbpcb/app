// JavaScript Document
/**
 * 公共地区类
 */
$(function(){ 
	if ($("#vmod").length > 0 && $("#vmod").val() != '0') { 
		bind_Info('t_typemod','1',$("#vmod").val(),'1');
		bind_Info('t_typemod1',$("#vmod").val(),$("#vtype").val(),'2');
	}else{
		bind_Info('t_typemod','1');
	}   
	
	
	$("#t_typemod").change(function(){
		change_province(this);
	});
		   
})

function bind_Info(control_name,pid){
    var jsonData  =  get_info('1');
	if(jsonData != null && jsonData.list != null && jsonData.list.length > 0){
        var content = [];
		content.push('<option value="">-模块类型-</option>');
		
		for(var i = 0;i<jsonData.list.length;i++){
		    content.push('<option value="'+jsonData.list[i].region_id+'">'+jsonData.list[i].region_name+'</option>');
		}
		
		$("#"+control_name).empty().append(content.join(''));
	}
}

function get_info(pid){ 
	var jsonData = null;
	jQuery.ajax({
		 type:'post',
		 url: hostname + '/index.php?d=home&c=task&m=get_modtype',
		 data:{'mid':pid},
		 dataType:'json',
		 cache:false,
		 async:false,
		 success:function(data){
		     jsonData = data;            
		 },
		 error:function(){
			 alert("error!!!");
		 }
	 });
	return jsonData;
}

function change_province(obj){
   var pId = jQuery.trim($("#"+obj.id).val());
   if(pId != ''){
        var jsonData  =  get_info(pId);
		if(jsonData != null && jsonData.list != null && jsonData.list.length > 0){
            var content = [];
			for(var i = 0;i<jsonData.list.length;i++){
			    content.push('<option value="'+jsonData.list[i].id+'">'+jsonData.list[i].type_name+'</option>');
			}
			$("#"+obj.id+'1').empty().append(content.join(''));
		}else{
			$("#"+obj.id+'1').empty().append('<option value="">-项目类型-</option>');	
		}
   }else{
	   $("#"+obj.id+'1').empty().append('<option value="">-项目类型-</option>');
   }
}

function bind_Info(control_name,pid,ownId,type){
	var t = '';
	if (type==1) {t= '模块类型';};
	if (type==2) {t= '项目类型';};
	var jsonData  =  get_info(pid);
	if(jsonData != null && jsonData.list != null && jsonData.list.length > 0){
        var content = [];
		content.push('<option value="">-'+ t +'-</option>');
		for(var i = 0;i<jsonData.list.length;i++){
			if (jsonData.list[i].id == ownId) {
				content.push('<option value="'+jsonData.list[i].id+'" selected>'+jsonData.list[i].type_name+'</option>');
			}else{
				content.push('<option value="'+jsonData.list[i].id+'">'+jsonData.list[i].type_name+'</option>');
			}
		}
		
		$("#"+control_name).empty().append(content.join(''));
	}
}

<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="maximum-scale=1.0,minimum-scale=1.0,user-scalable=0,width=device-width,initial-scale=1.0">
<title>APP</title>
<link rel="stylesheet" type="text/css" href="<?=base_url()?>static/api/css/aui.css">
<link rel="stylesheet" type="text/css" href="<?=base_url()?>static/api/css/aui-slide.css" />
<link rel="stylesheet" type="text/css" href="<?=base_url()?>static/api/css/styles.css" />
<script type="text/javascript" src="<?=base_url()?>static/api/script/jquery.js"></script>
<script type="text/javascript" src="<?=base_url()?>static/api/script/layer.js"></script>
</head>

<body>
<section id="main"> </section>
<section id="main-info">
  <header class="aui-bar aui-bar-nav aui-bar-warning" id="aui-header"> <a class="aui-pull-left aui-btn abs" href="javascript:;window.history.go(-1)"> <span class="aui-iconfont aui-icon-left"></span> </a>
    <?=$_GET['proid']?'修改':'创建'?>
    <?php if($_GET['proid']){?>
    <a class="aui-pull-right aui-btn" href="javascript:;" onClick="delproject(<?=$proinfo['id']?>)">删除</a>
    <?php } ?>
  </header>
  <section id="wrap" class="pro-det">
    <div class="page-main">
      <div class="from-main">
        <div class="list"> <span class="name">创建项目标题</span>
          <input type="text" class="inp" value="<?=$proinfo['title']?>" name="title" id="title" placeholder="请输入标题名" />
        </div>
        <div class="list"> <span class="name">创建项目描述</span>
          <input type="text" class="inp" value="<?=$proinfo['intro']?>" name="intro" id="intro" placeholder="请输入项目描述" />
        </div>
        <div class="list">
          <input type="hidden" value="<?=$proinfo['headid']?>" id="headid" />
          <span class="name">请选择项目负责人</span>
          <?php if($_GET['proid']){?>
          <span class="choo">
          <?=$proinfo['header']?>
          &nbsp;></span>
          <?php }else{ ?>
          <span class="choo"> 点击选择&nbsp;></span>
          <?php } ?>
        </div>
        <div class="list start scale"> <span class="name">规模</span>
          <input type="hidden" value="<?=$proinfo['scale']?>" id="scale">
          <?php for($i=1;$i<=5;$i++){?>
          <div class="aui-col-xs-1"> <i data-id="<?=$i?>" <?=$i<=$proinfo['scale']?'style="color: rgb(252, 0, 0);"':''?> class="aui-iconfont aui-icon-star"></i> </div>
          <?php } ?>
        </div>
        <div class="list start difficulty"> <span class="name">难度</span>
          <input type="hidden" value="<?=$proinfo['difficulty']?>" id="difficulty">
          <?php for($i=1;$i<=5;$i++){?>
          <div class="aui-col-xs-1"> <i data-id="<?=$i?>" <?=$i<=$proinfo['difficulty']?'style="color: rgb(252, 0, 0);"':''?> class="aui-iconfont aui-icon-star"></i> </div>
          <?php } ?>
        </div>
        <div class="list start quality"> <span class="name">质量</span>
          <input type="hidden" value="<?=$proinfo['quality']?>" id="quality">
          <?php for($i=1;$i<=5;$i++){?>
          <div class="aui-col-xs-1"> <i data-id="<?=$i?>" <?=$i<=$proinfo['quality']?'style="color: rgb(252, 0, 0);"':''?> class="aui-iconfont aui-icon-star"></i> </div>
          <?php } ?>
        </div>
        <div class="list start features"> <span class="name">特性</span>
          <input type="hidden" value="<?=$proinfo['features']?>" id="features">
          <?php for($i=1;$i<=5;$i++){?>
          <div class="aui-col-xs-1"> <i data-id="<?=$i?>" <?=$i<=$proinfo['features']?'style="color: rgb(252, 0, 0);"':''?> class="aui-iconfont aui-icon-star"></i> </div>
          <?php } ?>
        </div>
      </div>
    </div>
    <?php if($type==1){?>
    <section class="aui-chat" id="chat">
      <div class="send">
        <div class="aui-btn an aui-btn-block" id="basics">提交</div>
      </div>
    </section>
    <?php } ?>
    <?php if($type==2){?>
    <section class="aui-chat" id="chat">
      <div class="send">
        <div class="aui-btn an aui-btn-block" id="next">下一步</div>
        <div class="aui-btn an aui-btn-block" id="basics" style="display:none"></div>
      </div>
    </section>
    <?php } ?>
  </section>
</section>
<script type="text/javascript" src="<?=base_url()?>static/api/script/api.js"></script> 
<script type="text/javascript" src="<?=base_url()?>static/api/script/aui-toast.js" ></script> 
<script type="text/javascript" src="<?=base_url()?>static/api/script/jquery.js"></script> 
<script type="text/javascript">

var toast = new auiToast({})

 

 $(".choo").click(function(){

 $("#main-info").hide();

 $("#main").show();

  var url = "<?=base_url();?>index.php?d=api&c=userinfo&m=member_ajax_list";

  $("#main").load(url+" #member_list ",function(res){

    $(".aui-checkbox").click(function(){

	   var id = $(this).val();

	   var name = $(this).parents("li").find(".aui-font-size-16").html();

	   $("#main-info").show();

	   $("#main").hide();

	   $("#headid").val(id);

	   $(".choo").html(name+'&nbsp;>');

    })

  

  });

 })

 

 

 $(".scale .aui-icon-star").click(function(){

    var star =  $(this).attr("data-id");

       $(".scale .aui-icon-star").each(

            function(index, el) {

			if((index+1) <=  star ){

			 $(el).css("color","#fc0000");  

			}else{
			$(el).css("color","");  	
				}

			 });

	 $("#scale").val(star); 

	 

 })

 

 

  $(".difficulty .aui-icon-star").click(function(){

    var star =  $(this).attr("data-id");

       $(".difficulty .aui-icon-star").each(

            function(index, el) {

			if((index+1) <=  star ){

			 $(el).css("color","#fc0000");  

			}else{
			$(el).css("color","");  	
				}

			 });

	 $("#difficulty").val(star); 

	 

 })

 

  $(".quality .aui-icon-star").click(function(){

    var star =  $(this).attr("data-id");

       $(".quality .aui-icon-star").each(

            function(index, el) {

			if((index+1) <=  star ){

			 $(el).css("color","#fc0000");  

			}else{
			$(el).css("color","");  	
				}

			 });

	 $("#quality").val(star); 

	 

 })

 

  $(".features .aui-icon-star").click(function(){

    var star =  $(this).attr("data-id");

       $(".features .aui-icon-star").each(

            function(index, el) {

			if((index+1) <=  star ){

			 $(el).css("color","#fc0000");  

			}else{
			$(el).css("color","");  	
				}

			 });

	 $("#features").val(star); 

	 

 })

 

 $("#basics").click(function(){

 var title=$("#title").val();

 var intro=$("#intro").val();

 var headid=$("#headid").val();

 var scale =$("#scale").val(); 

 var difficulty=$("#difficulty").val(); 

 var quality =$("#quality").val(); 

 var features = $("#features").val(); 

 if(title.length<=0){

    alert('请输入项目标题');

	return ;

 }

 <?php if($_GET['proid']){?>

  var url = "<?=base_url();?>index.php?d=api&c=project&m=projectupdate";

  var proid = <?=$_GET['proid']?$_GET['proid']:0?>;

  var data={'proid':proid,'title':title,'intro':intro,'headid':headid,'scale':scale,'difficulty':difficulty,'quality':quality,'features':features,'typeid':1};

 <?php }else{?>

 var url = "<?=base_url();?>index.php?d=api&c=project&m=create_major";

  var data={'title':title,'intro':intro,'headid':headid,'scale':scale,'difficulty':difficulty,'quality':quality,'features':features,'typeid':1};

 <?php } ?>



  $.post(url, data,

    function(res) {

        var res = jQuery.parseJSON(res);

        if (res.errcode < 0) {

            toast.fail({

                title: res.errmsg,

                duration: 2000

            });

        } else {

		

		     toast.success({

			       <?php if($_GET['proid']){?>

				    title:"项目修改成功",

				   <?php }else{ ?>

                    title:"项目创建成功",

					<?php } ?>

					

                    duration:2000

                });

			 window.location.href="<?=base_url()?>index.php?d=api&c=project&ptype=own";

		 }

		 

		})

 

 })



 

function delproject(id){



  var url = "<?=base_url();?>index.php?d=api&c=project&m=projectdel";

  var data = {'proid':id};

   $.post(url, data,

    function(res) {

        var res = jQuery.parseJSON(res);

        if (res.errcode < 0) {

            toast.fail({

                title: res.errmsg,

                duration: 2000

            });

        } else {

		

		     toast.success({

			        

				    title:"项目删除成功",

				 

					

                    duration:2000

                });

			window.location.href="<?=base_url()?>index.php?d=api&c=project&ptype=own";

		 }

		 })

  

} 



$("#next").click(function() {

    var title = $("#title").val();

    var intro = $("#intro").val();

    var headid = $("#headid").val();

    var scale = $("#scale").val();

    var difficulty = $("#difficulty").val();

    var quality = $("#quality").val();

    var features = $("#features").val();

    if (title.length <= 0) {

        layer.open({

            content: '标题不能为空',

            skin: 'msg',

            time: 2 //2秒后自动关闭

        });

        return;

    }



    if (intro.length <= 0) {

        layer.open({

            content: '描述不能为空',

            skin: 'msg',

            time: 2 //2秒后自动关闭

        });

        return;

    }



    if (headid.length <= 0) {

        layer.open({

            content: '请选择负责人',

            skin: 'msg',

            time: 2 //2秒后自动关闭

        });

        return;

    }

    $("#main-info").hide();

    $("#main").html('');

    $("#main").show();

    var url = "<?=base_url();?>index.php?d=api&c=mod&company_id=1";

    $("#main").load(url + ".mod",

    function(res) {



        $("#baocun").click(function() {

            layer.open({

                content: '是否现在就保存该项目',

                btn: ['是', '不要'],

                yes: function(index) {

                    $("#basics").trigger("click");

                }

            });

        })



        $(".mod_list").click(function() {



            var modid = $(this).attr('data-id');



            $(".aui-pull-left").addClass("hides");

            $(".hides").attr("href", "javascript:;");



            $(".aui-pull-lef").click(function() {

                location.reload();

            })



            $("#main-info").hide();

            $("#main").show();



            var url = "<?=base_url();?>index.php?d=api&c=task&m=task_type";

            var data = {

                modid: modid

            };

            $("#main").load(url + "#task", data,

            function(res) {



                $(".addtask").click(function() { //添加单一任务

                    var title = $(this).siblings(".list").find(".title").val();

                    var task_type = $(this).siblings(".list").find(".task_typeid").val();

                    var intro = $(this).siblings(".list").find(".intro").val();

                    var scale = $(this).siblings(".list").find(".scales").val();

                    var difficulty = $(this).siblings(".list").find(".difficultys").val();

                    var quality = $(this).siblings(".list").find(".qualitys").val();

                    var features = $(this).siblings(".list").find(".featuress").val();

                    //先添加项目

                    var url = "<?=base_url();?>index.php?d=api&c=project&m=create_major";

                    var data = {

                        'title': title,

                        'intro': intro,

                        'headid': headid,

                        'scale': scale,

                        'difficulty': difficulty,

                        'quality': quality,

                        'features': features,

                        'typeid': 1

                    };



                    $.post(url, data,

                    function(res) {

                        var res = jQuery.parseJSON(res);

                        if (res.errcode < 0) {

                            toast.fail({

                                title: res.errmsg,

                                duration: 2000

                            });

                        } else {



                            var a = [{

                                title: title,

                                intro: intro,

                                task_type: task_type,

                                scale: scale,

                                quality: quality,

                                features: features,

                                difficulty: difficulty

                            }];



                            var url = "<?=base_url();?>index.php?d=api&c=project&m=create_task";

                            var pid =res.data.pid;

                            var datas = {

                                modid: modid,

                                proid: res.data.pid,

                                'task': a

                            };



                            $.post(url, datas,

                            function(res) {

                                var res = jQuery.parseJSON(res);

                                if (res.errcode < 0) {

                                    toast.fail({

                                        title: res.errmsg,

                                        duration: 2000

                                    });

                                } else {

                                    toast.success({

                                        title: "项目创建成功",

                                        duration: 2000

                                    });

                                    // location.reload();

                                    //window.history.go(-1); 

                                   // window.location.href = "<?=base_url();?>index.php?d=api&c=project&ptype=own";

								      window.location.href = "<?=base_url();?>index.php?d=api&c=project&m=detail&proid="+pid+"&t=task";



                                }



                            })



                        }



                    })

                })



                //多个任务

                $("#tasksub").click(function() {



                    var obj = [{

                        "title": '',

                        'intro': '',

                        'task_type': '',

                        'scales': '',

                        'difficultys': '',

                        'qualitys': '',

                        'featuress': ''

                    },

                    {

                        "title": '',

                        'intro': '',

                        'task_type': '',

                        'scales': '',

                        'difficultys': '',

                        'qualitys': '',

                        'featuress': ''

                    }];



                    $(".title").each(function(index, el) {

                        if ($(this).val()) {

                            obj[index]['title'] = $(this).val();

                        }



                    });



                    $(".intro").each(function(index, el) {

                        if ($(this).val()) {

                            obj[index]['intro'] = $(this).val();

                        }



                    });



                    $(".task_type").each(function(index, el) {

                        if ($(this).val()) {

                            obj[index]['task_type'] = $(this).val();

                        }



                    });



                    $(".scales").each(function(index, el) {

                        if ($(this).val()) {

                            obj[index]['scale'] = $(this).val();

                        }



                    });



                    $(".difficultys").each(function(index, el) {

                        if ($(this).val()) {

                            obj[index]['difficulty'] = $(this).val();

                        }



                    });



                    $(".qualitys").each(function(index, el) {

                        if ($(this).val()) {

                            obj[index]['quality'] = $(this).val();

                        }



                    });



                    $(".featuress").each(function(index, el) {

                        if ($(this).val()) {

                            obj[index]['features'] = $(this).val();

                        }



                    });

                      //先添加项目

                    var url = "<?=base_url();?>index.php?d=api&c=project&m=create_major";

                    var data = {

                        'title': title,

                        'intro': intro,

                        'headid': headid,

                        'scale': scale,

                        'difficulty': difficulty,

                        'quality': quality,

                        'features': features,

                        'typeid': 1

                    };



                    $.post(url, data,

                    function(res) {

                        var res = jQuery.parseJSON(res);

                        if (res.errcode < 0) {

                            toast.fail({

                                title: res.errmsg,

                                duration: 2000

                            });

                        } else {

				    var url = "<?=base_url();?>index.php?d=api&c=project&m=create_task";

                    var datas = {

                        modid: modid,

                        proid: res.data.pid,

                        'task': obj

                    };

					var pid =res.data.pid;



                    $.post(url, datas,

                    function(res) {

                        var res = jQuery.parseJSON(res);

                        if (res.errcode < 0) {

                            toast.fail({

                                title: res.errmsg,

                                duration: 2000

                            });

                        } else {

                            toast.success({

                                title: "任务创建成功",

                                duration: 2000

                            });

                            //location.reload();

                            //window.history.go(-1); 

							window.location.href = "<?=base_url();?>index.php?d=api&c=project&m=detail&proid="+pid+"&t=task";

							

                        }



                    })

					}

						})



                })



                //多个任务结束

            })



        })



    })



})

</script>
</body>
</html>

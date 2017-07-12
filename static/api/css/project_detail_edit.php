<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="maximum-scale=1.0,minimum-scale=1.0,user-scalable=0,width=device-width,initial-scale=1.0">
<title>APP</title>
<link rel="stylesheet" type="text/css" href="<?=base_url()?>static/api/css/aui.css">
<link rel="stylesheet" type="text/css" href="<?=base_url()?>static/api/css/aui-slide.css" />
<link rel="stylesheet" type="text/css" href="<?=base_url()?>static/api/css/styles.css" />
<link rel="stylesheet" type="text/css" href="<?=base_url()?>static/api/css/swiper.min.css" />
<script type="text/javascript" src="<?=base_url()?>static/api/script/jquery.js"></script>
<script type="text/javascript" src="<?=base_url()?>static/api/script/swiper.min.js"></script>
</head>

<body>
<header class="aui-bar aui-bar-nav aui-bar-warning" id="aui-header"> <a class="aui-pull-left aui-btn" href="javascript:history.go(-1);"> <span class="aui-iconfont aui-icon-left"></span> </a> <span class="toptitle">项目详情</span>
  <?php if($_GET['proid']){?>
  <a class="aui-pull-right aui-btn" id="topr" href="<?=base_url()?>?d=api&c=project&m=create_basics&proid=<?=$_GET['proid']?>"  >修改</a>
  <?php } ?>
</header>
<section id="wrap" class="pro-det">
  <div id="main"></div>
  <div class="page-info" id="main-info"> <img class="r-img" src="<?=base_url()?>static/api/images/project-<?=$projectinfo['status']?>.png" />
    <div class="aui-card-list aui-padded-b-15">
      <div class="aui-card-list-header">
        <h2>
          <?=$projectinfo['title']?>
        </h2>
        <div class="C"></div>
        <div class="little" > 规模:
          <?=$projectinfo['scale']?>
          难度:
          <?=$projectinfo['difficulty']?>
          质量:
          <?=$projectinfo['quality']?>
          特性:
          <?=$projectinfo['features']?>
          <span class="fzr">负责人：
          <?=$projectinfo['header']?>
          </span> </div>
      </div>
      <div class="C"></div>
      <div class="aui-card-list-content-padded cont">
        <?=$projectinfo['intro']?>
      </div>
    </div>
    <section class="aui-content pro_list">
      <?php foreach($modlist as $k=>$v){   ?>
      <div class="aui-card-list">
        <div class="aui-card-list-header">
          <?=$v['m_name']?>
          <span class="R">
          <?=$projectinfo['status']==3?'[已评审]':'[评审中]'?>
          </span> </div>
        <div class="aui-card-list-content swiper-container">
          <div class="aui-row aui-row-padded swiper-wrapper">
            <?php  if($v["task"]){ foreach($v["task"] as $k=>$val){  ?>
            <div class="aui-col-xs-6 swiper-slide task-info">
              <input type="hidden" value="<?=$val["taskid"]?>" class="taskid" />
              <input type="hidden" value="<?=$val["modid"]?>" class="modid" />
              <input type="hidden" value="<?=$val["user"]["roleid"]?>" class="roleid" />
              <div class="imgbox"> <img src="<?=$val['task_icon']?>">
                <div class="txt">
                  <h1>
                    <?=$val["task_type"]?>
                  </h1>
                  规模：
                  <?=$val["scale"]?>
                  难度：
                  <?=$val["difficulty"]?>
                </div>
              </div>
              <span class="title">
              <?= $val['title'] ?>
              </span>
              <?php  if($val["user"]["name"]){?>
              <span class="name">
              <?php if($val["user"]['roleid'] == 1 || $val["user"]['roleid'] == 0){

			echo '独立:';

			}?>
              <?php if($val["user"]['roleid'] == 2){

			echo '核心:';

			}?>
              <?php if($val["user"]['roleid'] == 3){

			echo '参与:';

			}?>
              <br>
              <?=$val["user"]['name']?>
              </span> <span class="img"><img src="<?=$val["user"]['headerurl']?>" /> </span>
              <?php } ?>
            </div>
            <?php } } ?>
            <?php if($_GET['t'] == 'task'){ // 创建任务?>
            <div class="picbox" style="position:inherit; height:8rem; width:8rem; line-height:8rem" >
              <input type="hidden" value="<?=$v['modid']?>" class="mod_id"   />
              <i class="aui-iconfont aui-icon-plus"></i> </div>
            <?php } ?>
          </div>
        </div>
      </div>
      <?php } ?>
    </section>
  </div>
  
  <!-- 修改任务-->
  
  <div id="main1" style="display:none">
    <div class="from-main task_type">
      <div class="list"> <span class="name">任务标题</span>
        <input type="hidden" value="" id="taskid" />
        <input type="hidden" value="" id="modid" />
        <input type="text" class="inp title" value="<?=$proinfo['title']?>" name="title" id="title" placeholder="请输入标题名" />
      </div>
      <div class="list"> <span class="name">任务描述</span>
        <input type="text" class="inp intro" value="<?=$proinfo['intro']?>" name="intro" id="intro"  placeholder="请输入项目描述" />
      </div>
      <div class="list start scale"> <span class="name">规模</span>
        <input type="hidden" value="" id="scale">
        <?php for($i=1;$i<=5;$i++){?>
        <div class="aui-col-xs-1"> <i data-id="<?=$i?>" <?=$i<=$proinfo['scale']?'style="color: rgb(252, 0, 0);"':''?> class="aui-iconfont aui-icon-star"></i> </div>
        <?php } ?>
      </div>
      <div class="list start difficulty"> <span class="name">难度</span>
        <input type="hidden" value="" id="difficulty">
        <?php for($i=1;$i<=5;$i++){?>
        <div class="aui-col-xs-1"> <i data-id="<?=$i?>" <?=$i<=$proinfo['difficulty']?'style="color: rgb(252, 0, 0);"':''?> class="aui-iconfont aui-icon-star"></i> </div>
        <?php } ?>
      </div>
      <div class="list start quality"> <span class="name">质量</span>
        <input type="hidden" value="" id="quality">
        <?php for($i=1;$i<=5;$i++){?>
        <div class="aui-col-xs-1"> <i data-id="<?=$i?>" <?=$i<=$proinfo['quality']?'style="color: rgb(252, 0, 0);"':''?> class="aui-iconfont aui-icon-star"></i> </div>
        <?php } ?>
      </div>
      <div class="list start features"> <span class="name">特性</span>
        <input type="hidden" value="" class="features">
        <?php for($i=1;$i<=5;$i++){?>
        <div class="aui-col-xs-1"> <i data-id="<?=$i?>" <?=$i<=$proinfo['features']?'style="color: rgb(252, 0, 0);"':''?> class="aui-iconfont aui-icon-star"></i> </div>
        <?php } ?>
      </div>
      <section class="aui-chat" id="chat">
        <div class="send">
          <div class="aui-btn an aui-btn-block " id="baosub">保存</div>
        </div>
      </section>
    </div>
  </div>
</section>
<div class="mc"></div>
<?php $is_active = array('is_active'=>1); $this->load->view('/api/inc/footer.php',$is_active); ?>
<script type="text/javascript" src="<?=base_url()?>static/api/script/api.js"></script> 
<script type="text/javascript" src="<?=base_url()?>static/api/script/aui-toast.js" ></script> 
<script type="text/javascript" src="<?=base_url()?>static/api/script/jquery.js" ></script> 
<script type="text/javascript">

  var toast = new auiToast({})

  var swiper = new Swiper('.swiper-container', {

        slidesPerView: 'auto',

        paginationClickable: true,

        spaceBetween: 30,

		slidesPerView: 2.2,

    }); 

	

 

	

<?php if($_GET['t'] == 'task'){ // 创建任务?>

$(".picbox").click(function() {

    $(".aui-pull-left").addClass("hides");

    $(".hides").attr("href","javascript:;");

	

	$(".aui-pull-lef").click(function(){

       location.reload();

	})

	

    var modid = $(this).find(".mod_id").val();

    var proid = <?=$projectinfo['id'] ?>;

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

			

				

			

            var a = [{

                title: title,

                intro: intro,

                task_type:task_type,

                scale: scale,

                quality: quality,

                features: features,

                difficulty: difficulty

            }];



            var url = "<?=base_url();?>index.php?d=api&c=project&m=create_task";



            var datas = {

                modid: modid,

                proid: proid,

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

                        title: "任务创建成功",

                        duration: 2000

                    });

                   // location.reload();

                    //window.history.go(-1); 

                }



            })



        })

       //多个任务

        $("#tasksub").click(function() {

		 

		var obj = [{"title":'','intro':'','task_type':'','scales':'','difficultys':'','qualitys':'','featuress':''},{"title":'','intro':'','task_type':'','scales':'','difficultys':'','qualitys':'','featuress':''}];

		

		$(".title").each(function(index, el) {

			if($(this).val()){ 

			    obj[index]['title']=$(this).val(); 

		    } 

           

        });

		

		$(".intro").each(function(index, el) {

			if($(this).val()){ 

			    obj[index]['intro']=$(this).val(); 

		    } 

           

        });

		

		$(".task_typeid").each(function(index, el) {

			if($(this).val()){ 

			    obj[index]['task_type']=$(this).val(); 

		    } 

           

        });

		

		$(".scales").each(function(index, el) {

			if($(this).val()){ 

			    obj[index]['scale']=$(this).val(); 

		    } 

           

        });

		

		$(".difficultys").each(function(index, el) {

			if($(this).val()){ 

			    obj[index]['difficulty']=$(this).val(); 

		    } 

           

        });

		

		$(".qualitys").each(function(index, el) {

			if($(this).val()){ 

			    obj[index]['quality']=$(this).val(); 

		    } 

           

        });

		

		$(".featuress").each(function(index, el) {

			if($(this).val()){ 

			    obj[index]['features']=$(this).val(); 

		    } 

           

        });

	 

	

	      var url = "<?=base_url();?>index.php?d=api&c=project&m=create_task";



            var datas = {

                modid: modid,

                proid: proid,

                'task': obj

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

                        title: "任务创建成功",

                        duration: 2000

                    });

                    location.reload();

                    //window.history.go(-1); 

                }



            })

	

	



       })

	   //多个任务结束



    })



})



$(".task-info").click(function() { //修改

    $("#main-info").hide();

    $("#main1").show();

	$("#main").hide();

	

	$(".aui-pull-left").addClass("hides");

	$(".hides").attr("href","javascript:;");

	 

    $(".hides").click(function(){

       location.reload();

	})

	

    var taskid = $(this).find(".taskid").val();

    var modid = $(this).find(".modid").val();

    var url = "<?=base_url();?>index.php?d=api&c=task&m=detail";

    var data = {

        'taskid': taskid,



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

            var mtask = res.data.member_task;

            var taskinfo = res.data.taskinfo;



            $(".toptitle").html("修改");

            $("#topr").html("删除");

            $("#topr").attr("onclick", "");



            $("#title").val(taskinfo.title);

            $("#intro").val(taskinfo.intro);

            $("#modid").val(modid);

            $("#taskid").val(taskid);

            $("#scale").val(taskinfo.scale);

            $("#difficulty").val(taskinfo.difficulty);

            $("#quality").val(taskinfo.quality);

            $("#features").val(taskinfo.features);

            getstart('scale', taskinfo.scale);

            getstart('difficulty', taskinfo.difficulty);

            getstart('quality', taskinfo.quality);

            getstart('features', taskinfo.features);



            $("#topr").click(function() {

                var url = "<?=base_url();?>index.php?d=api&c=task&m=task_del";

                var data = {

                    'taskid': taskid

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



                        toast.success({



                            title: "任务目删除成功",



                            duration: 2000

                        });

                        location.reload();

                    }

                })



            })



            //保存  

            $("#baosub").click(function() {

                var title = $("#title").val();

                var intro = $("#intro").val();

                var taskid = $("#taskid").val();

                var scale = $("#scale").val();

                var difficulty = $("#difficulty").val();

                var quality = $("#quality").val();

                var features = $("#features").val();

                var url = "<?=base_url();?>index.php?d=api&c=task&m=update";

                var datas = {

                    title: title,

                    intro: intro,

                    taskid: taskid,

                    scale: scale,

                    quality: quality,

                    features: features,

                    difficulty: difficulty

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

                            title: "任务修改成功",

                            duration: 2000

                        });

                        location.reload();



                    }

                })



            })

            //结束 



        }



    });

})

 function getstart(name, star) {



    $("." + name + " .aui-icon-star").each(



    function(index, el) {

        if ((index + 1) <= star) {

            $(el).css("color", "#fc0000");

        }



    })



}

 



 

<?php }?> 

	 

</script>
</body>
</html>

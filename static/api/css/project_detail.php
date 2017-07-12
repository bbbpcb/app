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
<header class="aui-bar aui-bar-nav aui-bar-warning" id="aui-header"> <a class="aui-pull-left aui-btn abs" href="javascript:history.go(-1);"> <span class="aui-iconfont aui-icon-left"></span> </a> 项目详情 </header>
<section id="wrap" class="pro-det">
  <div class="page-info">
    <?php if($invitstatus == 0){?>
    <img class="r-img" src="<?=base_url()?>static/api/images/yaoqing<?=$invitstatus?>.png" /> <span class="topnote">
    <?=$projectinfo['realname']?>
    邀请您为此项目负责人</span>
    <?php }else{ ?>
    <?php if($_GET['t']=='header'){?>
    <img class="r-img" src="<?=base_url()?>static/api/images/yaoqing<?=$invitstatus?>.png" />
    <?php }else{ ?>
    <img class="r-img" src="<?=base_url()?>static/api/images/project-<?=$projectinfo['status']?>.png" />
    <?php } ?>
    <?php } ?>
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
          </div>
        </div>
      </div>
      <?php } ?>
    </section>
  </div>
  
  <!--{领取任务}-->
  
  <div class="pro-task">
    <div class="title">领取任务<span class="cls"><i class="aui-iconfont aui-icon-close"></i></span></div>
    <div class="contents">
      <h2></h2>
      <div class="text"></div>
      <div class="pin"></div>
      <div class="choose">
        <div class="aui-list-item-input">
          <label>
            <input class="aui-radio" type="radio" value="1" name="roleid" checked>
            独立</label>
          <label>
            <input class="aui-radio" type="radio" value="2"  name="roleid">
            核心</label>
          <label>
            <input class="aui-radio" type="radio" value="3"  name="roleid">
            参与</label>
        </div>
        <div class="aui-btn an">领取</div>
      </div>
    </div>
  </div>
  
  <!--{领取任务结束}-->
  
  <div class="note">
    <div class="title">领取任务<span class="cls"><i class="aui-iconfont aui-icon-close"></i></span></div>
    <div class="text"> 亲爱的任务领取人，此任务已被您成功领取！祝您玩的愉快！ </div>
    <center>
      <div class="aui-btn bn">谢谢去完成任务</div>
    </center>
  </div>
  <section class="aui-chat" id="chat">
    <?php if($invitstatus == 0){?>
    <div class="send inv">
      <div class="aui-btn  aui-btn-block 	L" onClick="inv(<?=$projectinfo['id'] ?>,1)">接受邀请</div>
      <div class="aui-btn  aui-btn-block  R" onClick="inv(<?=$projectinfo['id'] ?>,2)">拒绝邀请</div>
    </div>
    <?php } ?>
  </section>
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

	 $(".task-info").click(function() {

    var taskid = $(this).find(".taskid").val();

    var modid = $(this).find(".modid").val();

    var mid = <?=$projectinfo['mid'] ?>;

    var proid = <?=$projectinfo['id'] ?>;

    var typeid = <?=$projectinfo['typeid'] ?>;

    var company_id = <?=$projectinfo['company_id'] ?>;

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

            $(".mc").show();

            $(".pro-task").show();

            var task = res.data.taskinfo;

            $(".contents h2").html(task.title);

            $(".contents .text").html(task.intro);

            var html = '规模:' + task.scale + '难度:' + task.difficulty;

            html += '<br>项目归属:' + task.ptitle;

            html += '<br>项目类型:' + task.type_name + '<br>';

            $(".pin").html(html);

            if (res.data.member_task) {

                var mtask = res.data.member_task;

                var str = '';

                if (mtask.duli) {

                    var duli = mtask.duli;

                    str += '独立[' + duli.grade + '分]: ';

                    var mduli = duli.member;

                    $.each(mduli,

                    function(index, el) {

                        str += el.realname + el.grade + '分';

                    }) 

					str += '<br>';



                }

                if (mtask.hexin) {



                    var hexin = mtask.hexin;

                    str += '核心[' + hexin.grade + '分]: ';

                    var mhexin = hexin.member;

                    $.each(mhexin,

                    function(index, el) {

                        str += el.realname + el.grade + '分 ';

                    }) 

					str += '<br>';



                }

                if (mtask.canyu) {

                    var canyu = mtask.canyu;

                    str += '参与[' + canyu.grade + '分]: ';

                    var mcanyu = canyu.member;

                    $.each(mcanyu,

                    function(index, el) {

                        str += el.realname + el.grade + '分 ';

                    }) 

					str += '<br>';

                }

                $(".pin").append(str);

              }

             

		   $(".an").click(function(){

		    

				  var url = "<?=base_url();?>index.php?d=api&c=task&m=receive";   

				  var roleid =$('input:radio:checked').val();

				 

			 var datas = {

                   'taskid': taskid,

                   'modid': modid,

                   'mid': mid,

				   'roleid':roleid,

                   'proid': proid,

                   'typeid': typeid,

                   'company_id': company_id

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

								 

			  /* toast.success({

                    title:"任务领取成功",

                    duration:2000

                });

				 location.reload(); 

				 */

				 $(".pro-task").hide();

				 $(".mc").show();

				 $(".note").show();

								 

			

			                 }

				           })

							 

				   })

							 //结束 





         



        }



    });

})

	$(".pro-task .aui-icon-close").click(function(){

		$(".mc").hide();

		$(".pro-task").hide();

		})

	$(".note .aui-icon-close").click(function(){

		$(".mc").hide();

		$(".note").hide();

		})

	$(".bn").click(function(){

	location.reload(); 

	})	

 

	     <?php if($invitstatus == 0){?>	 

function inv(pid,type){

     var mid=<?=$projectinfo['mid'] ?>;

	 var headid=<?=$projectinfo['headid'] ?>;

	 var url = "<?=base_url();?>index.php?d=api&c=project&m=invitestatus";

	  $.post(url,{proid:pid,type:type,headid:headid,mid:mid},

                   function(res) {

                   var res = jQuery.parseJSON(res);

				    if (res.errcode < 0) {

						  toast.fail({

                             title: res.errmsg,

                             duration: 2000

                                  });

                             } else {

								 

			               toast.success({

                              title:"提交成功",

                              duration:2000

                           });

						   

				        location.reload(); 

			  }

				           })

							 

		 

	

}	

<?php } ?> 

</script>
</body>
</html>

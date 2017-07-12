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
<section id="main"> </section>
<section id="main-info">
  <header class="aui-bar aui-bar-nav aui-bar-warning" id="aui-header"> 
  <a class="aui-pull-left aui-btn abs " id="qx" href="javascript:;">
   <span class="aui-iconfont aui-icon-left"></span> </a> 创建
    </header>
  <section id="wrap" class="mod pro-det">
    <div class="page-main">
      <div class="from-main"> 
        <span class="note1">请先选择模块在创建任务</span>
       <span class="note2"> 提示请在必选模块下至少创建一个任务！</span>
        <ul class="aui-list aui-list-in">
          <?php foreach($list as $v){?>
          <li class="aui-list-item aui-list-item-middle mod_list" data-id="<?=$v['id'] ?>" >
            <div class="aui-list-item-inner aui-list-item-arrow">
               <?=$v['m_name'] ?>
            </div>
          </li>
          <?php } ?>
        </ul>
      </div>
    </div>
    <section class="aui-chat" id="chat">
      <div class="send">
        <div class="aui-btn an aui-btn-block" id="baocun">提交</div>
      </div>
    </section>
  </section>
</section>
<script type="text/javascript" src="<?=base_url()?>static/api/script/api.js"></script>
<script type="text/javascript" src="<?=base_url()?>static/api/script/aui-toast.js" ></script>
<script type="text/javascript" src="<?=base_url()?>static/api/script/jquery.js"></script>
<script type="text/javascript">
var toast = new auiToast({})
  
</script>
</body>
</html>

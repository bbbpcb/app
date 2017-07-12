<div class="header_nav">
    <div class="wrap">
        <h1 class="logo"><a href="index.html"><img src="<?=base_url()?>static/images/logo.png" /></a></h1>
        <ul class="main_nav clearfix">
          <li><a <?php if($nav == 'index'){?>class="current" <?php } ?> href="<?=base_url()?>"> <h2>首页</h2> <span>HOME</span> </a></li>
          <li><a <?php if($nav == 'aboutus'){?>class="current" <?php } ?> href="<?=base_url()?>index.php?c=aboutus"> <h2>关于我们</h2> <span>ABOUTS</span> </a></li>
          <li><a <?php if($nav == 'news'){?>class="current" <?php } ?> href="<?=base_url()?>index.php?c=news"> <h2>新闻中心</h2> <span>NEWS</span> </a></li>
          <li><a <?php if($nav == 'business'){?>class="current" <?php } ?> href="<?=base_url()?>index.php?c=business"> <h2>集团业务</h2> <span>BUSINESS</span> </a></li>
          <li><a <?php if($nav == 'zeren'){?>class="current" <?php } ?> href="<?=base_url()?>index.php?c=zeren"> <h2>社会责任</h2> <span>RESPONSIBILITY</span> </a></li>
          <li><a <?php if($nav == 'renli'){?>class="current" <?php } ?> href="<?=base_url()?>index.php?c=renli"> <h2>人力资源</h2> <span>RESOURCES</span> </a></li>
        </ul>
    </div>
</div>
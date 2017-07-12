<script type="text/javascript" src="<?=base_url()?>static/api/script/jquery.js"></script> 
<div class="foot"></div>
<footer class="aui-bar-tab" id="footer">
  <div class="aui-bar-tab-item <?=$is_active==1?'aui-active':''?> " tapmode> <a href="<?=base_url();?>index.php?d=api&c=project"> <i class="aui-iconfont aui-icon-flag"></i>
    <div class="L"></div>
    <div class="aui-bar-tab-label">项目池</div>
    </a> </div>
  <div class="aui-bar-tab-item <?=$is_active==2?'aui-active':''?> " tapmode> <a href="<?=base_url();?>index.php?d=api&c=dotask&m=dotask_major&types=1"> <i class="aui-iconfont aui-icon-edit"></i>
    <div class="L"></div>
    <div class="aui-bar-tab-label">指导 </div>
    </a> </div>
  <div class="aui-bar-tab-item <?=$is_active==3?'aui-active':''?> " tapmode>  <a href="<?=base_url();?>index.php?d=api&c=conquer&type=1"> <i class="aui-iconfont aui-icon-comment"></i>
    <div class="L"></div>
    <div class="aui-bar-tab-label">智慧圈</div></a>
  </div>
  <div class="aui-bar-tab-item <?=$is_active==4?'aui-active':''?> " tapmode> <a href="<?=base_url();?>index.php?d=api&c=review&m=review_list&types=1"> <i class="aui-iconfont aui-icon-star"></i>
    <div class="L"></div>
    <div class="aui-bar-tab-label">评审</div></a>
  </div>
  <div class="aui-bar-tab-item <?=$is_active==5?'aui-active':''?> " tapmode> <a href="<?=base_url();?>index.php?d=api&c=userinfo">  <i class="aui-iconfont aui-icon-my"></i>
    <div class="L"></div>
    <div class="aui-bar-tab-label">我</div></a>
  </div>
</footer>


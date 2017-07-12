<?php
/**
*@DEC 注册接口
*/


class Register extends Api_Controller
{
	


	public function __construct()
	{
		parent::__construct();
		$this->load->model('member_mdl','member');
		$this->load->model('expert_mdl','expert');
		$this->load->model('user_mdl','user');
		$this->load->model('excel_mobile_mdl','excel_mobile');
	}


	public function index()
	{
	
		$data = $this->requestData();

		$mdata['realname'] = $data['data']['realname'];
		$mdata['company'] = $data['data']['company'];
		$mdata['depid'] = $data['data']['depid'];   
		$mdata['roleid'] = $data['data']['roleid']; 
		$mdata['mobile']= $data['data']['mobile']; 
		$mdata['zhiwei']= $data['data']['zhiwei']; 
        $mdata['passwd'] = $data['data']['passwd'];
		$company_id = $data['data']['company_id'];
		$mdata['company_id'] = $company_id;
        $authorcode= $data['data']['authorcode'];
       
        $mdata['createtime'] = time();
        $mdata['token'] = md5(time());
		$excel_mobile=$this->excel_mobile->get_one_by_id(array('company_id'=>$company_id,'mobile'=>$data['data']['mobile']));
		if(!$excel_mobile){
			$result = array('errcode'=>-1,'errmsg'=>'抱歉，你无权注册，请联系管理员增加');
			$this->responseData($result);
			exit;
		}
		$userinfo = $this->user->get_one_by_id(array('id'=>$company_id));
		$count = $this->member->get_count1( array('company_id'=>$company_id));//会员人数
		if($count>$userinfo['usernum']){
				 $result = array('errcode'=>-1,'errmsg'=>'抱歉，您的会员数量已满，请联系管理员增加');
				$this->responseData($result);
				exit;
		}
		
        if(empty($mdata['mobile']) || empty($mdata['passwd'])){
        	$result = array('errcode'=>-1,'errmsg'=>'信息不完整');
        	$this->responseData($result);
        	exit;
        }
        $checkmobile = $this->checkMobile($mdata['mobile'],$company_id);
       
        if(!$checkmobile){
        	$result = array('errcode'=>-1,'errmsg'=>'手机号已经存在');
        	$this->responseData($result);
        	exit;
        }
		$mdata['headerurl'] = 'default.jpg';
    	$mdata['passwd'] = md5($data['data']['passwd']);
        if($this->member->add($mdata)){
        	$result = array('errcode'=>0,'errmsg'=>'member register suc');
        }
       
            
        $this->responseData($result);

	}
	
	//检查用户名
	private function checkMobile($mobile,$company_id)
	{
		
		$config = array('mobile'=>$mobile,'company_id'=>$company_id);	
		$info = $this->member->get_one_by_id($config);
		
		if(!empty($info)){
			return false;
		}

		return true;
	}
}
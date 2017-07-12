<?php
/**
*@用户登录接口
*
**/

class Login extends Api_Controller
{




	public function __construct()
	{    
		parent::__construct();
		$customer_session_config = array(                        
                                  'sess_cookie_name' => 'customer_session_config',
                                  'sess_expiration' => 3600*24 // 保存 1 分钟
            );
		$this->load->library('session',$customer_session_config, 'customer_session');
		$this->load->helper('cookie');
		$this->load->model('department_mdl','department');
	}


	public function index()
	{   
	    $member = $this->session->userdata('member'); 
		if($member['is_login']){
		    redirect('d=api&c=userinfo');
		} 
		$data = $this->requestData();
        $mobile = $data['data']['mobile'];
		$passwd = $data['data']['passwd'];
		$company_id = 1;//所属管理员
		//,'passwd'=>md5($passwd)
		$where = array('mobile'=>$mobile,'enabled'=>1,'company_id'=>$company_id);
		$this->load->model('member_mdl','member');			
		$info = $this->member->get_one_by_id($where);
		
		if(empty($info)){
			$repjson = array('errcode'=>-1,'errmsg'=>'用户不存在或账号已停用');
		}else{
			if($info['passwd'] != md5($passwd)){
				$repjson = array('errcode'=>-1,'errmsg'=>'密码错误');
			}else{
				$tmp['id'] = $info['id'];
				$tmp['mobile'] = $info['mobile'];
				$tmp['realname'] = $info['realname'];
				$tmp['depid'] = $info['depid'];
				$infodep = $this->department->get_one_by_id(array('id'=>$info['depid'],'company_id'=>$company_id));
				if($infodep){
					$tmp['dep_name'] = $infodep['dep_name'];
				}else{
					$tmp['dep_name'] = '';
				}
				$tmp['headerurl'] = base_url().'uploads/member/header/'.$info['headerurl'];
				$tmp['roleid'] = $info['roleid'];
			
				//更新token和最后登录时间
				$updatadata['token'] = md5(time());
				$updatadata['lastlogin'] = time();
				$upconfig = array('id'=>$info['id']);
				$tmp['token'] = $updatadata['token'];
				$this->member->update($upconfig,$updatadata);
				$tmp['is_login']=1;
                $this->session->set_userdata('member',$tmp);
				$repjson = array('errcode'=>0,'errmsg'=>'ok','data'=>$tmp);
			}
		}
		
		if($mobile && $passwd){
             
		         $this->responseData($repjson);
			}else{
				$this->load->view('api/login');
				}
		
		//
	}
	
	//用户退出
	public function oulogin(){
	    $member = $this->session->userdata('member');
		$data = $this->requestData();
		$userid = $member['id'];
		$where = array('id'=>$userid);
		$this->load->model('member_mdl','member');			
		$info = $this->member->get_one_by_id($where);
		if(empty($info)){
			$repjson = array('errcode'=>-1,'errmsg'=>'用户不存在');
		}else{
			$upconfig = array('id'=>$info['id']);
			$updatadata['token'] = '';
			$this->member->update($upconfig,$updatadata);
			$repjson = array('errcode'=>0,'errmsg'=>'ok');
		}
		$this->session->unset_userdata('member');
	    redirect('d=api&c=login','','','退出成功！');
	   exit;
		//$this->responseData($repjson);
	}
	
	//找回密码
	public function findpwd(){
		$data = $this->requestData();
		$mobile = $data['data']['mobile'];
		$company_id = $data['data']['company_id'];//所属管理员
		$code = $data['data']['code'];//验证码，目前还没有接口，暂时不验证
		$where = array('mobile'=>$mobile,'company_id'=>$company_id);
		$info = $this->member->get_one_by_id($where);
		
		if(empty($info)){
			$repjson = array('errcode'=>-1,'errmsg'=>'用户不存在');
		}else{
			$repjson = array('errcode'=>0,'errmsg'=>'ok','data'=>$info['passwd']);
		}
		$this->responseData($repjson);
	}
}
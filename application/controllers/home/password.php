<?php


class Password extends Admin_Controller{


	public function __construct(){
		parent::__construct();
		$this->load->model('user_mdl','user');
	}


	public function index(){
		if(!empty($_POST)){
			$oldpwd = $this->input->post('oldpwd');
			$newpwd = $this->input->post('newpwd');
			$renewpwd = $this->input->post('renewpwd');
			if(!empty($oldpwd) && !empty($newpwd) && !empty($renewpwd)){
				if($newpwd != $renewpwd){
					exit('两次输入的密码不一致');
				}
				$userinfo =  $this->session->userdata('token');
				$info = array();			
				$info = $this->user->get_user_by_id($userinfo['id']);
				if($info['pwd'] == md5($oldpwd)){
					$data['pwd'] = md5($newpwd);
					$config['id'] = $userinfo['id'];
					echo $this->user->update($config,$data);
				}else{
					echo '原密码错误!';
					exit;
				}
			}else{
				echo '信息填写不完整';
			}
		}else{
			$this->load->view('home/home_password');
		}
	}
}
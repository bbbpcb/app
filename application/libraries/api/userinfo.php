<?php

class Userinfo
{
	

	/**
    * CI句柄
    * 
    * @access private
    * @var object
    */
	private $_CI;

	private $data = array();
	
	public function __construct()
	{
		        /** 获取CI句柄 */
		$this->_CI = & get_instance();
	}

	public function resopnse($data)
	{
		$this->data = $data;		
		$fun = $data['action'];
		$rep = $this->$fun();
		$result = array('errcode'=>0,'data'=>$rep);

        return $result;      
	}

	//编辑信息
	public function edit()
	{
		$id = $this->data['id'];
		$config = array('id'=>$id);
		$this->_CI->load->model('member_mdl','member');
		$userinfo = $this->_CI->member->get_one_by_id($config);

		return $userinfo;
	}

	//更新信息
	public function update()
	{
		$id = $this->data['id'];
		$data['username'] = $username;
        $data['realname'] = $realname;
        $data['mobile'] = $mobile;
        $data['check_mobile'] = $check_mobile;
        $data['depid'] = $depid;
        $data['roleid'] = $roleid;
        $data['profession'] = $profession;
        $data['industry'] = $industry;
        $data['content'] = $content;
        $data['enabled'] = $content;
        $this->_CI->load->model('member_mdl','member');

        $config = array('id'=>$id);
        $userinfo = $this->_CI->member->update($config,$data);

        return array('errcode'=>0,'errmsg'=>'ok');

	}
}
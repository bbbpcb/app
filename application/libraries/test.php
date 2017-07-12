<?php

class Test
{
	
		/**
    * CI句柄
    * 
    * @access private
    * @var object
    */
	private $_CI;


	
	public function __construct()
	{
		        /** 获取CI句柄 */
		$this->_CI = & get_instance();
	}

	public function resopnse()
	{
		$this->_CI->load->model('member_mdl','member');
		$this->_CI->load->library('Auth','auth');
		$list = $this->_CI->auth->hasLogin();
		//print_r($list);
	}
}
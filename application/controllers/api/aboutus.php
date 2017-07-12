<?php
/**
*@DEC 关于我们接口
***/


class Aboutus extends Api_Controller
{

	public function __construct()
	{
		parent::__construct();
	}	


	public function index()
	{
				$member = $this->session->userdata('member'); 
		$data = $this->requestData();
		$mid = $member['id'];
		$company_id = $data['data']['company_id']?$data['data']['company_id']:1;//所属管理员



		$this->load->model('article_mdl','article');

		$config = array('tag'=>'aboutus');
		$info = $this->article->get_one_by_id($config);
		
		$result = array(
			'errcode'=>0,
			'errmsg'=>'ok',
			'data'=>$info
			);
			
		    $data=array('list'=>$info);
			
			$this->load->view('api/user_aboutus',$data);
	 
	}
}
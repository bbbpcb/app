<?php

class Department extends Api_Controller
{




	public function __construct()
	{
		parent::__construct();
		$this->load->model('department_mdl','department');
	}

	public function index()
	{
		$data = $this->requestData();
		$company_id = $data['data']['company_id'];
		$where['where']=array('company_id'=>$company_id);
		$list = $this->department->getList($where);
		$result = array(
			'tag'=>$data['tag'],
			'data'=>$list
			);
		$this->responseData($result);
	}
}
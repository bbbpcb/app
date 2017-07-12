<?php

/**
*
*@系统说明
*/

class Aboutsys extends Api_Controller
{




	public function __construct()
	{
		parent::__construct();
		$this->load->model('advs_mdl','advs');
	}


	public function index()
	{
		
		 
		$data = $this->requestData();
	 
		$company_id = $data['data']['company_id']?$data['data']['company_id']:1;//所属管理员
		
		$this->load->model('aboutsys_mdl','aboutsys');
		$where['where']=array('company_id'=>$company_id);
		$list = $this->aboutsys->getList($where);

		$repjson = array(
 			  	
       		'errcode'=>0,
		 	'errmsg'=>'ok' , 
        	'data'=>$list, //当前请求的数据列表
        	);
			
		    $data=array('list'=>$list);
			$this->load->view('api/user_aboutsys',$data);		
	}
	
	

}
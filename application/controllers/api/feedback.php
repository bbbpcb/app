<?php
/**
*
*@DEC 意见反馈接口
**/

class Feedback extends Api_Controller
{
	
	public function __construct()
	{
		parent::__construct();
	}


	public function index()
	{
		$data = $this->requestData();
   
		 $member = $this->session->userdata('member'); 
		$data = $this->requestData();
		$mid = $member['id'];
		$company_id = $data['data']['company_id']?$data['data']['company_id']:1;//所属管理员
		
		if($_POST){
		$content = $data['data']['content'];
 
 
		if(!empty($mid) && !empty($content)){
			$this->load->model('feedback_mdl','feedback');
			$add['mid'] = $mid;
			$add['content'] = $content;
			$add['company_id'] = $company_id;
			$add['createtime'] = time();
			$this->feedback->add($add);
			$repjson = array('errcode'=>0,'errmsg'=>'ok');
		}else{
			$repjson = array('errcode'=>1,'errmsg'=>'info error');
		}	
       
        $this->responseData($repjson);
		
		}else{
				    $data=array('list'=>$list);
			$this->load->view('api/user_feedback',$data);	
		}
	}
}
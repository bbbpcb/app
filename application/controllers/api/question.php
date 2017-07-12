<?php


class Question extends Api_Controller
{
	


	public function __construct()
	{
		parent::__construct();
		$this->load->model('question_mdl','question');
		$this->load->model('question_reply_mdl','question_reply');
	}

	//问题列表
	public function index()
	{

		$data = $this->requestData();

		$mid = $data['mid'];
		$content = $data['content'];
		$token = $data['token'];
		$company_id = $data['data']['company_id'];//所属管理员
		if(!empty($mid) && !empty($content)){
			$add['mid'] = $mid;
			$add['content'] = $content;
			$add['company_id'] = $company_id;
			$add['createtime'] = time();
			if($this->question->add($add)){
				$repjson = array('errcode'=>0,'errmsg'=>'提交成功');
			}else{
				$repjson = array('errcode'=>-1,'errmsg'=>'提交失败，请重试');
			}
		}else{
			$repjson = array('errcode'=>-1,'errmsg'=>'信息不完整');
		}

		$this->responseData($repjson);
	}


	//问题箱列表
	public function qlist()
	{
		$data = $this->requestData();

		$mid = $data['mid'];
		$token = $data['token'];
		$limit = $data['limit'];
        $offset = $data['offset'];
        $wherelist['page'] = true;
        $wherelist['limit'] = $limit;
        $wherelist['offset'] = $offset;
		$company_id = $data['data']['company_id'];//所属管理员
		$wherelist['where'] = array('q.company_id'=>$company_id);
		$list = $this->question->getList($wherelist);
        $total = $this->question->get_count(array('company_id'=>$company_id));

        $repjson = array(
 			'tag'=>$data['tag'], 
 			'errcode'=>0,
 			'errmsg'=>'ok', 	
        	'total'=>$total,//数据总数
        	'data'=>$list //当前请求的数据列表
        	);
       
        $this->responseData($repjson);
	}

	//问题箱详情--单条
	public function detail()
	{
		$data = $this->requestData();

		$id = $data['id'];
		$token = $data['token'];
		$mid = $data['mid'];
		$company_id = $data['data']['company_id'];//所属管理员
		$config = array('id'=>$id,'mid'=>$mid,'company_id'=>$company_id);
		$info = $this->question->get_one_by_id($config);
		if(empty($info)){
			$repjson = array(
	 			'tag'=>$data['tag'],
	 			'errcode'=>-1,
 				'errmsg'=>'不存在'     	
	        	
        	);
		}else{
			$repjson = array(
	 			'tag'=>$data['tag'],
	 			'errcode'=>0,
 				'errmsg'=>'ok' ,
 				'data'=>$info    	
	        	
        	);
		}


       
        $this->responseData($repjson);
	}

	//专家回复列表
	public function replylist()
	{
		$data = $this->requestData();

		$id = $data['id'];
		$mid = $data['mid'];
		$token = $data['token'];
		$limit = $data['limit'];
        $offset = $data['offset'];
        $wherelist['page'] = true;
        $wherelist['limit'] = $limit;
        $wherelist['offset'] = $offset;

		$list = $this->question_reply->getList($wherelist);
        $total = $this->question_reply->get_count();

        $repjson = array(
 			'tag'=>$data['tag'], 
 			'errcode'=>0,
 			'errmsg'=>'ok',   	
        	'total'=>$total,//数据总数
        	'data'=>$list, //当前请求的数据列表
        	);
       
        $this->responseData($repjson);
	}

}
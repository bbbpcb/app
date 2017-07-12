<?php

/**
*
*@系统说明
*/

class Index extends Api_Controller
{




	public function __construct()
	{
		parent::__construct();
		$this->load->model('advs_mdl','advs');
		$this->load->model('member_mdl','member');
		$this->load->model('viewseach_mdl','viewseach');
		
	}
	
	//首页轮播图
	public function index(){

		$company_id = $data['data']['company_id'];//所属管理员
		$data =array();
		$list=array();
		$where['company_id']=array('company_id'=>$company_id);
		$list = $this->advs->getList($where);
		foreach($list as $k => $v){
			$list[$k]['img1'] = base_url().'uploads/pics/'.$list[$k]['img1'] ;
		}
		$user =$this->user_list();
	 
	 
        $data =array('list'=>$list,'employeelist'=>$user['employeelist'],'expertlist'=>$user['expertlist']);
		$this->load->view('api/index',$data);
		
	}
	
	//人气榜
	public function user_list(){
		$data =array();
		//$token = $data['data']['token'];
		$where['order'] = array('key'=>'integraltotal','value'=>'desc');
		$where['page'] = true;
        $where['limit'] =6;
        $where['offset'] = 0;
		 
		$where['where'] =array('roleid'=>1);
		$list = $this->member->getList2($where);
		 
		 
		$lists=array();
		foreach($list as $k => $v){
			$user['realname']=$v['realname'];
			$user['headerurl'] = base_url().'uploads/member/header/'.$v['headerurl'];
			$user['id']=$v['id'];
			$user['integraltotal']=$v['integraltotal'];
			$lists[]=$user;
		}
		
		$where2['order'] = array('key'=>'integraltotal','value'=>'desc');
		$where2['page'] = true;
        $where2['limit'] =6;
        $where2['offset'] = 0;
		$where2['where'] =array('roleid'=>2);
		$list2 = $this->member->getList2($where2);
		$lists2=array();
		foreach($list2 as $k1 => $v1){
			$user['realname']=$v1['realname'];
			$user['headerurl'] = base_url().'uploads/member/header/'.$v1['headerurl'];
			$user['id']=$v1['id'];
			$user['integraltotal']=$v1['integraltotal'];
			$lists2[]=$user;
		}
		 
		 
        return	$data=array(
				'employeelist'=>$lists,
				'expertlist'=>$lists2,
			);
        	 
		 
	}
	
	
	//更多用户
	public function user_detail_list(){
		$data = $this->requestData();
		//$token = $data['data']['token'];
		$typeid = $data['data']['typeid'];//1为员工2为专家
		$company_id = $data['data']['company_id']?$data['data']['company_id']:1;//所属管理员
		$where['order'] = array('key'=>'integraltotal','value'=>'desc');
		$where['where'] =array('roleid'=>$typeid,'company_id'=>$company_id );
		$list = $this->member->getList2($where);
		$lists=array();
		foreach($list as $k => $v){
			$user['realname']=$v['realname'];
			$user['headerurl'] = base_url().'uploads/member/header/'.$v['headerurl'];
			$user['id']=$v['id'];
			$user['integraltotal']=$v['integraltotal'];
			$lists[]=$user;
		}
		if($_POST){
		$repjson = array(	
       		'errcode'=>0,
		 	'errmsg'=>'ok' , 
        	'data'=>$lists
        	);
			 $this->responseData($repjson);
		}else{
		 $data=array('list'=>$lists);
			$this->load->view('api/more',$data); 	 	
			}
		
		   
	}
	
	
	//搜索
	public function seach(){
		$list=array();
		$data = $this->requestData();
		$limit = !empty($data['data']['limit']) ? $data['data']['limit'] : 10;
		$offset = !empty($data['data']['offset']) ? $data['data']['offset'] : 0;
		$title=$data['data']['title'];
		$company_id = $data['data']['company_id'];//所属管理员
		$where['page'] = true;
        $where['limit'] = $limit;
        $where['offset'] = $offset;
		$where1=array();
		if(!empty($title)){
			$where['likeand'] = array('title'=>$title,'company_id'=>$company_id);
			$where1['likeand'] = array('title'=>$title,'company_id'=>$company_id);
		}else{
			$where['where']=array();
		}
		$count= $this->viewseach->get_count2($where1);
		$list = $this->viewseach->getList($where);
		
		if($_POST){
		$repjson = array(
       		'errcode'=>0,
		 	'errmsg'=>'ok' , 
			'totalcount'=>$count, 
		 	'data'=>$list
        	
        );
		$this->responseData($repjson);
		}else{
		$data =array('list'=>$list);
	    $this->load->view('api/search',$data);
		}
		//$this->responseData($repjson);
	}
}
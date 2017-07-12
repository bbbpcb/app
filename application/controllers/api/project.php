<?php

/**
*
*@DEC 项目相关接口
**/


class Project extends Api_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('project_mdl','project');
		$this->load->model('task_mdl','task');
		$this->load->model('member_task_mdl','member_task');
		$this->load->model('task_fansi_mdl','task_fansi');
		$this->load->model('task_fansi_reply_mdl','task_fansi_reply');
		$this->load->model('task_plan_mdl','task_plan');
		$this->load->model('task_plan_reply_mdl','task_plan_reply');
		$this->load->model('task_wenti_mdl','task_wenti');
		$this->load->model('task_wenti_reply_mdl','task_wenti_reply');
		$this->load->model('review_mdl','review');
		$this->load->model('review_question_mdl','review_question');
		$this->load->model('review_question_feedback_mdl','review_question_feedback');
		$this->load->model('review_staff_mdl','review_staff');
		$this->load->model('invite_mdl','invite');
		$this->load->model('member_task_mdl','member_task');
		$this->load->model('star_mdl','star');
		$this->load->model('gongshi_mdl','gongshi');
		$this->load->model('review_task_mdl','review_task');
		$this->load->model('task_marking_mdl','task_marking');
		$this->load->model('project_total_mdl','project_total');
		$this->load->library('session');
		//echo $this->db->last_query();
	}
	
	

	/**项目列表**/
	public function index()
	{
		
		$member = $this->session->userdata('member'); 
		$data = $this->requestData();
		$mid = $member['id'];
		$company_id = $data['data']['company_id']?$data['data']['company_id']:1;//所属管理员
		
		 if(empty($member)){
		 redirect('d=api&c=login','','','抱歉,请先登录');
	      exit;
		}
		
		$ptype = $data['data']['ptype'];
		$limit = !empty($data['data']['limit']) ? $data['data']['limit'] : 10;
		$offset = !empty($data['data']['offset']) ? $data['data']['offset'] : 0;
	 
		$company_id = $data['data']['company_id']?$data['data']['company_id']:1;//所属管理员
		
		if($ptype == 'basics'){ //基础项目
			$wherelist['where'] = array('p.typeid'=>2,'i.status'=>1,'p.company_id'=>$company_id);
		}elseif($ptype == 'major'){
			$wherelist['where'] = array('p.typeid'=>1,'i.status'=>1,'p.company_id'=>$company_id);
		}elseif($ptype == 'own'){
			$wherelist['where'] = array('p.mid'=>$mid,'p.company_id'=>$company_id);
		}elseif($ptype == 'header'){
			$wherelist['where'] = array('p.headid'=>$mid,'p.company_id'=>$company_id);//另一接口
		}else{
			$wherelist['where'] = array('p.typeid'=>1,'i.status'=>1,'p.company_id'=>$company_id);
		}
		
		if($wherelist){
			if($ptype == 'basics'){ //基础项目
				$wherec = array('p.typeid'=>2,'i.status'=>1,'p.company_id'=>$company_id);
				$wherelist['order'] =array('key'=>'i.invite_time','value'=>'desc');
			}elseif($ptype == 'major'){
				$wherec = array('p.typeid'=>1,'i.status'=>1,'p.company_id'=>$company_id);
				$wherelist['order'] =array('key'=>'i.invite_time','value'=>'desc');
			}elseif($ptype == 'own'){
				$wherec = array('p.mid'=>$mid,'p.company_id'=>$company_id);
			}elseif($ptype == 'header'){
				$wherec = array('p.headid'=>$mid,'p.company_id'=>$company_id);//另一接口
			}
			
			$countlist=$this->project->get_count1($wherec);
		}else{
			$countlist=0;
		}
		
		$list = array();
        $wherelist['page'] = true;
        $wherelist['limit'] = $limit;
        $wherelist['offset'] = $offset;
        $list = $this->project->getList($wherelist);

        $lists = array();
        foreach($list as $k => $v){
			$taksicon=$this->pic($v['typeid'],$v['difficulty'],$v['scale'],$company_id);
			if($taksicon){
				$v['icon'] = base_url().'uploads/pics/'.$taksicon['picname'];//任务图标
			}else{
				$v['icon'] ='';
			}
			
        	$v['createtime'] = date("Y-m-d",$v['createtime']);
			
			if($v['invitestatus']==2){
				$v['realname']='已拒绝';
			}
			$mtaks=$this->member_task->get_one_by_id(array('projectid'=>$v['id'],'company_id'=>$company_id));
			if($mtaks){
				$v['delstatus']='1';
			}else{
				$v['delstatus']='0';
			}
			$lists[]=$v;
        }
		
		if($_POST){
		  	$repjson = array(
       			'errcode'=>0,
		 		'errmsg'=>'ok' , 
		 		'data'=>$lists,
				'count'=>($countlist),
        	
        );
       	$this->responseData($repjson);
		}else{
       $data =array('list'=>$lists,'count'=>($countlist));
	   //var_dump($data);
       $this->load->view('api/project',$data);
	   }

	}

	//负责项目
	public function project_own()
	{
		$data = $this->requestData();
		$mid = $data['data']['mid'];
		$token = $data['data']['token'];
		$company_id = $data['data']['company_id'];//所属管理员

		$list = array();
		$this->load->model('invite_mdl','invite');

		$limit = !empty($data['data']['limit']) ? $data['data']['limit'] : 10;
		$offset = !empty($data['data']['offset']) ? $data['data']['offset'] : 0;
		$where['page'] = true;
        $where['limit'] = $limit;
        $where['offset'] = $offset;

		$wherelist['where'] = array('p.headid'=>$mid,'p.company_id'=>$company_id);//另一接口
		$list = $this->project->getList($where);
		$lists = array();
		foreach($list as $k => $v){
			$taksicon=$this->pic($v['typeid'],$v['difficulty'],$v['scale'],$v['company_id']);
			if($taksicon){
				$v['icon'] = base_url().'uploads/pics/'.$taksicon['picname'];//任务图标
			}else{
				$v['icon'] ='';
			}
			
        	$v['createtime'] = date("Y-m-d",$v['createtime']);
        	$v['status'] = $v['invitestatus'];
			if($v['invitestatus']==0){
				$v['realname']='';
			}elseif($v['invitestatus']==2){
				$v['realname']='已拒绝';
			}
        	$lists[] = $v;
		}
		$repjson = array(
       		'errcode'=>0,
		 	'errmsg'=>'ok' , 
		 	'data'=>$lists
        	
        );

		$this->responseData($repjson);

		//
	}



	/**创建项目**/
	/*
    @param string tag 接口名称
	@param int mid 用户id
	@param string token  token
	@param string title  项目名称
	@param int scale 规模
	@param int difficulty 难度
	@param int quality质量
	@param int features  特性
	@param int headid 负责人id
	*/
	public function create()
	{
		$data = $this->requestData();
		$mid = $data['data']['mid'];
		$token = $data['data']['token'];
		$company_id = $data['data']['company_id'];//所属管理员
		$add['title'] = $data['data']['title'];
		$add['scale'] = $data['data']['scale'];
		$add['difficulty'] = $data['data']['difficulty'];
		$add['quality'] = $data['data']['quality'];
		$add['features'] = $data['data']['features'];
		$add['headid'] = $data['data']['headid'];
		$add['createtime'] = time();
		$add['typeid'] = $data['data']['typeid'];
		$add['mid'] = $data['data']['mid'];
		$add['modid'] = $data['data']['modid'];
		$add['intro'] = $data['data']['intro'];
		$add['company_id'] = $company_id;
		//print_r($data);

		if(
			 empty($add['title']) ||
			 empty($add['scale']) || 
			 empty($add['difficulty']) || 
			 empty($add['quality']) || 
			 empty($add['features']) || 
			 empty($add['mid']) || 
			 empty($add['headid']) || 
			 empty($add['scale']) ||
			 empty($add['modid'])||
			 empty($add['company_id'])
		){
			$repjson = array(
       			'errcode'=>-1,
		 		'errmsg'=>'信息不完整' , 
        	);
			$this->responseData($repjson);
			exit;
		}
		

		//添加项目信息
		if($this->project->add($add)){

			$pid = $this->project->insert_id();
			//添加邀请记录
			$log['pid'] = $pid;
			$log['headid'] = $add['headid'];
			$log['createtime'] = time();
			$log['company_id'] = $company_id;
			$this->load->model('invite_mdl','invite');
			if($this->invite->add($log)){
				//成功时返回
				$repjson = array(
       				'errcode'=>0,
		 			'errmsg'=>'操作成功', 
		 			'data'=>array(
		 				'id'=>$pid
		 				)    	
        		);
			}
		}else{

			$repjson = array(
       			'errcode'=>-1,
		 		'errmsg'=>'操作有误，请重试' , 
        	);
		}
		$this->responseData($repjson);
		
	}

	//创建重大项目
	public function create_major()
	{
		$num = 0;
        $member = $this->session->userdata('member'); 
		$data = $this->requestData();
		$mid = $member['id'];
		$company_id = $data['data']['company_id']?$data['data']['company_id']:1;//所属管理员
		
		if(empty($member)){
		    redirect('d=api&c=login');
			exit;
		}	
		if($data['data']['title']){	
		$add['title'] = $data['data']['title'];
		$add['intro'] = $data['data']['intro'];
		$add['scale'] = $data['data']['scale'];
		$add['difficulty'] = $data['data']['difficulty'];
		$add['quality'] = $data['data']['quality'];
		$add['features'] = $data['data']['features'];
		$add['headid'] = $data['data']['headid'];
		$add['createtime'] = time();
		$add['typeid'] = $data['data']['typeid'];
		$add['mid'] = $mid;
		$add['company_id'] = $company_id;

		//添加项目信息
		if($this->project->add($add)){

			$pid = $this->project->insert_id();
			//添加邀请记录
			$log['pid'] = $pid;
			$log['headid'] = $add['headid'];
			$log['createtime'] = time();
			$log['company_id'] = $company_id;
			$this->load->model('invite_mdl','invite');
			if($this->invite->add($log)){
				$mods = $data['data']['mods'];
				if(!empty($mods)){
					foreach($mods as $k => $v){
						$modid = $v['modid'];
						$task = array();
						$task = $v['task'];

						if(!empty($task)){
							$addtask = array();
							foreach($task as $k => $v){
								if(!empty($v['title'])){
									$addtask['title'] = $v['title'];
									$addtask['intro'] = $v['intro'];
									$addtask['scale'] = $v['scale'];
									$addtask['difficulty'] = $v['difficulty'];
									$addtask['quality'] = $v['quality'];
									$addtask['features'] = $v['features'];
									$addtask['modid'] = $modid;
									$addtask['proid'] = $pid;
									$addtask['createtime'] = time();
									$addtask['mid'] = $add['mid'];
									$addtask['task_type'] = $v['task_type'];
									$addtask['company_id'] = $company_id;
									if($this->task->add($addtask)){
										
										$num++;
									}
								}
							}
						}
					}
				}
			}

			$repjson = array(
       			'errcode'=>0,
		 		'errmsg'=>'添加成功',
		 		'data'=>array('num'=>$num,'pid'=>$pid)
        	);

		}else{

			$repjson = array(
       			'errcode'=>-1,
		 		'errmsg'=>'操作有误，请重试' , 
        	
        	);
		}
		$this->responseData($repjson);
		}else{
		
		$member = $this->session->userdata('member'); 
		$data = $this->requestData();
		$mid = $member['id'];
		$company_id = $data['data']['company_id']?$data['data']['company_id']:1;//所属管理员
		$proid = $data['data']['proid']; //项目id
		$config = array('p.id'=>$proid,'p.company_id'=>$company_id);
		$proinfo = $this->project->get_one_by_id($config);
		
		//var_dump($proinfo);
		
		  $data=array('type'=>2,'proinfo'=>$proinfo);
		  $this->load->view('api/project_create',$data);
		}
	}
	
	//创建项目中添加任务
	public function create_task(){
		$member = $this->session->userdata('member'); 
		$data = $this->requestData();
		$mid = $member['id'];
		$company_id = $data['data']['company_id']?$data['data']['company_id']:1;//所属管理员
		
		if(empty($member)){
		    redirect('d=api&c=login');
			exit;
		}	
 
		$modid=$data['data']['modid'];
		$proid=$data['data']['proid'];
		$task=$data['data']['task'];
 
		$num=0;
		
		if(!empty($mid) && !empty($modid) && !empty($proid)){
			if($task){
				foreach($task as $k => $v){
					if(!empty($v['title'])){
						$addtask['title'] = $v['title'];
						$addtask['intro'] = $v['intro'];
						$addtask['scale'] = $v['scale'];
						$addtask['difficulty'] = $v['difficulty'];
						$addtask['quality'] = $v['quality'];
						$addtask['features'] = $v['features'];
						$addtask['modid'] = $modid;
						$addtask['proid'] = $proid;
						$addtask['createtime'] = time();
						$addtask['mid'] = $mid;
						$addtask['task_type'] = $v['task_type'];
						$addtask['company_id'] = $company_id;
						if($this->task->add($addtask)){
							$num++;
						}
					}
				}
			}
			$repjson = array(
					'errcode'=>0,
					'errmsg'=>'提交成功' , 
					'data'=>array('num'=>$num,'pid'=>$proid)
				);
			$this->responseData($repjson);
		}else{
			$repjson = array(
					'errcode'=>-1,
					'errmsg'=>'操作有误，请重试' , 
				);
			}
		$this->responseData($repjson);
		 
	}


	//创建基础项目
	public function create_basics()
	{
 
        $member = $this->session->userdata('member'); 
		$data = $this->requestData();
		$mid = $member['id'];
		$company_id = $data['data']['company_id']?$data['data']['company_id']:1;//所属管理员
		if(empty($member)){
		    redirect('d=api&c=login');
			exit;
		}	
		if($data['data']['title']){	
		$add['title'] = $data['data']['title'];
		$add['scale'] = $data['data']['scale'];
		$add['difficulty'] = $data['data']['difficulty'];
		$add['quality'] = $data['data']['quality'];
		$add['features'] = $data['data']['features'];
		$add['headid'] = $data['data']['headid'];
		$add['createtime'] = time();
		$add['typeid'] = 2;
		$add['mid'] = $mid;
		$add['intro'] = $data['data']['intro'];
		$add['company_id'] = $company_id;
		if(
			 empty($add['title']) ||
			 empty($add['scale']) || 
			 empty($add['difficulty']) || 
			 empty($add['quality']) || 
			 empty($add['features']) || 
			 empty($add['mid']) || 
			 empty($add['headid']) || 
			 empty($add['scale'])
		){
			
			$repjson = array(
       			'errcode'=>-1,
		 		'errmsg'=>'信息不完整' ,      	
        	);
			$this->responseData($repjson);
			exit;
		}

		if($this->project->add($add)){

			$pid = $this->project->insert_id();
			
			$addtask['title'] = $add['title'];
			$addtask['intro'] = $add['intro'];
			$addtask['scale'] = $add['scale'];
			$addtask['difficulty'] = $add['difficulty'];
			$addtask['quality'] = $add['quality'];
			$addtask['features'] = $add['features'];
			$addtask['modid'] = 0;
			$addtask['proid'] = $pid;
			$addtask['createtime'] = time();
			$addtask['mid'] = $mid;
			$addtask['task_type'] = 0;
			$addtask['company_id'] = $company_id;
			$this->task->add($addtask);//创建任务
			
			
			//添加邀请记录
			$log['pid'] = $pid;
			$log['headid'] = $add['headid'];
			$log['createtime'] = time();
			$log['company_id'] = $company_id;
			$this->load->model('invite_mdl','invite');
			if($this->invite->add($log)){
				//成功时返回
				$repjson = array(
       				'errcode'=>0,
		 			'errmsg'=>'创建成功', 
		 			'data'=>array(
		 				'id'=>$pid
		 				)    	
        		);
        		$this->responseData($repjson);
        		exit;
			}else{
				$repjson = array(
       				'errcode'=>-2,
		 			'errmsg'=>'添加负责人失败'	
        		);
        		$this->responseData($repjson);
        		exit;
			}
		}else{
			$repjson = array(
       			'errcode'=>-1,
		 		'errmsg'=>'创建失败' ,      	
        	);
        	$this->responseData($repjson);
        	exit;
		}
		}else{
		$member = $this->session->userdata('member'); 
		$data = $this->requestData();
		$mid = $member['id'];
		$company_id = $data['data']['company_id']?$data['data']['company_id']:1;//所属管理员
		$proid = $data['data']['proid']; //项目id
		$config = array('p.id'=>$proid,'p.company_id'=>$company_id);
		$proinfo = $this->project->get_one_by_id($config);
		
		//var_dump($proinfo);
		
		  $data=array('type'=>1,'proinfo'=>$proinfo);
		  $this->load->view('api/project_create_basics',$data);
		}
		
		

	}
	//随机获取图片
	public function pic($type,$nandu,$guimo,$company_id){
		if($nandu==0){
			return "";
		}
		//图片
		$pics = array();
		$this->load->model('pics_mdl','pics');
		$picwhere['where'] = array('typeid'=>$type,'nandu'=>$nandu,'guimo'=>$guimo,'company_id'=>$company_id);
		$pics = $this->pics->getList($picwhere);
		if(!$pics){
			return "";
		}
		$rand_keys = array_rand($pics);
		return $pics[$rand_keys];
	}
	
	
	//获取星的值1规模,2难度,3质量.4特性
	public function starval($type,$star,$company_id){
		if($star==0){
			return 0;
		}
		$config=array('type'=>$type,'company_id'=>$company_id);
		$info = $this->star->get_one_by_id($config);
		return $info['star'.$star.''];
	}

	/**项目详情列表-模块**/
	public function detail()
	{
		$member = $this->session->userdata('member'); 
		$data = $this->requestData();
		$mid = $member['id'];
		$company_id = $data['data']['company_id']?$data['data']['company_id']:1;//所属管理员
		$proid = $data['data']['proid']; //项目id
		$ts=$data['data']['t']; //项目id
		
		$config = array('p.id'=>$proid,'p.company_id'=>$company_id);
		$proinfo = $this->project->get_one_by_id($config);
		$receive=null;
		if(empty($proinfo)){
			$repjson = array(
       			'errcode'=>-1,
		 		'errmsg'=>'项目不存在',      	
        	);
			$this->responseData($repjson);
			exit;
		}
		//计算公式
		$jsconfig = array('tags'=>'jisuan','company_id'=>$company_id);
		$js = array();
		$js = $this->gongshi->get_one_by_id($jsconfig);
		$jsgs = $js['info'];
		$j = array();
		if(!empty($jsgs)){
			$j1 =substr($jsgs, 1,1);
			$j2 =substr($jsgs, 3,1);
			$j3 =substr($jsgs, 5,1);
		} 
		if($proinfo['typeid'] == 1){ //重大项目

			//模块列表
			$this->load->model('mod_mdl','mod');
			$modwhere['where']=array('m.company_id'=>$company_id);
			$modwhere['order'] = array('key'=>'rank','value'=>'asc');
			$modlist = $this->mod->getList($modwhere);

			//项目下面所有任务
			$this->load->model('task_mdl','task');
			$where['where'] = array('t.proid'=>$proid,'t.company_id'=>$company_id);
			$where['order']=array('key'=>'task_type','value'=>'asc');
			$list = $this->task->getList($where);
			$m = array();
			$mods = array();
			//任务归类-以模块id
			if(!empty($list)){
				foreach($list as $lk => $lv){
					
					$t['modid'] = $lv['modid'];	//任务id
					$t['taskid'] = $lv['id'];	//任务id
					$t['title'] = $lv['title']; //任务标题
					$t['scale'] = $lv['scale']; //规模
					$t['difficulty'] = $lv['difficulty']; //难度
					$t['quality'] = $lv['quality']; //质量
					$t['features'] = $lv['features']; //特性
					$t['intro'] = $lv['intro']; //任务描述
					$quality=0;
					//获取指导中任务打分的数据
					//$task_markinglist=$this->task_marking->get_all(array('typeid'=>1,'taskid'=>$lv['id']));
//					if($task_markinglist){
//						$mcout=count($task_markinglist);
//						foreach($task_markinglist as $km => $vm){
//							$quality=(float)$quality+(float)$vm['score'];
//						}
//						eval("\$jgq=$quality/$mcout;");
//						$quality=$jgq;
//					}else{
					$quality = $this->starval('3',$lv['quality'],$company_id);
					//}
					$scale = $this->starval('1',$lv['scale'],$company_id);
		            $difficulty = $this->starval('2',$lv['difficulty'],$company_id);
		            $features =$this->starval('4',$lv['features'],$company_id);
		            eval("\$jg=$scale$j1$difficulty$j2$quality$j3$features;");
		            $t['task_type'] = $lv['type_name'];
					$t['grade'] = $jg;
					$t['status'] = $lv['status']; //0-关闭，1-进行中，2-延时，3,-结束
					
					//判断是否已经领取
					$uconfig = array('taskid'=>$lv['id'],'company_id'=>$company_id);
					$checkuser = $this->member_task->get_one_by_id($uconfig);
					if($checkuser){
						$t['deltaskstatus']=1;
					}else{
						$t['deltaskstatus']=0;
					}
					$taksicon=$this->pic('4',$lv['difficulty'],$lv['scale'],$company_id);
					if($taksicon){
						$t['task_icon'] = base_url().'uploads/pics/'.$taksicon['picname'];//任务图标
					}else{
						$t['task_icon'] ='';
					}
			
					//'mid'=>$lv['mid']
					
					$member_task = $this->member_task->get_one_by_id(array('taskid'=>$lv['id'],'roleid'=>1,'company_id'=>$company_id));
			 
					if($member_task){
							$t['user'] = array('roleid'=>$member_task['roleid'],'name'=>$member_task['realname'],'headerurl'=>base_url().'uploads/member/header/'.$member_task['headerurl']);//用户头像
					}else{
						$member_task1 = $this->member_task->get_one_by_id(array('taskid'=>$lv['id'],'roleid'=>2,'company_id'=>$company_id));
					 
						if($member_task1){
							$t['user'] = array('roleid'=>$member_task1['roleid'],'name'=>$member_task1['realname'],'headerurl'=>base_url().'uploads/member/header/'.$member_task1['headerurl']);//用户头像
						}else{
							$t['user'] = array('roleid'=>'','name'=>'','headerurl'=>base_url().'');//用户头像
						}
					}
					$t['prostatus']=$proinfo['status'];
					
					$m[$lv['modid']][] = $t;
				}
			}

			//拼模块
			foreach($modlist as $mk => $mv){
				$mod['modid'] = $mv['id'];
				$mod['m_name'] = $mv['m_name']; 
				if($proinfo['status']==0){
					$mod['status'] = 3; ////已经评审
				}else{
					$taskinfo = $this->task->get_one_by_id(array('t.proid'=>$proid,'t.modid'=>$mv['id'],'t.company_id'=>$company_id));
					if($taskinfo){
						$mod['status'] = 1; //评审中
					}else{
						$mod['status'] =0; //评审中
					}
				}
				$mod['task'] = empty($m[$mv['id']]) ? array() : $m[$mv['id']];
				$mods[] = $mod;
			}
			$invitstatus=0;
			//是否有邀请
			$inviteinfo=$this->invite->get_one_by_id(array('pid'=>$proid,'headid'=>$proinfo['headid'],'company_id'=>$company_id));
			if($inviteinfo){
				$invitstatus=$inviteinfo['status'];
			}
			$repjson = array(
       			'errcode'=>0,
		 		'errmsg'=>'ok' , 
		 		'projectinfo'=>$proinfo,
		 		'modlist'=>$mods,
				'invitstatus'=>$invitstatus//0为等待1为接受2为拒绝
        	);

			 $data=array('projectinfo'=>$proinfo	,
		 		'modlist'=>$mods,
				'invitstatus'=>$invitstatus);
			 
			//  var_dump($data);
			
			if($ts == 'task'){
			 
			$this->load->view('api/project_detail_edit',$data);		
				}else{
			$this->load->view('api/project_detail',$data);	
				}

		}elseif($proinfo['typeid'] == 2){ //基础项目
			$scale = $this->starval('1',$proinfo['scale'],$company_id);
			$difficulty = $this->starval('2',$proinfo['difficulty'],$company_id);
			$quality=0;
			//获取指导中任务打分的数据
			//$task_markinglist=$this->task_marking->get_all(array('typeid'=>2,'projectid'=>$proinfo['id']));
//			if($task_markinglist){
//				$mcout=count($task_markinglist);
//				foreach($task_markinglist as $km => $vm){
//					$quality=(float)$quality+(float)$vm['score'];
//				}
//				eval("\$jgq=$quality/$mcout;");
//				$quality=$jgq;
//			}else{
			$quality = $this->starval('3',$proinfo['quality'],$company_id);
			//}
			$receive=null;
			$features =$this->starval('4',$proinfo['features'],$company_id);
			eval("\$jg=$scale$j1$difficulty$j2$quality$j3$features;");
			$proinfo['total'] = $jg; //标准分
			//领取总人数
			$membercount=$this->member_task->get_count(array('projectid'=>$proinfo['id'],'company_id'=>$company_id));
			$proinfo['receive_num'] = $membercount;
			//领取情况,1-独立,2-核心,3-参与
			$dulilist=$this->member_task->get_one_by_id(array('projectid'=>$proinfo['id'],'roleid'=>1,'company_id'=>$company_id));
			//独立
			if($dulilist){
				$receive['duli']['grade'] =$jg;
				$receive['duli']['member'][]=array(
											'uid'=>'',
											'header'=>base_url().'uploads/member/header/'.$dulilist['headerurl'],
											'realname'=>$dulilist['realname'],
											'grade'=>$jg
										);
			}
			
			$hexinlist=$this->member_task->get_one_by_id(array('projectid'=>$proinfo['id'],'roleid'=>2,'company_id'=>$company_id));
			$canyulist=$this->member_task->get_all(array('projectid'=>$proinfo['id'],'roleid'=>3,'company_id'=>$company_id));
			//核心
			if($hexinlist){
				if($canyulist){
					$fenarray=$this->receivefen($jg,(count($canyulist)),0);
				}else{
					$fenarray=$this->receivefen($jg,(count($canyulist)),1);
				}
				$receive['hexin']['grade'] =$fenarray['hexinfen'];
				$receive['hexin']['member'][]=array(
											'uid'=>'',
											'header'=>base_url().'uploads/member/header/'.$hexinlist['headerurl'],
											'realname'=>$hexinlist['realname'],
											'grade'=>$fenarray['hexinfen']
										);
			}
			//参于
			if($canyulist){
				if($hexinlist){
					$fenarray=$this->receivefen($jg,(count($canyulist)),0);
				}else{
					$fenarray=$this->receivefen($jg,1,2);
				}
				$receive['canyu']['grade'] =$fenarray['canyufen']*count($canyulist);
				$res=array();
				foreach($canyulist as $k => $v){
					$res[$k]=array(
								'uid'=>'',
								'header'=>base_url().'uploads/member/header/'.$v['headerurl'],
								'realname'=>$v['realname'],
								'grade'=>$fenarray['canyufen'],
							);
				}
				$receive['canyu']['member']=$res;
			}
			$invitstatus=0;
			//是否有邀请
			$inviteinfo=$this->invite->get_one_by_id(array('pid'=>$proid,'headid'=>$proinfo['headid'],'company_id'=>$company_id));
			if($inviteinfo){
				$invitstatus=$inviteinfo['status'];
			}
			$repjson = array(
       			'errcode'=>0,
		 		'errmsg'=>'ok' , 
		 		'projectinfo'=>$proinfo	,
		 		'receive'=>$receive,
				'invitstatus'=>$invitstatus,//0为等待1为接受2为拒绝
        	);
            $data=array('projectinfo'=>$proinfo	,
		 		'receive'=>$receive,
				'invitstatus'=>$invitstatus,
				);
         
			$this->load->view('api/project_detail_base',$data);	
			 
		}
	}
	//计算核心与参与的所得的分数$total总分,$num人数
	public function receivefen($total,$num,$type){
		if($type==1){//只有核心人物
			return array('hexinfen'=>$total,'canyufen'=>0);
		}
		if($type==2){//只有参与人员
			return array('hexinfen'=>0,'canyufen'=>((float)$total/$num));
		}
		if($type==0){//有核心又有参与人员
			$renfen=(float)$total/(3+($num));
			$hexin=(float)$renfen*3;
			return array('hexinfen'=>$hexin,'canyufen'=>$renfen);
		}
		return array('hexinfen'=>0,'canyufen'=>0);
	}

	//处理邀请复制请求
	public function do_request()
	{
		$data = $this->requestData();
		$mid = $data['data']['mid'];
		$token = $data['data']['token'];
		$proid = $data['data']['proid'];
		$status = $data['data']['status'];
		$company_id = $data['data']['company_id'];//所属管理员
		$config = array('p.id'=>$proid,'p.company_id'=>$company_id);
		$proinfo = $this->project->get_one_by_id($config);

		if(empty($proinfo)){
			$repjson = array(
       			'errcode'=>-1,
		 		'errmsg'=>'项目不存在',      	
        	);
			$this->responseData($repjson);
			exit;
		}

		//判断请求是否存在
		$this->load->model('invite_mdl','invite');
		$inviteconfig = array('pid'=>$proid,'headid'=>$mid,'company_id'=>$company_id);
		$result = $this->invite->get_one_by_id($inviteconfig);
		if(empty($result)){
			$repjson = array(
       			'errcode'=>-2,
		 		'errmsg'=>'请求不存在',      	
        	);
			$this->responseData($repjson);
			exit;
		}
		//已经处理过
		if($result['status'] != 0){
			$repjson = array(
       			'errcode'=>-3,
		 		'errmsg'=>'请求已经处理过，请勿重复处理',      	
        	);
			$this->responseData($repjson);
			exit;
		}

		//处理请求
		$updatedata = array('status'=>$status,'invite_time'=>time());
		$updateconfig = array('pid'=>$proid,'headid'=>$mid);

		$this->invite->update($updateconfig,$updatedata);
		$repjson = array(
       		'errcode'=>0,
		 	'errmsg'=>'请求处理成功',      	
        );
		$this->responseData($repjson);
		exit;

	}

	
	
	
	
	
	
	//修改项目
	public function projectupdate(){
		$member = $this->session->userdata('member'); 
		$data = $this->requestData();
		$mid = $member['id'];
		$company_id = $data['data']['company_id']?$data['data']['company_id']:1;//所属管理员
		
		$proid = $data['data']['proid'];//项目id
 
		if(!empty($mid) && !empty($proid)){
			$proinfo = $this->project->get_one_by_id(array('p.id'=>$proid));
			if($proinfo){
				if($mid !=$proinfo['mid']){
					$repjson = array(
						'errcode'=>-1,
						'errmsg'=>'抱歉，此项目无权操作' , 
					);
				}else{
					$updata['title'] = $data['data']['title'];
					$updata['intro'] = $data['data']['intro'];
					$updata['scale'] = $data['data']['scale'];
					$updata['difficulty'] = $data['data']['difficulty'];
					$updata['quality'] = $data['data']['quality'];
					$updata['features'] = $data['data']['features'];
					$updata['headid'] = $data['data']['headid'];//负责人id
					//$add['typeid'] = $data['data']['typeid'];//1为重大项目.2为基础项目
					$res=$this->project->update(array('id'=>$proid),$updata);
					if($res){
						//修改项目状态
						$up['status']=1;
						$this->project->update(array('id'=>$proid),$up);
						$this->invite->del(array('pid'=>$proid));
						//添加邀请记录
						$log['pid'] = $proid;
						$log['headid'] = $data['data']['headid'];
						$log['status'] = 0;
						$log['createtime'] = time();
						$log['company_id'] = $company_id;
						$this->load->model('invite_mdl','invite');
						$this->invite->add($log);
						$repjson = array(
							'tag'=>$data['tag'],  
							'errcode'=>0,
							'errmsg'=>'修改成功' ,	
							);
							
					}else{
						$repjson = array(
							'errcode'=>-1,
							'errmsg'=>'抱歉，修改失败或未修改数据' , 
						);
					}
				}
			}else{
				$repjson = array(
       			'errcode'=>-1,
		 		'errmsg'=>'抱歉，不存在此项目' , 
        	);
			}
		}else{
			$repjson = array(
       			'errcode'=>-1,
		 		'errmsg'=>'操作有误，请重试' , 
        	
        	);
		}
		$this->responseData($repjson);
	}
	
	
	//删除项目
	public function projectdel(){
		$member = $this->session->userdata('member'); 
		$data = $this->requestData();
		$mid = $member['id'];
		$company_id = $data['data']['company_id']?$data['data']['company_id']:1;//所属管理员
		
		
		$proid = $data['data']['proid'];//项目id
 
		if(!empty($mid) && !empty($proid)){
			$proinfo = $this->project->get_one_by_id(array('p.id'=>$proid,'p.company_id'=>$company_id));
			if($proinfo){
				if($mid !=$proinfo['mid']){
					$repjson = array(
						'errcode'=>-1,
						'errmsg'=>'抱歉，此项目无权操作' , 
					);
				}else{
					 //删除任务以及相关任务的数据
					 $tasklist= $this->task->select(array('proid'=>$proid,'company_id'=>$company_id));
					 if($tasklist){
						 foreach($tasklist as $k => $v){
							$task_fansi=$this->task_fansi->select(array('taskid'=>$v['id'],'company_id'=>$v['company_id']));
							if($task_fansi){
								 foreach($task_fansi as $k1 => $v1){
										$this->task_fansi_reply->del(array('fansiid'=>$v1['id'],'company_id'=>$v1['company_id']));
								 }
							}
							$this->task_fansi->del(array('taskid'=>$v['id'],'company_id'=>$v['company_id']));
							$task_plan=$this->task_plan->select(array('taskid'=>$v['id'],'company_id'=>$v['company_id']));
							if($task_plan){
								 foreach($task_plan as $k1 => $v1){
										$this->task_plan_reply->del(array('planid'=>$v1['id'],'company_id'=>$v1['company_id']));
								 }
							}
							$this->task_plan->del(array('taskid'=>$v['id'],'company_id'=>$v['company_id']));
							$task_wenti=$this->task_wenti->select(array('taskid'=>$v['id'],'company_id'=>$v['company_id']));
							if($task_wenti){
								 foreach($task_wenti as $k1 => $v1){
										$this->task_wenti_reply->del(array('taskid'=>$v1['id'],'company_id'=>$v1['company_id']));
								 }
							}
							$this->task_plan->del(array('taskid'=>$v['id']));
						 }
					 }
					 $this->task->del(array('proid'=>$proid,'company_id'=>$company_id));//删除项目对应的任务
					 //删除评审以及评审相关的数据
					 $reviewlist=$this->review->select(array('proid'=>$proid,'company_id'=>$company_id));
					 if($reviewlist){
						foreach($reviewlist as $k => $v){
							$review_question=$this->review_question->select(array('revid'=>$v['id'],'company_id'=>$v['company_id']));
							if($review_question){
								foreach($review_question as $k1 => $v1){
									$this->review_question_feedback->del(array('revid'=>$v1['id'],'company_id'=>$v['company_id']));
								}
							}
							$this->review_question->del(array('revid'=>$v['id'],'company_id'=>$v['company_id']));
							$this->review_staff->del(array('revid'=>$v['id'],'company_id'=>$v['company_id']));
							$this->review_task->del(array('revid'=>$v['id'],'company_id'=>$v['company_id']));
						}
					 }
					 $this->review->del(array('proid'=>$proid,'company_id'=>$company_id));
					 //删除项目负责人邀请表
					 $this->invite->del(array('pid'=>$proid,'company_id'=>$company_id));
					 //用户领取项目表
					 $this->member_task->del(array('projectid'=>$proid,'company_id'=>$company_id));
					 //删除项目统计
					$this->project_total->del(array('proid'=>$proid,'company_id'=>$admininfo['roleid']));
					 $this->project->del(array('id'=>$proid,'company_id'=>$company_id));//删除项目
					 $repjson = array(
						'errcode'=>0,
						'errmsg'=>'删除成功' , 
					);
				}
			}
		}else{
			$repjson = array(
       			'errcode'=>-1,
		 		'errmsg'=>'操作有误，请重试' , 
        	
        	);
		}
		$this->responseData($repjson);
	}
	
		
	//项目负责人邀请拒绝与同意
	public function invitestatus(){
	    $member = $this->session->userdata('member'); 
		$data = $this->requestData();
		$company_id = $data['data']['company_id']?$data['data']['company_id']:1;//所属管理员
	    $mid = $member['id'];
		
		$headid=$data['data']['headid'];//负责人id
		$proid=$data['data']['proid'];//项目id
		$type=$data['data']['type'];//1为接受，2为拒绝
 
		if(!empty($mid) && !empty($proid) && !empty($headid) && !empty($type)){
		 	$list=$this->invite->get_one_by_id(array('pid'=>$proid,'headid'=>$headid,'company_id'=>$company_id));

			if($list){
				$update['status']=$type;
				$update['invite_time']=time();
				$res=$this->invite->update(array('pid'=>$proid,'headid'=>$headid),$update);
				if($res){
					//修改项目状态
					$up['status']=2;
					$this->project->update(array('id'=>$proid),$up);
					$repjson = array(
						'tag'=>$data['tag'],  
						'errcode'=>0,
						'errmsg'=>'提交成功!' ,	
					);	
				}else{
					$repjson = array(
						'errcode'=>-1,
						'errmsg'=>'抱歉，修改失败或未修改数据' , 
					);
				}
			}else{
				$repjson = array(
					'errcode'=>-1,
					'errmsg'=>'抱歉，不存在此记录' , 
				
				);
			}
		}else{
			$repjson = array(
					'errcode'=>-1,
					'errmsg'=>'操作有误，请重试' , 
				
				);
			}
		$this->responseData($repjson);
	}
	
	
	//关闭重大项目
	public function closeproject(){
		$member = $this->session->userdata('member'); 
		$data = $this->requestData();
		$company_id = $data['data']['company_id']?$data['data']['company_id']:1;//所属管理员
	    $mid = $member['mid'];
		
		$proid = $data['data']['proid']; //项目id
		$typeid = $data['data']['typeid']; //1为重大项目2为基础项目

		$info['scale'] = $data['data']['scale'];
		$info['difficulty'] = $data['data']['difficulty'];
		$info['quality'] = $data['data']['quality'];
		$info['features'] = $data['data']['features'];
		$info['status']=0;
		$config = array('id'=>$proid);
		$proinfo = $this->project->get_one_by_id(array('p.id'=>$proid,'p.mid'=>$mid));
		if(empty($proinfo)){
			$repjson = array(
       			'errcode'=>-1,
		 		'errmsg'=>'项目不存在或无权关闭',      	
        	);
			$this->responseData($repjson);
			exit;
		}
		
		//计算公式
		$jsconfig = array('tags'=>'jisuan','company_id'=>$company_id);
		$js = array();
		$js = $this->gongshi->get_one_by_id($jsconfig);
		$jsgs = $js['info'];
		$j = array();
		if(!empty($jsgs)){
			$j1 =substr($jsgs, 1,1);
			$j2 =substr($jsgs, 3,1);
			$j3 =substr($jsgs, 5,1);
		} 
		
		if($typeid==1){
			$wtask['where']=array('t.proid'=>$proid,'t.company_id'=>$company_id);
			$tasklist = $this->task->getList($wtask);
			if($tasklist){
				foreach($tasklist as $k => $v){
					$taskinfo = $this->task->get_one_by_id(array('t.id'=>$v['id'],'t.company_id'=>$company_id));
					if(!empty($taskinfo)){
						$add['proid']=$proid;
						$add['proname']=$proinfo['title'];
						$add['company_id']=$company_id;
						$add['realname']=$proinfo['header'];
						if($proinfo['roleid']==1){
							$add['rolename']='员工';
						}else if($proinfo['roleid']==2){
							$add['rolename']='专家';
						}else{
							$add['rolename']='领导';
						}
						$add['modtitle']=$v['m_name'];
						$add['taskname']=$v['title'];
						$add['difficulty']=$taskinfo['difficulty'];
						$add['quality']=$taskinfo['quality'];
						$add['scale']=$taskinfo['scale'];
						$add['features']=$taskinfo['features'];
						$taskcount=0;
						$jg=0;
						$quality = $this->starval('3',$taskinfo['quality'],$company_id);
						$scale = $this->starval('1',$taskinfo['scale'],$company_id);
						$difficulty = $this->starval('2',$taskinfo['difficulty'],$company_id);
						$features =$this->starval('4',$taskinfo['features'],$company_id);
						eval("\$jg=$scale$j1$difficulty$j2$quality$j3$features;");
						$taskcount=$jg;//获取项目中某人物的分数
						
						$add['taskgrand']=$taskcount;
						
						$wmembertask['where']=array('taskid'=>$v['id'],'projectid'=>$proid,'typeid'=>1,'mt.company_id'=>$company_id);
						$membertasklist = $this->member_task->getList($wmembertask);
						$strname='';
						$strgrand='';
						$gstrname='';
						$gstrgrand='';
						
						if($membertasklist){
							foreach($membertasklist as $k1 => $v1){
								$result=$this->majorfen($v1['mid'],$v1['taskid'],$proid,$company_id);
								if(!empty($result['majorcount']) && !empty($result['role'])){
									if(!empty($strname)){
										$strname=$strname.','.$result['role'];
										$strgrand=$strgrand.','.$result['majorcount'];
									}else{
										$strname=$result['role'];
										$strgrand=$result['majorcount'];
									}
								}
								$add['lingname']=$strname;
								$add['linggrand']=$strgrand;
							}
							foreach($membertasklist as $k3 => $v3){
								$task = $data['data']['task'];//任务array
								if(!empty($task)){
									foreach($task as $k2 => $v2){
										if($v['id']==$v2['taskid']){
											$uptask['scale'] = $v2['scale'];
											$uptask['difficulty'] = $v2['difficulty'];
											$uptask['quality'] = $v2['quality'];
											$uptask['features'] = $v2['features'];
											$uptask['status']=0;
											$updateconfig = array('id'=>$v2['taskid']);
											$this->task->update($updateconfig,$uptask);
											$add['gdifficulty']=$v2['difficulty'];
											$add['gquality']=$v2['quality'];
											$add['gscale']=$v2['scale'];
											$add['gfeatures']=$v2['features'];
											$taskcount=0;
											$jg=0;
											$quality = $this->starval('3',$v2['quality'],$company_id);
											$scale = $this->starval('1',$v2['scale'],$company_id);
											$difficulty = $this->starval('2',$v2['difficulty'],$company_id);
											$features =$this->starval('4',$v2['features'],$company_id);
											eval("\$jg=$scale$j1$difficulty$j2$quality$j3$features;");
											$taskcount=$jg;//获取项目中某人物的分数
											$add['gtaskgrand']=$taskcount;
											
											$result=$this->majorfen($v3['mid'],$v3['taskid'],$proid,$company_id);
											if(!empty($result['majorcount']) && !empty($result['role'])){
												if(!empty($gstrname)){
													$gstrname=$gstrname.','.$result['role'];
													$gstrgrand=$gstrgrand.','.$result['majorcount'];
												}else{
													$gstrname=$result['role'];
													$gstrgrand=$result['majorcount'];
												}
											}
											$add['glingname']=$gstrname;
											$add['glinggrand']=$gstrgrand;
										}
									}
								}
							}
						}else{
							$task = $data['data']['task'];//任务array
							if(!empty($task)){
								foreach($task as $k2 => $v2){
									if($v['id']==$v2['taskid']){
										$uptask['scale'] = $v2['scale'];
										$uptask['difficulty'] = $v2['difficulty'];
										$uptask['quality'] = $v2['quality'];
										$uptask['features'] = $v2['features'];
										$uptask['status']=0;
										$updateconfig = array('id'=>$v2['taskid']);
										$this->task->update($updateconfig,$uptask);
										$add['gdifficulty']=$v2['difficulty'];
										$add['gquality']=$v2['quality'];
										$add['gscale']=$v2['scale'];
										$add['gfeatures']=$v2['features'];
										$taskcount=0;
										$jg=0;
										$quality = $this->starval('3',$v2['quality'],$company_id);
										$scale = $this->starval('1',$v2['scale'],$company_id);
										$difficulty = $this->starval('2',$v2['difficulty'],$company_id);
										$features =$this->starval('4',$v2['features'],$company_id);
										eval("\$jg=$scale$j1$difficulty$j2$quality$j3$features;");
										$taskcount=$jg;//获取项目中某人物的分数
										$add['gtaskgrand']=$taskcount;
									}
								}
							}
							$add['glingname']='';
							$add['glinggrand']='';
						}
					}
					$this->project_total->add($add);
				}
			}
		}
		
		if($typeid=='2'){
			$add['proid']=$proid;
			$add['proname']=$proinfo['title'];
			$add['realname']=$proinfo['header'];
			if($proinfo['roleid']==1){
				$add['rolename']='员工';
			}else if($proinfo['roleid']==2){
				$add['rolename']='专家';
			}else{
				$add['rolename']='领导';
			}
			$add['modtitle']='';
			$add['taskname']='';
			$add['company_id']=$company_id;
			$add['difficulty']=$proinfo['difficulty'];
			$add['quality']=$proinfo['quality'];
			$add['scale']=$proinfo['scale'];
			$add['features']=$proinfo['features'];
			$taskcount=0;
			$jg=0;
			$quality = $this->starval('3',$proinfo['quality'],$company_id);
			$scale = $this->starval('1',$proinfo['scale'],$company_id);
			$difficulty = $this->starval('2',$proinfo['difficulty'],$company_id);
			$features =$this->starval('4',$proinfo['features'],$company_id);
			eval("\$jg=$scale$j1$difficulty$j2$quality$j3$features;");
			$taskcount=$jg;//获取项目中某人物的分数
			$add['taskgrand']=$taskcount;
			$wmembertask['where']=array('mt.company_id'=>$company_id,'projectid'=>$proid,'typeid'=>2);
			$membertasklist = $this->member_task->getList($wmembertask);
			$strname='';
			$strgrand='';
			$gstrname='';
			$gstrgrand='';
			if($membertasklist){
				foreach($membertasklist as $k1 => $v1){
					$result=$this->basicfen($v1['mid'],$v1['projectid'],$company_id);
					if(!empty($result['majorcount']) && !empty($result['role'])){
						if(!empty($strname)){
							$strname=$strname.','.$result['role'];
							$strgrand=$strgrand.','.$result['majorcount'];
						}else{
							$strname=$result['role'];
							$strgrand=$result['majorcount'];
						}
					}
				}
			}
			$add['lingname']=$strname;
			$add['linggrand']=$strgrand;
			$info1['scale'] = $data['data']['scale'];
			$info1['difficulty'] = $data['data']['difficulty'];
			$info1['quality'] = $data['data']['quality'];
			$info1['features'] = $data['data']['features'];
			$this->project->update($config,$info1);
			$wmembertask['where']=array('mt.company_id'=>$company_id,'projectid'=>$proid,'typeid'=>2);
			$membertasklist = $this->member_task->getList($wmembertask);
			if($membertasklist){
				foreach($membertasklist as $k1 => $v1){
					$result=$this->basicfen($v1['mid'],$v1['projectid'],$company_id);
					if(!empty($result['majorcount']) && !empty($result['role'])){
						if(!empty($gstrname)){
							$gstrname=$gstrname.','.$result['role'];
							$gstrgrand=$gstrgrand.','.$result['majorcount'];
						}else{
							$gstrname=$result['role'];
							$gstrgrand=$result['majorcount'];
						}
					}
				}
			}
			$add['glingname']=$gstrname;
			$add['glinggrand']=$gstrgrand;
			$add['gdifficulty']=$data['data']['difficulty'];
			$add['gquality']=$data['data']['quality'];
			$add['gscale']=$data['data']['scale'];
			$add['gfeatures']=$data['data']['features'];
			$taskcount=0;
			$jg=0;
			$quality = $this->starval('3',$data['data']['quality'],$company_id);
			$scale = $this->starval('1',$data['data']['scale'],$company_id);
			$difficulty = $this->starval('2',$data['data']['difficulty'],$company_id);
			$features =$this->starval('4',$data['data']['features'],$company_id);
			eval("\$jg=$scale$j1$difficulty$j2$quality$j3$features;");
			$taskcount=$jg;//获取项目中某人物的分数
			$add['gtaskgrand']=$taskcount;
			$this->project_total->add($add);
		
		}
		$res=$this->project->update($config,$info);
		if($typeid==1){
			$task = $data['data']['task'];//任务array
			if(!empty($task)){
				$uptask = array();
				foreach($task as $k => $v){
					$uptask['scale'] = $v['scale'];
					$uptask['difficulty'] = $v['difficulty'];
					$uptask['quality'] = $v['quality'];
					$uptask['features'] = $v['features'];
					$uptask['status']=0;
					$updateconfig = array('id'=>$v['taskid']);
					$this->task->update($updateconfig,$uptask);
				}
			}
		}
		$repjson = array(
       		'errcode'=>0,
		 	'errmsg'=>'关闭成功',      	
        );
		$this->responseData($repjson);
		exit;
	}
	
	
	//重大项目计算分
	public function majorfen($mid,$taskid,$projectid,$company_id){
		//计算公式
		$jsconfig = array('tags'=>'jisuan','company_id'=>$company_id);
		$js = array();
		$js = $this->gongshi->get_one_by_id($jsconfig);
		$jsgs = $js['info'];
		$j = array();
		if(!empty($jsgs)){
			$j1 =substr($jsgs, 1,1);
			$j2 =substr($jsgs, 3,1);
			$j3 =substr($jsgs, 5,1);
		} 
		$result=array();
		$majorcount=0;
		$taskinfo = $this->task->get_one_by_id(array('t.id'=>$taskid,'t.company_id'=>$company_id));	
		$rolename="";
		if(!empty($taskinfo)){
			$quality=0;
			//获取指导中任务打分的数据
			//$task_markinglist=$this->task_marking->get_all(array('typeid'=>1,'taskid'=>$taskid));
//			if($task_markinglist){
//				$mcout=count($task_markinglist);
//				foreach($task_markinglist as $km => $vm){
//					$quality=(float)$quality+(float)$vm['score'];
//				}
//				eval("\$jgq=$quality/$mcout;");
//				$quality=$jgq;
//			}else{
			$quality = $this->starval('3',$taskinfo['quality'],$company_id);
			//}
			$taskcount=0;
			$scale = $this->starval('1',$taskinfo['scale'],$company_id);
			$difficulty = $this->starval('2',$taskinfo['difficulty'],$company_id);
			$features =$this->starval('4',$taskinfo['features'],$company_id);
			eval("\$jg=$scale$j1$difficulty$j2$quality$j3$features;");
			
			$taskcount=$jg;//获取项目中某人物的分数
		
			//领取情况,1-独立,2-核心,3-参与
			$dulilist=$this->member_task->get_one_by_id(array('projectid'=>$projectid,'roleid'=>1,'mid'=>$mid,'taskid'=>$taskid,'company_id'=>$company_id));
			if($dulilist){
				$rolename=$dulilist['realname'];
				$majorcount=(float)$majorcount+(float)$taskcount;
				//echo (float)$taskcount.'cc';
			}
			$canyulistcout=$this->member_task->get_all(array('projectid'=>$projectid,'taskid'=>$taskid,'roleid'=>3,'company_id'=>$company_id));
			$hexinlistcout=$this->member_task->get_all(array('projectid'=>$projectid,'taskid'=>$taskid,'roleid'=>2,'company_id'=>$company_id));
			
			$hexinlist=$this->member_task->get_one_by_id(array('projectid'=>$projectid,'roleid'=>2,'mid'=>$mid,'taskid'=>$taskid,'company_id'=>$company_id));
			if($hexinlist){
				$rolename=$hexinlist['realname'];
				if($canyulistcout){
					$fenarray=$this->receivefen($taskcount,(count($canyulistcout)),0);
					$majorcount=(float)$majorcount+(float)$fenarray['hexinfen'];
					//echo (float)$fenarray['hexinfen'].'dd';
				}else{
					$fenarray=$this->receivefen($taskcount,1,1);
					$majorcount=(float)$majorcount+(float)$fenarray['hexinfen'];
					//echo (float)$fenarray['hexinfen'].'ff';
				}
			}
			$canyulist=$this->member_task->get_all(array('projectid'=>$projectid,'roleid'=>3,'mid'=>$mid,'taskid'=>$taskid,'company_id'=>$company_id));
			if($canyulist){
				$rolename=$canyulist[0]['realname'];
				if($hexinlistcout){
					$fenarray=$this->receivefen($taskcount,(count($canyulistcout)),0);
					$majorcount=(float)$majorcount+(float)$fenarray['canyufen'];
					//echo (float)$fenarray['canyufen'].'ggg';
				}else{
					$fenarray=$this->receivefen($taskcount,(count($canyulistcout)),2);
					$majorcount=(float)$majorcount+(float)$fenarray['canyufen'];
					//echo (float)$fenarray['canyufen'].'hh';
				}
			}
		}
		$result=array('majorcount'=>$majorcount,'role'=>$rolename,'taskcount'=>$taskcount);
		return $result;
	}
	
	
	//基础项目分
	public function basicfen($mid,$projectid,$company_id){
		//计算公式
		$jsconfig = array('tags'=>'jisuan','company_id'=>$company_id);
		$js = array();
		$js = $this->gongshi->get_one_by_id($jsconfig);
		$jsgs = $js['info'];
		$j = array();
		if(!empty($jsgs)){
			$j1 =substr($jsgs, 1,1);
			$j2 =substr($jsgs, 3,1);
			$j3 =substr($jsgs, 5,1);
		} 
		$basiccount=0; 
		$proinfo = $this->project->get_one_by_id(array('p.id'=>$projectid,'p.company_id'=>$company_id));
		if($proinfo){
			$procount=0;
			$quality=0;
			//$task_markinglist=$this->task_marking->get_all(array('typeid'=>2,'projectid'=>$projectid,'company_id'=>$company_id));
//			if($task_markinglist){
//				$mcout=count($task_markinglist);
//				foreach($task_markinglist as $km => $vm){
//					$quality=(float)$quality+(float)$vm['score'];
//				}
//				eval("\$jgq=$quality/$mcout;");
//				$quality=$jgq;
//			}else{
			$quality = $this->starval('3',$proinfo['quality'],$company_id);
			//}
			$scale = $this->starval('1',$proinfo['scale'],$company_id);
			$difficulty = $this->starval('2',$proinfo['difficulty'],$company_id);
			
			$features =$this->starval('4',$proinfo['features'],$company_id);
			eval("\$jg=$scale$j1$difficulty$j2$quality$j3$features;");
			$rolename='';
			$procount= $jg; //标准分
			//领取情况,1-独立,2-核心,3-参与
			$dulilist=$this->member_task->get_one_by_id(array('projectid'=>$projectid,'roleid'=>1,'mid'=>$mid,'company_id'=>$company_id));
			if($dulilist){
				$rolename=$dulilist['realname'];
				$basiccount=(float)$basiccount+(float)$procount;
				//echo $basiccount.'cc';
			}
			$canyulistcout=$this->member_task->get_all(array('projectid'=>$projectid,'roleid'=>3,'company_id'=>$company_id));
			$hexinlistcout=$this->member_task->get_all(array('projectid'=>$projectid,'roleid'=>2,'company_id'=>$company_id));
			$hexinlist=$this->member_task->get_one_by_id(array('projectid'=>$projectid,'roleid'=>2,'mid'=>$mid,'company_id'=>$company_id));
			if($hexinlist){
				$rolename=$hexinlist['realname'];
				if($canyulistcout){
					$fenarray=$this->receivefen($procount,(count($canyulistcout)),0);
					$basiccount=(float)$basiccount+(float)$fenarray['hexinfen'];
					//echo (float)$fenarray['canyufen'].'dd';
				}else{
					$fenarray=$this->receivefen($procount,1,1);
					$basiccount=(float)$basiccount+(float)$fenarray['hexinfen'];
					//echo (float)$fenarray['hexinfen'].'ff';
				}
			}
			$canyulist=$this->member_task->get_all(array('projectid'=>$projectid,'roleid'=>3,'mid'=>$mid,'company_id'=>$company_id));
			if($canyulist){
				$rolename=$canyulist[0]['realname'];
				if($hexinlistcout){
					$fenarray=$this->receivefen($procount,(count($canyulistcout)),0);
					$basiccount=(float)$basiccount+(float)$fenarray['canyufen'];
					//echo (float)$fenarray['canyufen'].'ggg';
				}else{
					$fenarray=$this->receivefen($procount,(count($canyulistcout)),2);
					$basiccount=(float)$basiccount+(float)$fenarray['canyufen'];
					//echo (float)$fenarray['canyufen'].'hh';
				}
			}
			
		}
		$result=array('majorcount'=>$basiccount,'role'=>$rolename,'taskcount'=>$procount);
		return $result;
	}
}
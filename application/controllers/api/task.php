<?php
/**
*
*@dec 用户领取任务
*/


class Task extends Api_Controller
{




	public function __construct()
	{
		parent::__construct();
		$this->load->model('task_mdl','task');
		$this->load->model('member_task_mdl','member_task');
		$this->load->model('task_type_mdl','task_type');
		$this->load->model('star_mdl','star');
		$this->load->model('gongshi_mdl','gongshi');
		$this->load->model('task_marking_mdl','task_marking');
		$this->load->model('member_mdl','member');
		$this->load->model('project_mdl','project');
		$this->load->model('member_qi_mdl','member_qi');
		$this->load->model('conquer_reply_mdl','conquer_reply');
		$this->load->model('task_fansi_mdl','task_fansi');
		$this->load->model('task_fansi_reply_mdl','task_fansi_reply');
		$this->load->model('task_plan_mdl','task_plan');
		$this->load->model('task_plan_reply_mdl','task_plan_reply');
		$this->load->model('task_wenti_mdl','task_wenti');
		$this->load->model('task_wenti_reply_mdl','task_wenti_reply');
		$this->load->library('session');
	}

	//用户可以领取的任务--以模块方式展示
	public function projectlist()
	{
		$data = $this->requestData();
		$depid = $data['data']['depid'];
		$this->load->model('task_mdl','task');
		$where['where'] = array('project.t_depid'=>$depid);
		$list = $this->task->getList($where);
	}


	/**创建任务-在模块下追加任务**/
	/*
    @param string tag 接口名称
	@param int mid 用户id
	@param string token  token
	@param string title  任务名称
	@param int scale 规模
	@param int difficulty 难度
	@param int quality质量
	@param int features  特性
	@param int modid 模块id
	@param int proid 项目id
	*/
	public function create()
	{
		$data = $this->requestData();
		$mid = $data['data']['mid'];
		$token = $data['data']['token'];
		$num = 0;
		$task = $data['data']['task'];
		$modid= $data['data']['modid'];
		$proid = $data['data']['proid'];
		$company_id = $data['data']['company_id'];//所属管理员
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
				$addtask['proid'] = $proid;
				$addtask['company_id'] = $company_id;
				$addtask['createtime'] = time();
				$addtask['mid'] = $mid;
				$addtask['task_type'] = $v['task_type'];
					if($this->task->add($addtask)){				
						$num++;
					}
				}
			}
			$repjson = array(
		       	'errcode'=>0,
				'errmsg'=>'添加成功',
				'data'=>array('num'=>$num)		        	
		       );
		    $this->responseData($repjson);

		}else{
			$repjson = array(
		        'errcode'=>-3,
				'errmsg'=>'没有任务信息'		        	
		    );
			$this->responseData($repjson);
		}
		
	}

	//模块更多
	public function moretaskbymod()
	{
		$data = $this->requestData();
		$mid = $data['data']['mid'];
		$company_id = $data['data']['company_id'];//所属管理员
		$this->load->model('task_mdl','task');
		$where['where'] = array('t.mid'=>$mid,'t.company_id'=>$company_id);
		$totalnum = $this->task->get_count(array('mid'=>$mid,'company_id'=>$company_id));
		$list = $this->task->getList($where);
		$task = array();
		if(!empty($list)){
			foreach($list as $k =>$v){
				$tmp['id'] = $v['id'];
				$tmp['title'] = $v['t_name'];
				$tmp['total'] = $v['t_score'];
				$tmp['icon'] = base_url().'uploads/task/'.$v['icon'];
				$tmp['projectname'] = $v['projectname'];
				$tmp['status'] = $v['status'];
				$task[] = $tmp;
			}
		}
		$repjson = array(
 			'tag'=>$data['tag'], 
 			'errcode'=>0,
		 	'errmsg'=>'ok' ,   	
        	'total'=>$totalnum,//数据总数
        	'data'=>$task, //当前请求的数据列表
        	);
		$this->responseData($repjson);
	}


	//项目更多
	public function moretaskbyproject()
	{
		$data = $this->requestData();
		$pid = $data['data']['pid'];
		$company_id = $data['data']['company_id'];//所属管理员
		$this->load->model('task_mdl','task');
		$where['where'] = array('t.pid'=>$pid,'t.company_id'=>$company_id);
		$totalnum = $this->task->get_count(array('pid'=>$pid,'company_id'=>$company_id));
		$list = $this->task->getList($where);
		$task = array();
		if(!empty($list)){
			foreach($list as $k =>$v){
				$tmp['id'] = $v['id'];
				$tmp['title'] = $v['t_name'];
				$tmp['total'] = $v['t_score'];
				$tmp['icon'] = base_url().'uploads/task/'.$v['icon'];
				$tmp['projectname'] = $v['projectname'];
				$tmp['status'] = $v['status'];
				$task[] = $tmp;
			}
		}
		$repjson = array(
 			'tag'=>$data['tag'],  
 			'errcode'=>0,
		 	'errmsg'=>'ok' ,  	
        	'total'=>$totalnum,//数据总数
        	'data'=>$task, //当前请求的数据列表
        	);
		$this->responseData($repjson);
	}

	//领取任务前查看任务信息
	/**
	*返回
	*1。任务标题
	*2.任务描述
	*3.所属项目名称
	*4.领取情况
	*
	**/
	public function detail()
	{
		
	    $member = $this->session->userdata('member'); 
		$data = $this->requestData();
		$mid = $member['id'];
        $company_id = $data['data']['company_id']?$data['data']['company_id']:1;//所属管理员
		
		
		//$mid = $data['data']['mid'];
 
		$taskid = $data['data']['taskid'];
 
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
		//任务信息
		$config = array('t.id'=>$taskid,'t.company_id'=>$company_id);
		$info = $this->task->get_one_by_id($config);
		if(empty($info)){
			$repjson = array('errcode'=>-1,'errmsg'=>'任务不存在');
			$this->responseData($repjson);
		}
		
		$scale = $this->starval('1',$info['scale'],$company_id);
		$difficulty = $this->starval('2',$info['difficulty'],$company_id);
		$quality=0;
		//获取指导中任务打分的数据
		//$task_markinglist=$this->task_marking->get_all(array('typeid'=>2,'projectid'=>$info['id']));
//		if($task_markinglist){
//			$mcout=count($task_markinglist);
//			foreach($task_markinglist as $km => $vm){
//				$quality=(float)$quality+(float)$vm['score'];
//			}
//			eval("\$jgq=$quality/$mcout;");
//			$quality=$jgq;
//		}else{
		$quality = $this->starval('3',$info['quality'],$company_id);
		//}
		
		$features =$this->starval('4',$info['features'],$company_id);
		eval("\$jg=$scale$j1$difficulty$j2$quality$j3$features;");
		$proinfo['total'] = $jg; //标准分
		//领取总人数
		$membercount=$this->member_task->get_count(array('taskid'=>$taskid,'company_id'=>$company_id));
		$proinfo['receive_num'] = $membercount;
		$receive=null;
		//领取情况,1-独立,2-核心,3-参与
		$dulilist=$this->member_task->get_one_by_id(array('taskid'=>$taskid,'roleid'=>1,'company_id'=>$company_id));
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
		
		$hexinlist=$this->member_task->get_one_by_id(array('taskid'=>$taskid,'roleid'=>2,'company_id'=>$company_id));
		$canyulist=$this->member_task->get_all(array('taskid'=>$taskid,'roleid'=>3,'company_id'=>$company_id));
		//核心
		if($hexinlist){
			if($canyulist){
				$fenarray=$this->receivefen($jg,(count($canyulist)),0);
			}else{
				$fenarray=$this->receivefen($jg,1,1);
			}
			$receive['hexin']['grade'] =$fenarray['hexinfen'];
			$receive['hexin']['member'][]=array(
										'uid'=>'',
										'header'=>base_url().$hexinlist['headerurl'],
										'realname'=>$hexinlist['realname'],
										'grade'=>$fenarray['hexinfen']
									);
		}
		//参于
		if($canyulist){
			if($hexinlist){
				$fenarray=$this->receivefen($jg,(count($canyulist)),0);
			}else{
				$fenarray=$this->receivefen($jg,(count($canyulist)),2);
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
		$repjson = array(
		 		'tag'=>$data['tag'],  
		 		'errcode'=>0,
		 		'errmsg'=>'ok' ,
		 		'data'=>array(
		 			'taskinfo'=>$info,
		 			'member_task'=>$receive
		 			)
		);
		$this->responseData($repjson);
	}

	/**
	*@修改
	*
	**/
	public function update()
	{   
	    $member = $this->session->userdata('member'); 
		$data = $this->requestData();
		$mid = $member['id'];
		if($_POST){
		
        $taskid = $data['data']['taskid'];
		$title = $data['data']['title'];
		$intro = $data['data']['intro'];
		$scale = $data['data']['scale'];
		$difficulty = $data['data']['difficulty'];
		$quality = $data['data']['quality'];
		$features = $data['data']['features'];

		//判断是否是任务创建者
		$config = array('t.mid'=>$mid,'t.id'=>$taskid);
		$info = $this->task->get_one_by_id($config);
		if(empty($info)){
			$repjson = array(
		 		'tag'=>$data['tag'],  
		 		'errcode'=>-1,
		 		'errmsg'=>$taskid,
		      );
			$this->responseData($repjson);
			exit;
		}

		$addtask['title'] = $title;
		$addtask['intro'] = $intro;
		$addtask['scale'] = $scale;
		$addtask['difficulty'] = $difficulty;
		$addtask['quality'] = $quality;
		$addtask['features'] = $features;
		$updateconfig = array('id'=>$taskid);
		$this->task->update($updateconfig,$addtask);

		$repjson = array(
		 		'tag'=>$data['tag'],  
		 		'errcode'=>0,
		 		'errmsg'=>'修改成功' ,
		 		
		      );
		$this->responseData($repjson);
		exit;
		
		}else{
		
		 $data=array('list'=>$list);
		// var_dump($data);
	     $this->load->view('api/edit_task.php',$data);		
			
			}

	}

	//领取
	public function receive()
	{
		
		
		$member = $this->session->userdata('member'); 
		$data = $this->requestData();
		$mid = $member['id'];
        $company_id = $data['data']['company_id']?$data['data']['company_id']:1;//所属管理员
		$taskid = $data['data']['taskid'];
	   // $mid = $data['data']['mid'];
		$modid = $data['data']['modid'];
		$pid = $data['data']['proid'];
		$roleid = $data['data']['roleid'];
		$typeid = $data['data']['typeid'];
		$company_id = $data['data']['company_id'];//所属管理员
		$this->load->model('member_task_mdl','member_task');
		$add['projectid'] = $pid; //项目ID
		$add['modid'] = $modid;   //模块ID
		$add['mid'] = $mid;       //用户ID
		$add['roleid'] = $roleid;  //领取角色 1-独立,2-核心,3-参与
		$add['taskid'] = $taskid;      //任务ID
		$add['createtime'] = time(); //领取时间
		$add['typeid']=$typeid;
		
		$rolewhere=array();
		$duliwhere=array();
		//判断此任务是否已被独立领取了
		if($typeid == 1){ //重大项目
			$duliwhere=array('taskid'=>$taskid,'roleid'=>1,'modid'=>$modid,'company_id'=>$company_id);
		}elseif($typeid == 2){ //基础项目
			$duliwhere=array('projectid'=>$pid,'roleid'=>1,'company_id'=>$company_id);
		}
		if($duliwhere){
			$roleduliuser=$this->member_task->get_one_by_id($duliwhere);
			
			if(!empty($roleduliuser)){
				$repjson = array(
					'tag'=>$data['tag'],  
					'errcode'=>-1,
					'errmsg'=>'抱歉，此任务已被独立领取！' ,	
				  );
				$this->responseData($repjson);
				exit;
			}
		}
		$where1=array();
		if($roleid==1){
			if($typeid == 1){ //重大项目
				$where1=array('taskid'=>$taskid,'modid'=>$modid,'company_id'=>$company_id);
			}elseif($typeid == 2){ //基础项目
				$where1=array('projectid'=>$pid,'company_id'=>$company_id);
			}
			if($where1){
				$role1=$this->member_task->get_one_by_id($where1);
				if(!empty($role1)){
					$repjson = array(
						'tag'=>$data['tag'],  
						'errcode'=>-1,
						'errmsg'=>'抱歉，此任务已被领取！' ,	
					  );
					$this->responseData($repjson);
					exit;
				}
			}
		}
		//判断领取角色
		if($typeid == 1){ //重大项目
			if($roleid==1){
				$rolewhere=array('taskid'=>$taskid,'roleid'=>1,'modid'=>$modid,'company_id'=>$company_id);
			}
			if($roleid==2){
				$rolewhere=array('taskid'=>$taskid,'roleid'=>2,'modid'=>$modid,'company_id'=>$company_id);
			}
		}elseif($typeid == 2){ //基础项目
			if($roleid==1){
				$rolewhere=array('projectid'=>$pid,'roleid'=>1,'company_id'=>$company_id);
			}
			if($roleid==2){
				$rolewhere=array('projectid'=>$pid,'roleid'=>2,'company_id'=>$company_id);
			}
		}
		if($rolewhere){
			$roleuser=$this->member_task->get_one_by_id($rolewhere);
			if(!empty($roleuser)){
				$repjson = array(
					'tag'=>$data['tag'],  
					'errcode'=>-1,
					'errmsg'=>'抱歉，此角色已被领取！' ,	
				  );
				$this->responseData($repjson);
				exit;
			}
		}

		//判断是否已经领取
		if($typeid == 1){ //重大项目
			$uconfig = array('taskid'=>$taskid,'mid'=>$mid,'company_id'=>$company_id);
		}elseif($typeid == 2){ //基础项目
			$uconfig = array('projectid'=>$pid,'mid'=>$mid,'company_id'=>$company_id);
		}
		$checkuser = $this->member_task->get_one_by_id($uconfig);
		if(!empty($checkuser)){
			$repjson = array(
		 		'tag'=>$data['tag'],  
		 		'errcode'=>-1,
		 		'errmsg'=>'不能重复领取' ,	
		      );
			$this->responseData($repjson);
			exit;
		}

		$this->member_task->add($add);
		//统计个人得分
		$userfen=$this->userinfofen($mid,$company_id);
		if($userfen){
			$config = array('id'=>$mid);
        	$updatedata['integraltotal'] = $userfen['total'];
        	$this->member->update($config,$updatedata);
		}
		$repjson = array(
		 		'tag'=>$data['tag'],  
		 		'errcode'=>0,
		 		'errmsg'=>'任务领取成功' ,	
		      );
		$this->responseData($repjson);


	}

	//获取任务类型
	public function task_type()
	{
	    $member = $this->session->userdata('member'); 
		$data = $this->requestData();
		$mid = $member['id'];
        $company_id = $data['data']['company_id']?$data['data']['company_id']:1;//所属管理员
		$modid = $data['data']['modid'];
		 
		 $list = array();
		$where['where']=array('modid'=>$modid,'company_id'=>$company_id);
		$where['page']=false;
		$list = $this->task_type->getList($where);

		$repjson = array(
		 		'tag'=>$data['tag'],  
		 		'errcode'=>0,
		 		'errmsg'=>'ok' ,
		 		'data' => $list	
		      );
	     $data=array('list'=>$list);
		// var_dump($data);
	     $this->load->view('api/ajax/create_task.php',$data);		  
  


	}


	//统计会员所得分
	public function userinfofen($mid,$company_id){
		if(!empty($mid)){
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
			//重大项目积分数
			$where['where'] = array('mid'=>$mid,'typeid'=>1,'company_id'=>$company_id);
			//$where['group'] ="projectid";
			$prolist = $this->member_task->get_membertask_project($where);
			$majorcount=0;
			if($prolist){
				foreach($prolist as $k => $v){
					$where['where'] = array('t.proid'=>$v['id'],'t.company_id'=>$company_id);
					$where['order']=array('key'=>'task_type','value'=>'asc');
					$taskinfo = $this->task->get_one_by_id(array('t.id'=>$v['taskid'],'t.company_id'=>$company_id));
				
					if(!empty($taskinfo)){
						$quality=0;
						//获取指导中任务打分的数据
						//$task_markinglist=$this->task_marking->get_all(array('typeid'=>1,'taskid'=>$v['taskid']));
//						if($task_markinglist){
//							$mcout=count($task_markinglist);
//							foreach($task_markinglist as $km => $vm){
//								$quality=(float)$quality+(float)$vm['score'];
//							}
//							eval("\$jgq=$quality/$mcout;");
//							$quality=$jgq;
//						}else{
						$quality = $this->starval('3',$taskinfo['quality'],$company_id);
						//}
						$taskcount=0;
						$scale = $this->starval('1',$taskinfo['scale'],$company_id);
						$difficulty = $this->starval('2',$taskinfo['difficulty'],$company_id);
						$features =$this->starval('4',$taskinfo['features'],$company_id);
						eval("\$jg=$scale$j1$difficulty$j2$quality$j3$features;");
						
						$taskcount=$jg;//获取项目中某人物的分数
					
						//领取情况,1-独立,2-核心,3-参与
						$dulilist=$this->member_task->get_one_by_id(array('projectid'=>$v['projectid'],'roleid'=>1,'mid'=>$mid,'taskid'=>$v['taskid'],'company_id'=>$company_id));
						if($dulilist){
							$majorcount=(float)$majorcount+(float)$taskcount;
							//echo (float)$taskcount.'cc';
						}
						$canyulistcout=$this->member_task->get_all(array('projectid'=>$v['projectid'],'taskid'=>$v['taskid'],'roleid'=>3,'company_id'=>$company_id));
						$hexinlistcout=$this->member_task->get_all(array('projectid'=>$v['projectid'],'taskid'=>$v['taskid'],'roleid'=>2,'company_id'=>$company_id));
						$hexinlist=$this->member_task->get_one_by_id(array('projectid'=>$v['projectid'],'roleid'=>2,'mid'=>$mid,'taskid'=>$v['taskid'],'company_id'=>$company_id));
						if($hexinlist){
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
						$canyulist=$this->member_task->get_all(array('projectid'=>$v['projectid'],'roleid'=>3,'mid'=>$mid,'taskid'=>$v['taskid'],'company_id'=>$company_id));
						if($canyulist){
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
				}
			}
			//基础项目
			$wherebasic['where'] = array('mid'=>$mid,'typeid'=>2,'company_id'=>$company_id);
			//$wherebasic['group'] ="projectid";
			$probasiclist = $this->member_task->get_membertask_project($wherebasic);
			$basiccount=0;
			if($probasiclist){
				foreach($probasiclist as $k => $v){
					$proinfo = $this->project->get_one_by_id(array('p.id'=>$v['projectid'],'p.company_id'=>$company_id));
					if($proinfo){
						$procount=0;
						$quality=0;
						$task_markinglist=$this->task_marking->get_all(array('typeid'=>2,'projectid'=>$v['projectid'],'company_id'=>$company_id));
						if($task_markinglist){
							$mcout=count($task_markinglist);
							foreach($task_markinglist as $km => $vm){
								$quality=(float)$quality+(float)$vm['score'];
							}
							eval("\$jgq=$quality/$mcout;");
							$quality=$jgq;
						}else{
							$quality = $this->starval('3',$proinfo['quality'],$company_id);
						}
						$scale = $this->starval('1',$proinfo['scale'],$company_id);
						$difficulty = $this->starval('2',$proinfo['difficulty'],$company_id);
						
						$features =$this->starval('4',$proinfo['features'],$company_id);
						eval("\$jg=$scale$j1$difficulty$j2$quality$j3$features;");
						$procount= $jg; //标准分
						//领取情况,1-独立,2-核心,3-参与
						$dulilist=$this->member_task->get_one_by_id(array('projectid'=>$v['projectid'],'roleid'=>1,'mid'=>$mid,'company_id'=>$company_id));
						if($dulilist){
							$basiccount=(float)$basiccount+(float)$procount;
							//echo $basiccount.'cc';
						}
						$canyulistcout=$this->member_task->get_all(array('projectid'=>$v['projectid'],'roleid'=>3,'company_id'=>$company_id));
						$hexinlistcout=$this->member_task->get_all(array('projectid'=>$v['projectid'],'roleid'=>2,'company_id'=>$company_id));
						$hexinlist=$this->member_task->get_one_by_id(array('projectid'=>$v['projectid'],'roleid'=>2,'mid'=>$mid,'company_id'=>$company_id));
						if($hexinlist){
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
						$canyulist=$this->member_task->get_all(array('projectid'=>$v['projectid'],'roleid'=>3,'mid'=>$mid,'company_id'=>$company_id));
						if($canyulist){
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
				}
			}
			$conquercount=0;
			$peoplecount=0;
			
			//复盘分数
			$whereconquerreply['where']=array('c.mid'=>$mid,'c.isbest'=>1,'c.company_id'=>$company_id);
			$conquerreplylist=$this->conquer_reply->getList($whereconquerreply);
			if($conquerreplylist){
				foreach($conquerreplylist as $k => $v){
					$conquercount=$conquercount+(float)$v['total'];
				}
			}
			//人气分数
			$qiinfo=$this->member_qi->get_one_by_where(array('mid'=>$mid,'company_id'=>$company_id));
			if($qiinfo){
				$peoplecount=$qiinfo['total'];
			}
			$total=(float)$majorcount+(float)$basiccount+(float)$conquercount+(float)$peoplecount;
			$data=array(
					'majorcount'=>$majorcount,//重大项目分数
					'basiccount'=>$basiccount,//基础项目分数
					'conquercount'=>$conquercount,//复盘项目分数
					'peoplecount'=>$peoplecount,//人气分数
					'total'=>$total,//总分数
					);
			return $data;
		}
	
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



	//删除任务
	public function task_del(){
		
		$member = $this->session->userdata('member'); 
		$data = $this->requestData();
		$mid = $member['id'];
        $company_id = $data['data']['company_id']?$data['data']['company_id']:1;//所属管理员
		
		$taskid = $data['data']['taskid'];//任务id
 
//		//判断是否已经领取
//		$uconfig = array('taskid'=>$taskid,'mid'=>$mid);
//		$checkuser = $this->member_task->get_one_by_id($uconfig);
		//删除任务以及相关任务的数据

		$task_fansi=$this->task_fansi->select(array('taskid'=>$taskid,'company_id'=>$company_id));
		if($task_fansi){
			 foreach($task_fansi as $k1 => $v1){
					$this->task_fansi_reply->del(array('fansiid'=>$v1['id'],'company_id'=>$company_id));
			 }
		}
		$this->task_fansi->del(array('taskid'=>$taskid,'company_id'=>$company_id));
		$task_plan=$this->task_plan->select(array('taskid'=>$taskid,'company_id'=>$company_id));
		if($task_plan){
			 foreach($task_plan as $k1 => $v1){
					$this->task_plan_reply->del(array('planid'=>$v1['id'],'company_id'=>$company_id));
			 }
		}
		$this->task_plan->del(array('taskid'=>$taskid,'company_id'=>$company_id));
		$task_wenti=$this->task_wenti->select(array('taskid'=>$taskid,'company_id'=>$company_id));
		if($task_wenti){
			 foreach($task_wenti as $k1 => $v1){
					$this->task_wenti_reply->del(array('taskid'=>$v1['id'],'company_id'=>$company_id));
			 }
		}
		$this->task_plan->del(array('taskid'=>$taskid,'company_id'=>$company_id));
		$this->task->del(array('id'=>$taskid,'company_id'=>$company_id));//删除项目对应的任务
		$this->task_marking->del(array('taskid'=>$taskid,'company_id'=>$company_id));//删除项目对应的任务
		$this->member_task->del(array('taskid'=>$taskid,'company_id'=>$company_id));//删除项目对应的任务
		$repjson = array(
				'errcode'=>0,
				'errmsg'=>'删除成功' , 
			);
		$this->responseData($repjson);
	
	}
}
<?php
/**
*@评审Controller
*
**/

class Review extends Api_Controller
{

	public function __construct()
	{
		parent::__construct();	
		$this->load->model('review_mdl','review');
		$this->load->model('review_question_mdl','review_question');
		$this->load->model('review_question_feedback_mdl','review_question_feedback');
		$this->load->model('review_staff_mdl','review_staff');
		$this->load->model('review_task_mdl','review_task');
		$this->load->model('task_mdl','task');
		$this->load->model('project_mdl','project');
		$this->load->model('star_mdl','star');
		$this->load->model('review_praise_mdl','review_praise');
		$this->load->model('gongshi_mdl','gongshi');
		$this->load->model('member_qi_mdl','member_qi');
		$this->load->model('mod_mdl','mod');
		
	}


	public function index()
	{

	}

	//发起评审
	public function do_review()
	{
		$member = $this->session->userdata('member'); 
		$data = $this->requestData();
		$mid = $member['id'];
		$company_id = $data['data']['company_id']?$data['data']['company_id']:1;//所属管理员 
		$proid = $data['data']['proid']; //项目id
				if($_POST && $mid){

		$modid = $data['data']['modid']; //模块id
		$intro = $data['data']['intro']; //会议内容
		$staff = $data['data']['staff']; //参与人员
		//$review = $data['data']['review']; //评审问题
		 
		$endtime = $data['data']['endtime']; //评审截止时间
		if(!empty($proid) && !empty($mid) && !empty($staff) && !empty($endtime)){
			$revinfo = $this->review->get_one_by_id1(array('proid'=>$proid,'modid'=>$modid,'company_id'=>$company_id));
			
			if($revinfo){
					$repjson = array(
					'tag'=>$data['tag'],  
					'errcode'=>-1,
					'errmsg'=>'抱歉，此项目中模块已发起过评审！' ,	
				  );
				$this->responseData($repjson);
			}else{
				$review_add['mid'] = $mid;
				$review_add['proid'] = $proid;
				$review_add['modid'] = $modid;
				$review_add['status'] = 1;
				$review_add['intro'] = $intro;
				$review_add['endtime'] = strtotime($endtime);
				$review_add['createtime'] = time();
				$review_add['company_id'] = $company_id;
				//添加评审信息
				$this->review->add($review_add);
				$revid = $this->review->insert_id();

				//添加评审人员
				if(!empty($staff)){
					$staffarr = explode(',', $staff);
					if(!empty($staffarr)){
						foreach($staffarr as $sk => $sv){
							$staffrev['revid'] = $revid;
							$staffrev['mid'] = $sv;
							$staffrev['company_id'] = $company_id;
							$staffrev['createtime'] = time();
							$this->review_staff->add($staffrev);
						}
					}
				}
				$repjson = array(
					'tag'=>$data['tag'],  
					'errcode'=>0,
					'errmsg'=>'评审发起成功' ,	
				  );
				$this->responseData($repjson);
			}
		}else{
			$repjson = array(
		 		'tag'=>$data['tag'],  
		 		'errcode'=>-1,
		 		'errmsg'=>'评审发起失败，缺少必要参数' ,	
		      );
			$this->responseData($repjson);
		}
		}else{
			  $config = array('p.id'=>$proid,'p.company_id'=>$company_id);
			  $proinfo = $this->project->get_one_by_id($config);
 
			 $data = array('proinfo'=>$proinfo,'company_id'=>$company_id);
 
		      $this->load->view('api/review_do',$data);	
			}

	}
	
	//评审列表参与列表
	public function review_list()
	{
		 $member = $this->session->userdata('member'); 
		$data = $this->requestData();
		$mid = $member['id'];
		
		$company_id = $data['data']['company_id']?$data['data']['company_id']:1;//所属管理员 
		 if(empty($member)){
		 redirect('d=api&c=login','','','抱歉,请先登录');
	      exit;
		}
		
		$types = $data['data']['types'];
		
		$limit = !empty($data['data']['limit']) ? $data['data']['limit'] : 10; //条数
		$offset = !empty($data['data']['offset']) ? $data['data']['offset'] : 0; //位置
		
		
		$cout=array();
		if($types=="1"){//参与
			$list = array();
			$where['where'] = array('staff.mid'=>$mid,'staff.company_id'=>$company_id);
			$where['order'] = array('key'=>'staff.id',"value"=>"desc");
			$where['group']='rev.proid';
			$where['limit'] = $limit;
        	$where['offset'] = $offset;
			$where['page'] = true;
			$list = $this->review_staff->getList($where);

			$wherec['where'] = array('staff.mid'=>$mid,'staff.company_id'=>$company_id);
			$wherec['order'] = array('key'=>'staff.id',"value"=>"desc");
			$wherec['group']='rev.proid';
			$cout=$this->review_staff->get_count2($wherec);
		}else{//发起
		
			$list = array();
			$where['where'] = array('rev.mid'=>$mid,'rev.company_id'=>$company_id);
			$where['order'] = array('key'=>'staff.id',"value"=>"desc");
			$where['group']='rev.proid';
			$where['limit'] = $limit;
        	$where['offset'] = $offset;
			$where['page'] = true;
			$list = $this->review->getList1($where);
			$wherec['where'] = array('rev.mid'=>$mid,'rev.company_id'=>$company_id);
			$wherec['order'] = array('key'=>'staff.id',"value"=>"desc");
			$wherec['group']='rev.proid';
			$cout=$this->review->get_count2($wherec);
		}
		$pids = array();
		if($types=="1"){//参与
			//以项目分组
			if(!empty($list)){
				foreach($list as $k => $v){
					$pids[$k]['name'] = $v['title'];
					$pids[$k]['status'] =1;
					$config = array('p.id'=>$v['proid'],'p.company_id'=>$company_id);
					$proinfo = $this->project->get_one_by_id($config);
					if($proinfo){
						$taksicon=$this->pic($proinfo['typeid'],$proinfo['difficulty'],$proinfo['scale'],$company_id);
						if($taksicon){
							$pids[$k]['icon'] = base_url().'uploads/pics/'.$taksicon['picname'];//任务图标
						}else{
							$pids[$k]['icon'] ='';
						}
					}else{
						$pids[$k]['icon'] ='';
					}
					$where1['where'] = array('staff.mid'=>$mid,'staff.company_id'=>$company_id,'rev.proid'=>$v['proid']);
					$where1['order'] = array('key'=>'staff.id',"value"=>"desc");
					$list1 = $this->review_staff->getList($where1);
					
					if($list1){
						$modlist=array();
						foreach($list1 as $k1 => $v1){
							$title=$v1['title'];
							if($types=="1"){
								$tmp['revid'] = $v1['revid'];
							}else{
								$tmp['revid'] = $v1['id'];
							}
							$tmp['m_name'] = (empty($v1['modid'])?$v['title']:$v1['m_name']);
							$tmp['modid'] = $v1['modid'];
							$tmp['typeid'] = $v1['typeid'];
							$tmp['proid'] = $v1['proid'];
							$tmp['status'] = $v1['status'];
							$tmp['isstatus'] = $v1['isstatus'];
							//模块评分-评分结果
							$questionwhere['where'] = array('modid'=>$v1['modid'],'revid'=>$tmp['revid'],'company_id'=>$company_id);
							$questionwhere['group'] ="mid";
							$question_feedback = $this->review_question_feedback->getList($questionwhere);
								
							
							//参与人员
							$r['where']=array('rev.id'=>$tmp['revid']);
							$stafflist=$this->review_staff->getList($r);
							
							$total=0;
							if($question_feedback){
							
								if(count($stafflist)==count($question_feedback)){
									$c=0;
									foreach($question_feedback as $k2 => $v2){
										$countfen=0;
										$gradecount=0;
										$question_feedback[$k2]['headerurl']=base_url().'uploads/member/header/'.$v2['headerurl'];
										$w['where'] = array('revid'=>$v2['revid'],'mid'=>$v2['mid']);
										$list=$this->review_question_feedback->getList($w);
									
										if($list){
											foreach($list as $k3 => $v3){
												$grade=$v3['grade'];
												$gradecount=$gradecount+(float)$grade;
											}
											$countfen=$gradecount/count($list);
										}
										//$question_feedback[$k]['grade']=$countfen;
										$c=(float)$c+(float)$countfen;
									}
									
									$total=$c/count($question_feedback);
								}
							}
							$tmp['start'] =ceil($total);
							$modlist[]=$tmp;
						}
						$pids[$k]['modlist']=$modlist;
					}
				}
			}
		}else{
			if(!empty($list)){
				foreach($list as $k => $v){
					$pids[$k]['name'] = $v['title'];
					$pids[$k]['status'] =1;
					$config = array('p.id'=>$v['proid'],'p.company_id'=>$company_id);
					$proinfo = $this->project->get_one_by_id($config);
					if($proinfo){
						$taksicon=$this->pic($proinfo['typeid'],$proinfo['difficulty'],$proinfo['scale'],$company_id);
						if($taksicon){
							$pids[$k]['icon'] = base_url().'uploads/pics/'.$taksicon['picname'];//任务图标
						}else{
							$pids[$k]['icon'] ='';
						}
					}else{
						$pids[$k]['icon'] ='';
					}
					$list = array();
					$where1['where'] = array('rev.mid'=>$mid,'rev.company_id'=>$company_id,'rev.proid'=>$v['proid']);
					$where1['order'] = array('key'=>'staff.id',"value"=>"desc");
					$list1 = $this->review->getList1($where1);
				 
					if($list1){
						$modlist=array();
						foreach($list1 as $k1 => $v1){
							$title=$v1['title'];
							if($types=="1"){
								$tmp['revid'] = $v1['revid'];
							}else{
								$tmp['revid'] = $v1['id'];
							}
							$tmp['m_name'] = (empty($v1['modid'])?$v['title']:$v1['m_name']);
							$tmp['modid'] = $v1['modid'];
							$tmp['proid'] = $v1['proid'];
							$tmp['typeid'] = $v1['typeid'];
							$tmp['status'] = $v1['status'];
							$tmp['isstatus'] =1;
							//模块评分-评分结果
							$questionwhere['where'] = array('modid'=>$v1['modid'],'revid'=>$tmp['revid'],'company_id'=>$company_id);
							$questionwhere['group'] ="mid";
							$question_feedback = $this->review_question_feedback->getList($questionwhere);
					
							//参与人员
							$r['where']=array('rev.id'=>$tmp['revid']);
							$stafflist=$this->review_staff->getList($r);
					
							$total=0;
							if($question_feedback){
								if(count($stafflist)==count($question_feedback)){
									$c=0;
									foreach($question_feedback as $k2 => $v2){
										$countfen=0;
										$gradecount=0;
										$question_feedback[$k2]['headerurl']=base_url().'uploads/member/header/'.$v2['headerurl'];
										$w['where'] = array('revid'=>$v2['revid'],'mid'=>$v2['mid']);
										$list=$this->review_question_feedback->getList($w);
										if($list){
											foreach($list as $k3 => $v3){
												$grade=$v3['grade'];
												$gradecount=$gradecount+(float)$grade;
											}
											$countfen=$gradecount/count($list);
										}
									
										//$question_feedback[$k]['grade']=$countfen;
										$c=(float)$c+(float)$countfen;
										//$total=(float)$countfen;
											
									}
	
									$total=$c/count($question_feedback);
								}
							}
							$tmp['start'] =ceil($total);
							$modlist[]=$tmp;
						}
						$pids[$k]['modlist']=$modlist;
					}
				}
			}
		}

      if($_POST){
		$repjson = array(
		 	'tag'=>$data['tag'],  
		 	'errcode'=>0,
		 	'errmsg'=>'ok' ,	
		 	'data'=>$pids,
			'count'=>count($cout)
		);
		$this->responseData($repjson);  
		  }else{
	   $data =array('list'=>$pids,'tag'=>$data['tag'],'count'=>count($cout));
       $this->load->view('api/review',$data);	  
			  }
	
	}

	

	//评审列表参与列表
	//public function review_list()
//	{
//		$data = $this->requestData();
//		$mid = $data['data']['mid'];
//		$token = $data['data']['token'];
//		$types = $data['data']['types'];
//		$company_id = $data['data']['company_id'];//所属管理员
//		$limit = !empty($data['data']['limit']) ? $data['data']['limit'] : 10;
//		$offset = !empty($data['data']['offset']) ? $data['data']['offset'] : 0;
//		if($types=="1"){//参与
//			$list = array();
//			$where['where'] = array('staff.mid'=>$mid,'staff.company_id'=>$company_id);
//			$where['order'] = array('key'=>'staff.id',"value"=>"desc");
//			$list = $this->review_staff->getList($where);
//		}else{//发起
//		
//			$list = array();
//			$where['where'] = array('rev.mid'=>$mid,'rev.company_id'=>$company_id);
//			$where['order'] = array('key'=>'staff.id',"value"=>"desc");
//			$list = $this->review->getList1($where);
//		}
//		//以项目分组
//		$pids = array();
//		if(!empty($list)){
//			foreach($list as $k => $v){
//				$title=$v['title'];
//				if($types=="1"){
//					$tmp['revid'] = $v['revid'];
//				}else{
//					$tmp['revid'] = $v['id'];
//				}
//				$tmp['m_name'] = $v['m_name'];
//				$tmp['modid'] = $v['modid'];
//				$tmp['proid'] = $v['proid'];
//				$tmp['status'] = $v['status'];
//				//模块评分-评分结果
//				$questionwhere['where'] = array('modid'=>$v['modid'],'company_id'=>$company_id);
//				$questionwhere['group'] ="mid";
//				$question_feedback = $this->review_question_feedback->getList($questionwhere);
//				$total=0;
//				if($question_feedback){
//					foreach($question_feedback as $k => $v){
//						$countfen=0;
//						$gradecount=0;
//						$question_feedback[$k]['headerurl']=base_url().'uploads/member/header/'.$v['headerurl'];
//						$w['where'] = array('revid'=>$tmp['revid'],'mid'=>$mid);
//						$list=$this->review_question_feedback->getList($w);
//						if($list){
//							foreach($list as $k1 => $v1){
//								$grade=$this->starval(3,$v1['grade'],$company_id);
//								$gradecount=$gradecount+(float)$grade;
//							}
//							$countfen=$gradecount/count($list);
//						}
//						//$question_feedback[$k]['grade']=$countfen;
//						$total=(float)$countfen;
//					}
//				}
//				$tmp['start'] = $total;
//				//$pids[]=$tmp;
//				$parr[$k][] = $tmp;	
//				$pids[$k] = $title;
//
//			}
//		}
//
//		$json = array();
//		if(!empty($pids)){
//			foreach($pids as $pk => $pv){
//				$p['name'] = $pv; 
//				$p['status'] = 1;  //状态:1-评审中，2-已结束
//				$p['modlist'] = $parr[$pk];
//				$json[] = $p;
//			}
//		}
//
//		$repjson = array(
//		 	'tag'=>$data['tag'],  
//		 	'errcode'=>0,
//		 	'errmsg'=>'ok' ,	
//		 	'data'=>$json
//		);
//		$this->responseData($repjson);
//	}

	//获取
	public function review_member()
	{
		$member = $this->session->userdata('member'); 
		$data = $this->requestData();
		$mid = $member['id'];
		$company_id = $data['data']['company_id']?$data['data']['company_id']:1;//所属管理员 
		
		
		$this->load->model('member_mdl','member');
		$list = array();
		$where['where']=array('m.company_id'=>$company_id);
		$list = $this->member->getList($where);
		$member = array();
		if(!empty($list)){
			foreach($list as $k => $v){
				$tmp['id'] = $v['id'];
				$tmp['realname'] = $v['realname'];
				$tmp['headerurl'] = empty($v['headerurl']) ? base_url().'uploads/member/header/default.jpg' : base_url().'uploads/member/header/'.$v['headerurl'];
				$tmp['phone'] = $v['mobile'];
				$tmp['role'] = $this->get_role($v['roleid']);
				$member[] = $tmp;
			}
		}
		$repjson = array(
		 	'tag'=>$data['tag'],  
		 	'errcode'=>0,
		 	'errmsg'=>'ok' ,	
		 	'data'=>$member
		);
		 $data=array('list'=>$member);
		 $this->load->view('api/ajax/review_member',$data);
		//$this->responseData($repjson);
		//exit;
	}

	//项目列表
	public function get_review_project()
	{
		 $member = $this->session->userdata('member'); 
		$data = $this->requestData();
		$mid = $member['id'];
		$company_id = $data['data']['company_id']?$data['data']['company_id']:1;//所属管理员 
		
		$project = array();
		$this->load->model('project_mdl','project');
		//$where['where'] = array('p.mid'=>$mid);
		$where['where'] = array('i.status'=>1,'p.company_id'=>$company_id);
		$list = $this->project->getList($where);
		if(!empty($list)){
			foreach($list as $k => $v){
				if($v['typeid']==2){
					$rewhere=array('rev.company_id'=>$company_id,'rev.proid'=>$v['id'],'rev.modid'=>0);
					$reviewinfo=$this->review->get_one_by_id($rewhere);
					if(!$reviewinfo){
						$tmp['id'] = $v['id'];
						$tmp['title'] = $v['title'];
						$tmp['typeid'] = $v['typeid'];
						$project[] = $tmp;
					}
				}else{
					$w['where']=array('rev.company_id'=>$company_id,'rev.proid'=>$v['id']);
					$w['group'] = 'rev.modid';
					$revlist = $this->review->getList1($w);
					$wm['where']=array('m.company_id'=>$company_id);
					$modlist = $this->mod->getList($wm);
					if(count($revlist)!=count($modlist)){
						$tmp['id'] = $v['id'];
						$tmp['title'] = $v['title'];
						$tmp['typeid'] = $v['typeid'];
						$project[] = $tmp;
					}
					
				}
			}
		}
		$repjson = array(
		 	'tag'=>$data['tag'],  
		 	'errcode'=>0,
		 	'errmsg'=>'ok' ,	
		 	'data'=>$project
		);
		$this->responseData($repjson);
		exit;
	}
	
	
	

	//评审详情-模块
	public function mod_detail()
	{
		
		$member = $this->session->userdata('member'); 
		$data = $this->requestData();
		$mid = $member['id'];
		$company_id = $data['data']['company_id']?$data['data']['company_id']:1;//所属管理员 
		
		
		$proid = $data['data']['proid'];
		$modid = $data['data']['modid'];
		 
		$config = array('rev.proid'=>$proid,'rev.modid'=>$modid,'rev.company_id'=>$company_id);
		$info = $this->review->get_one_by_id($config);
		if($info){
			if($info['typeid']==2){
				$info['m_name']=$info['title'];
			}
			$info['grade']=0;
		}
		//模块评分-问题列表
		$question = array();
		$questionwhere['where'] = array('modid'=>$modid,'company_id'=>$company_id);
		$question = $this->review_question->getList($questionwhere);
		
		if($question){
			foreach($question as $k => $v){
				$question_feedback = $this->review_question_feedback->get_one_by_id(array('mid'=>$mid,'modid'=>$modid,'revid'=>$info['id'],'questionid'=>$v['id'],'company_id'=>$company_id));
				
				if($question_feedback){
					$question[$k]['grade']=$question_feedback['grade'];
					$question[$k]['feedbackstatus']=1;
				}else{
					$question[$k]['grade']=0;
					$question[$k]['feedbackstatus']=0;//weipingfne
				}
			}
		}
		
		//模块评分-评分结果
		$questionwhere['where'] = array('modid'=>$modid,'company_id'=>$company_id,'revid'=>$info['id']);
		$questionwhere['group'] ="questionid";
		$question_feedback = $this->review_question_feedback->getList($questionwhere);
		$total=0;
		if($question_feedback){
			foreach($question_feedback as $k => $v){
				$countfen=0;
				$gradecount=0;
				$question_feedback[$k]['headerurl']=base_url().'uploads/member/header/'.$v['headerurl'];
				$w['where'] = array('revid'=>$info['id'],'mid'=>$mid,'company_id'=>$company_id);
				$list=$this->review_question_feedback->getList($w);
				if($list){
					foreach($list as $k1 => $v1){
						$grade=$this->starval(3,$v1['grade'],$company_id);
						$gradecount=$gradecount+(float)$grade;
					}
					$countfen=$gradecount/count($list);
				}
				//$question_feedback[$k]['grade']=$countfen;
				//$total=(float)$countfen;
			}
		}
		
		$w['where'] = array('revid'=>$info['id'],'mid'=>$mid,'company_id'=>$company_id);
		
		$list=$this->review_question_feedback->getList($w);
		if($list){
			$countfen=0;
			$gradecount=0;
			foreach($list as $k1 => $v1){
				$grade=$this->starval(3,$v1['grade'],$company_id);
				$gradecount=$gradecount+(float)$grade;
			}
			$countfen=$gradecount/count($list);
				//$question_feedback[$k]['grade']=$countfen;
			$total=(float)$countfen;
		}
	
		
		$totalz=0;
		$c=0;
		//参与人员
		$memberlist=array();
		$mwhere['where'] = array('revid'=>$info['id'],'company_id'=>$company_id);
		$mwhere['group'] = 'mid';
		$memberlist = $this->review_question_feedback->getList($mwhere);
		if($memberlist){
			foreach($memberlist as $k => $v){
				$gradecount=0;
				$memberlist[$k]['headerurl'] = base_url().'uploads/member/header/'.$v['headerurl'];
				$w['where'] = array('revid'=>$info['id'],'mid'=>$v['mid'],'company_id'=>$company_id);
				$list=$this->review_question_feedback->getList($w);
				if($list){
					foreach($list as $k1 => $v1){
						$grade=$this->starval(3,$v1['grade'],$company_id);
						$gradecount=(float)$gradecount+(float)$grade;
					}
					$countfen=$gradecount/count($list);
				}
				$memberlist[$k]['grade']=sprintf('%.1f',$countfen);
				$c=(float)$c+(float)$countfen;
			}
			if($c !=0){
				$totalz=$c/count($memberlist);
			}
		}

		//任务评级
		$tasklist=array();
		$tc=0;
		$totalztk=0;
		$taskwhere['where']=array('t.proid'=>$proid,'t.modid'=>$modid,'t.company_id'=>$company_id);
		$tasklist=$this->task->getList($taskwhere);
		$gradecountt=0;
		$gradet=0;
		if($tasklist){
			foreach($tasklist as $k => $v){
				$countfen=0;
				$w['where'] = array('revid'=>$info['id'],'mid'=>$mid,'taskid'=>$v['id'],'company_id'=>$company_id);
				$list=$this->review_task->getList($w);
				if($list){
					foreach($list as $k1 => $v1){
						$gradet=$this->starval(3,$v1['grade'],$company_id);
						$gradecountt=(float)$gradecountt+(float)$gradet;
					}
					$tasklist[$k]['grade']=$list[0]['grade'];
				}else{
					$tasklist[$k]['grade']=0;
				}
			}
			if($gradecountt !=0){
				$tc=$gradecountt/count($tasklist);
				$totalztk=$tc;
			}
		}
		$modgradestatus=0;
		$question_feedbackinfo = $this->review_question_feedback->get_one_by_id(array('revid'=>$info['id'],'mid'=>$mid,'company_id'=>$company_id));
		if($question_feedbackinfo){
			$modgradestatus=1;
		}
		$taskgradestatus=0;
		$taskgradeinfo = $this->review_task->get_one_by_id(array('revid'=>$info['id'],'mid'=>$mid,'company_id'=>$company_id));
		if($taskgradeinfo){
			$taskgradestatus=1;
		}
		//更新是否查看的状态
		if($info){
			$up['isstatus']=1;
			$this->review_staff->update(array('revid'=>$info['id'],'mid'=>$mid),$up);
		}
		//参与人列表
		$r['where']=array('rev.id'=>$info['id']);
		$stafflist=$this->review_staff->getList($r);
		$staffname='';
		if($stafflist){
			foreach($stafflist as $k => $v){
				if(!empty($staffname)){
					$staffname=$staffname.','.$v['realname'];
				}else{
					$staffname=$v['realname'];
				}
			}
		}
	
		$repjson = array(
		 	'tag'=>$data['tag'],  
		 	'errcode'=>0,
		 	'errmsg'=>'ok' ,	
		 	'data'=>array(
		 		'revinfo'=>$info, //评审信息
		 		'gradefen'=>$total, //评分平均分
				'ztotal'=>$totalz, //用户和平均分
				'totalztk'=>$totalztk, //任务凭借平均分
				'question_feedback'=>$question_feedback, //问题列表
		 		'question'=>$question, //问题列表
				'tasklist'=>$tasklist,
				'modgradestatus'=>$modgradestatus,//此用户已经对模块评分了0未1已评
				'taskgradestatus'=>$taskgradestatus,//此用户已经对任务评分了0未1已评
				'memberlist'=>$memberlist,
				'staffname'=>$staffname//负责人名称
		 		)
		);
		  $data =array(
		 		'revinfo'=>$info, //评审信息
		 		'gradefen'=>sprintf('%.1f',$total), //评分平均分
				 'ztotal'=>sprintf('%.1f',$totalz), //用户和平均分
				'totalztk'=>sprintf('%.1f',$totalztk), //任务凭借平均分
				'question_feedback'=>$question_feedback, //问题列表
		 		'question'=>$question, //问题列表
				'tasklist'=>$tasklist,
				'modgradestatus'=>$modgradestatus, //此用户已经对模块评分了0未1已评
				'taskgradestatus'=>$taskgradestatus,//此用户已经对任务评分了0未1已评
				'memberlist'=>$memberlist,
				'staffname'=>$staffname//负责人名称
		 		);
			
   
       $this->load->view('api/review_detail',$data);
		
	 
	}
	
	
	//获取评审完成的详情，点赞
	public function get_review_finish_detail(){
		$member = $this->session->userdata('member'); 
		$data = $this->requestData();
		$mid = $member['id'];
		$company_id = $data['data']['company_id']?$data['data']['company_id']:1;//所属管理员 
		
		
		$proid = $data['data']['proid'];
		$modid = $data['data']['modid'];
		$revid = $data['data']['revid'];
		
		$config = array('rev.id'=>$revid,'rev.company_id'=>$company_id);
		$info = $this->review->get_one_by_id($config);
		$ustaff=array();
		$question_feedback=array();
		$tasklist=array();
		if($info){
			$taskinfo=$this->task->get_one_by_id(array('t.proid'=>$proid,'t.modid'=>$modid,'t.company_id'=>$company_id));
			if($taskinfo){
				$info['scale']=$taskinfo['scale'];
				$info['difficulty']=$taskinfo['difficulty'];
				$info['quality']=$taskinfo['quality'];
				$info['features']=$taskinfo['features'];
			}else{
				$info['scale']=0;
				$info['difficulty']=0;
				$info['quality']=0;
				$info['features']=0;
			}
			//参与人员
			$memberlist=array();
			$mwhere['where'] = array('revid'=>$revid,'company_id'=>$company_id);
			$mwhere['group'] = 'mid';
			$memberlist = $this->review_question_feedback->getList($mwhere);
			if($memberlist){
				foreach($memberlist as $k => $v){
					$memberlist[$k]['headerurl'] = base_url().'uploads/member/header/'.$v['headerurl'];
				}	
			}
			//模块评分-评分结果
			$question_feedback = array();
			$questionwhere['where'] = array('revid'=>$revid,'company_id'=>$company_id);
			$question_feedback = $this->review_question_feedback->getList($questionwhere);
			$gradecount=0;
			$countfen=0;
			if($question_feedback){
				foreach($question_feedback as $k => $v){
					//$gradecount=$gradecount+(float)$v['grade'];
					$question_feedback[$k]['grade']=$this->starval(3,$v['grade'],$company_id);
					$question_feedback[$k]['headerurl'] = base_url().'uploads/member/header/'.$v['headerurl'];
				}
				if($gradecount !=0){
					$countfen=$gradecount/count($question_feedback);
				}
			}
			//任务评级
			$tasklist=array();
			$taskwhere['where']=array('t.proid'=>$proid,'t.modid'=>$modid,'t.company_id'=>$company_id);
			$tasklist=$this->task->getList($taskwhere);
			if($tasklist){
				foreach($tasklist as $k => $v){
					$w['where'] = array('revid'=>$info['id'],'taskid'=>$v['id'],'company_id'=>$company_id);
					$list=$this->review_task->getList($w);
					if($list){
						foreach($list as $k1 => $v1){
							$gradet=$this->starval(3,$v1['grade'],$company_id);
						}
						//$tasklist[$k]['grade']=$list[0]['grade'];
						$tasklist[$k]['grade']=$this->starval(3,$list[0]['grade'],$company_id);
					}else{
						$tasklist[$k]['grade']=0;
					}
				}
			}
			
		}
		$repjson = array(
			'tag'=>$data['tag'],  
			'errcode'=>0,
			'errmsg'=>'ok' ,	
			'data'=>array(
				'revinfo'=>$info, //评审信息
				'gradefen'=>$countfen, //评分平均分
				'question_feedback'=>$question_feedback, //问题列表
				'tasklist'=>$tasklist,
				'memberlist'=>$memberlist
				)
		);
		 
		$data=array(
				'revinfo'=>$info, //评审信息
				'gradefen'=>$countfen, //评分平均分
				'question_feedback'=>$question_feedback, //问题列表
				'tasklist'=>$tasklist,
				'memberlist'=>$memberlist
				);
				// print_r($data);
		 $this->load->view('api/review_detail_finish',$data);
	
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
	
	//待评审(如果某用户发起了评审则不需点击可以发起评审)
	public function project_notasklist(){
			$member = $this->session->userdata('member'); 
		$data = $this->requestData();
		$mid = $member['id'];
		$company_id = $data['data']['company_id']?$data['data']['company_id']:1;//所属管理员 
	
		$wherelist['where'] = array('i.status'=>1);
		$list = $this->project->getList($wherelist);
        $lists = array();
        foreach($list as $k => $v){
			$taksicon=$this->pic($v['typeid'],$v['difficulty'],$v['scale'],$company_id);
			if($taksicon){
				$v['icon'] = base_url().'uploads/pics/'.$taksicon['picname'];//任务图标
			}else{
				$v['icon'] ='';
			}
			if($v['typeid']==2){
				$rewhere=array('rev.company_id'=>$company_id,'rev.proid'=>$v['id'],'rev.modid'=>0);
				$reviewinfo=$this->review->get_one_by_id($rewhere);
				if(!$reviewinfo){
					$lists[] = $v;
				}
			}else{
				$w['where']=array('rev.company_id'=>$company_id,'rev.proid'=>$v['id']);
				$w['group'] = 'rev.modid';
				$revlist = $this->review->getList1($w);
				$wm['where']=array('m.company_id'=>$company_id);
				$modlist = $this->mod->getList($wm);
				if(count($revlist)!=count($modlist)){
					$lists[] = $v;
				}
				
			}
        }
       	$repjson = array(
       			'errcode'=>0,
		 		'errmsg'=>'ok' , 
		 		'data'=>$lists
        	
        );
     
	 
	   $data =array('list'=>$lists);
	   
       $this->load->view('api/review_list',$data);	 

	
	}


	//模块评分
	public function modgrade(){
		$member = $this->session->userdata('member'); 
		$data = $this->requestData();
		$mid = $member['id'];
		$company_id = $data['data']['company_id']?$data['data']['company_id']:1;//所属管理员 
		$revid = $data['data']['revid'];//评审id
		$modid = $data['data']['modid'];//模块id
        $review = $data['data']['review'];//评分数组
		foreach($review as $k=>$v){   
         if( !$v )   
         unset(  $review[$k] );   
       }  
	   
	 
		 
	 
		if(!empty($revid) && !empty($mid) && !empty($review)){
			$staffinfo = $this->review_staff->get_one_by_id(array('revid'=>$revid,'mid'=>$mid ,'company_id'=>$company_id));
			if(!$staffinfo){
					$repjson = array(
					'tag'=>$data['tag'],  
					'errcode'=>-1,
					'errmsg'=>'抱歉，你无权评分此模块' ,	
					  );
				$this->responseData($repjson);
			}
			$where=array('modid'=>$modid,'mid'=>$mid,'revid'=>$revid,'company_id'=>$company_id);
			$info = $this->review_question_feedback->get_one_by_id($where);
			if(!empty($info)){
				$repjson = array(
				'tag'=>$data['tag'],  
				'errcode'=>-1,
				'errmsg'=>'抱歉，您已评分此模块' ,	
				  );
				$this->responseData($repjson);
			}
			if($review){
				foreach($review as $k => $v){
					$rev['revid'] = $revid;
					$rev['mid'] = $mid;
					$rev['modid'] = $modid;
					//$rev['questionid'] =$review[$k]['questionid'] ;//问题id
					//$rev['grade'] =$review[$k]['grade'] ;
					 $rev['questionid'] =$k ;//问题id
					 $rev['grade'] =$v ;
					$rev['company_id'] =$company_id ;
					$rev['createtime'] =time();
					$this->review_question_feedback->add($rev);
				}
			}
			//人气累加
			$config3 = array('tags'=>'renqi','company_id'=>$company_id);
			$renqifen = $this->gongshi->get_one_by_id($config3);
			$qiinfo=$this->member_qi->get_one_by_where(array('mid'=>$mid,'company_id'=>$company_id));
			if($qiinfo){
				$this->member_qi->update(array('mid'=>$mid),array('total'=>(float)$qiinfo['total']+(float)$renqifen['info']));
			}else{
				$qiadd['mid']=$mid;
				$qiadd['company_id']=$company_id;
				$qiadd['typeid']=1;
				$qiadd['total']=$renqifen['info'];
				$this->member_qi->add($qiadd);
			}
			
			$repjson = array(
			'errcode'=>0,
			'errmsg'=>'ok' , 
			);
       		$this->responseData($repjson);
		}else{
			$repjson = array(
				'tag'=>$data['tag'],  
				'errcode'=>-1,
				'errmsg'=>'模块评分失败，缺少必要参数' ,	
			  );
			$this->responseData($repjson);
		}
	}
	
	//任务评级、目前对难度的评分
	public function taskgrade(){
		$member = $this->session->userdata('member'); 
		$data = $this->requestData();
		$mid = $member['id'];
		$company_id = $data['data']['company_id']?$data['data']['company_id']:1;//所属管理员 
		
		$revid = $data['data']['revid'];//评审id
		$proid = $data['data']['proid'];//项目id
        $review = $data['data']['review'];//评分数组
		
      foreach($review as $k=>$v){   
         if( !$v )   
         unset(  $review[$k] );   
       }  
		
		if(!empty($proid) && !empty($mid) && !empty($review) && !empty($revid)){
			$where1=array('rev.proid'=>$proid,'rev.mid'=>$mid,'rev.company_id'=>$company_id);
			$info1 = $this->review->get_one_by_id($where1);
			if(empty($info1)){
				$repjson = array(
				'tag'=>$data['tag'],  
				'errcode'=>-1,
				'errmsg'=>'抱歉，您无权评分' ,	
				  );
				$this->responseData($repjson);
			}
			$where=array('revid'=>$revid,'mid'=>$mid,'company_id'=>$company_id);
			$info = $this->review_task->get_one_by_id($where);
			if(!empty($info)){
				$repjson = array(
					'tag'=>$data['tag'],  
					'errcode'=>-1,
					'errmsg'=>'抱歉，您已评分' ,	
				  );
				$this->responseData($repjson);
			}
			if($review){
				foreach($review as $k => $v){
					$revtask['revid'] = $revid;
					$revtask['mid'] = $mid;
					$revtask['taskid'] =$k ;//问题id
					$revtask['grade'] =$v ;
					$revtask['createtime'] =time();
					$revtask['company_id'] =$company_id;
					$this->review_task->add($revtask);
				}
			}
			//更改评审 已结束评审
			$config = array('id'=>$revid);
			$uprev['status'] =3 ;
			$uprev['endtime'] =time() ;
			$this->review->update($config,$uprev);
			
			$repjson = array(
			'errcode'=>0,
			'errmsg'=>'ok' , 
			);
       		$this->responseData($repjson);
		}else{
			$repjson = array(
				'tag'=>$data['tag'],  
				'errcode'=>-1,
				'errmsg'=>'模块评分失败，缺少必要参数' ,	
			  );
			$this->responseData($repjson);
		}
	}
	
	
	
	
	//评审点赞
	public function review_praise(){
		$member = $this->session->userdata('member'); 
		$data = $this->requestData();
		$mid = $member['id'];
		$company_id = $data['data']['company_id']?$data['data']['company_id']:1;//所属管理员 
		
		
		$revid = $data['data']['revid'];
 
		$config = array('rev.id'=>$revid,'rev.company_id'=>$company_id);
		$info = $this->review->get_one_by_id($config);
		if($info){
			$infopraise = $this->review_praise->get_one_by_id(array('revid'=>$revid,'mid'=>$mid,'company_id'=>$company_id));
			if($infopraise){
					$repjson = array(
					'tag'=>$data['tag'],  
					'errcode'=>-1,
					'errmsg'=>'抱歉，不能重复打分' ,	
				  );
				$this->responseData($repjson);
			}else{
				$add['revid']=$revid;
				$add['mid']=$mid;
				$add['company_id']=$company_id;
				$add['createtime']=time();
				$this->review_praise->add($add);
				//更改点赞值
				$config = array('id'=>$revid);
				$uprev['praise'] =$info['praise']+1 ;
				$uprev['status'] =3;
				$this->review->update($config,$uprev);
				
			
				
				$repjson = array(
					'errcode'=>0,
					'errmsg'=>'ok' , 
				);
				$this->responseData($repjson);
			}
		}else{
			$repjson = array(
				'tag'=>$data['tag'],  
				'errcode'=>-1,
				'errmsg'=>'抱歉，不存在' ,	
			  );
			$this->responseData($repjson);
		}
	}
	

	public function get_role($id)
	{
		//1-员工，2-专家，3-领导
		$role = array(
			1=>'员工',
			2=>'专家',
			3=>'领导'
		);
		return $role[$id];
	}
	
	
	//评审修改
	public function review_update(){
		$data = $this->requestData();
		$mid = $data['data']['mid'];
		$token = $data['data']['token'];
		$id = $data['data']['id']; //评审id
		$proid = $data['data']['proid']; //项目id
		$modid = $data['data']['modid']; //模块id
		$intro = $data['data']['intro']; //会议内容
		$staff = $data['data']['staff']; //参与人员
		$review = $data['data']['review']; //评审问题
		$endtime = $data['data']['endtime']; //评审截止时间
		$company_id = $data['data']['company_id'];//所属管理员
		if(!empty($id) && !empty($proid) && !empty($modid)){
			$wheretask=array('rev.mid'=>$mid,'rev.id'=>$id);
			$info = $this->review->get_one_by_id($wheretask);
			if($info){
				$review_up['mid'] = $mid;
				$review_up['proid'] = $proid;
				$review_up['modid'] = $modid;
				$review_up['intro'] = $intro;
				$review_up['endtime'] = strtotime($endtime);
				$review_up['createtime'] = time();
				//修改评审信息
				$this->review->update(array('id'=>$id),$review_up);
				//添加评审题目与描述
				if($review){
					$this->review_question_feedback->del(array('revid'=>$id,'company_id'=>$company_id));//删除评审题目评分
					//$this->review_question->del(array('revid'=>$id,'company_id'));//删除评审题目
//					foreach($review as $k => $v){
//						if(!empty($review[$k]['revtitle'])){//标题不为空
//							$rev['revid'] = $id;
//							$rev['revtitle'] =$review[$k]['revtitle'] ;
//							$rev['revintro'] =$review[$k]['revintro'] ;
//							$this->review_question->add($rev);
//						}
//					}
				}
				//添加评审人员
				if(!empty($staff)){
					$staffarr = explode(',', $staff);
					if(!empty($staffarr)){
						$this->review_staff->del(array('revid'=>$id,'company_id'=>$company_id));//删除评审人员
						foreach($staffarr as $sk => $sv){
							$staffrev['revid'] = $id;
							$staffrev['mid'] = $sv;
							$staffrev['company_id'] = $company_id;
							$staffrev['createtime'] = time();
							$this->review_staff->add($staffrev);
						}
					}
				}
				$repjson = array(
					'tag'=>$data['tag'],  
					'errcode'=>0,
					'errmsg'=>'提交成功' ,	
				  );
				$this->responseData($repjson);
			}else{
				$repjson = array(
				'tag'=>$data['tag'],  
				'errcode'=>-1,
				'errmsg'=>'抱歉，你无权操作' ,	
			  );
			$this->responseData($repjson);
			
			}
		}else{
			$repjson = array(
		 		'tag'=>$data['tag'],  
		 		'errcode'=>-1,
		 		'errmsg'=>'抱歉，缺少必要参数' ,	
		      );
			$this->responseData($repjson);
		}
	}
	
	
	//删除评审
	public function review_del(){
		$data = $this->requestData();
		$mid = $data['data']['mid'];
		$token = $data['data']['token'];
		$id = $data['data']['id']; //评审id
		$company_id = $data['data']['company_id'];//所属管理员
		if(!empty($id) && !empty($mid) ){
			$wheretask=array('rev.mid'=>$mid,'rev.id'=>$id,'rev.company_id'=>$company_id);
			$info = $this->review->get_one_by_id($wheretask);
			if($info){
				$this->review->del(array('id'=>$id,'company_id'=>$company_id));
//				$this->review_question->del(array('revid'=>$id));//删除评审题目
				$this->review_staff->del(array('revid'=>$id,'company_id'=>$company_id));//删除评审人员
				
				$this->review_task->del(array('revid'=>$id,'company_id'=>$company_id));//删除评分模块
				$repjson = array(
					'tag'=>$data['tag'],  
					'errcode'=>0,
					'errmsg'=>'删除成功' ,	
				  );
				$this->responseData($repjson);
			}else{
					$repjson = array(
					'tag'=>$data['tag'],  
					'errcode'=>-1,
					'errmsg'=>'抱歉，你无权操作' ,	
				  );
				$this->responseData($repjson);
			}
		}else{
			$repjson = array(
		 		'tag'=>$data['tag'],  
		 		'errcode'=>-1,
		 		'errmsg'=>'抱歉，缺少必要参数' ,	
		      );
			$this->responseData($repjson);
		}
	}
	
	//	根据模块获取评审标题列表
	public function mod_review_question(){
		
		$member = $this->session->userdata('member'); 
		$data = $this->requestData();
		$mid = $member['id'];
		$company_id = $data['data']['company_id']?$data['data']['company_id']:1;//所属管理员 
		
		
		$modid = $data['data']['modid'];//模块id
		$token = $data['data']['token'];
		 
		if(!empty($modid) ){
			$where['where']=array('modid'=>$modid,'company_id'=>$company_id);
			$list = $this->review_question->getList($where);
			$repjson = array(
		 	'tag'=>$data['tag'],  
		 	'errcode'=>0,
		 	'errmsg'=>'ok' ,	
		 	'data'=>$list
		);
		$this->responseData($repjson);
		}else{
			$repjson = array(
		 		'tag'=>$data['tag'],  
		 		'errcode'=>-1,
		 		'errmsg'=>'抱歉，缺少必要参数' ,	
		      );
			$this->responseData($repjson);
		}
	}
}
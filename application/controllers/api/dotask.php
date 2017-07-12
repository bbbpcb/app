<?php

/**
*
*@DEC 指导相关接口
**/

class Dotask extends Api_Controller
{
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model('project_mdl','project');
		$this->load->model('task_mdl','task');
		$this->load->model('member_task_mdl','member_task');
		$this->load->model('mod_mdl','mod');
		$this->load->model('member_ex_mdl','member_ex');
		$this->load->model('task_plan_reply_mdl','task_plan_reply');
		$this->load->model('task_plan_mdl','task_plan');
		$this->load->model('member_mdl','member');
		$this->load->model('task_wenti_mdl','task_wenti');
		$this->load->model('task_wenti_reply_mdl','task_wenti_reply');
		$this->load->model('task_fansi_mdl','task_fansi');
		$this->load->model('task_fansi_reply_mdl','task_fansi_reply');
		$this->load->model('task_marking_mdl','task_marking');
		$this->load->model('star_mdl','star');
		$this->load->model('gongshi_mdl','gongshi');
		$this->load->model('member_qi_mdl','member_qi');
		$this->load->model('conquer_reply_mdl','conquer_reply');
		$this->load->library('session');
	}
	
	//随机获取图片
	public function pic($type,$nandu,$guimo,$company_id){
		//图片
		$pics = array();
		$this->load->model('pics_mdl','pics');
		$picwhere['where'] = array('typeid'=>$type,'nandu'=>$nandu,'guimo'=>$guimo,'company_id'=>$company_id);
		$pics = $this->pics->getList($picwhere);
		if(!$pics){
			return '';
		}
		$rand_keys = array_rand($pics);
		return $pics[$rand_keys];
	}
	
	public function dotask_major()
	{
		 $member = $this->session->userdata('member'); 
		$data = $this->requestData();
		$mid = $member['id'];
		$company_id = $data['data']['company_id']?$data['data']['company_id']:1;//所属管理员
		$types = $data['data']['types'];//types1为重大项目，2为基础项目
 

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
		$lists=array();
		$tasklist=array();
		if(!empty($mid) && !empty($types)){	
			if($types==1){
				$where['where'] = array('mid'=>$mid,'typeid'=>1,'company_id'=>$company_id);
				$where['group'] ="projectid";
				$where['order'] = array('key'=>'projectid','value'=>'desc');
				$prolist = $this->member_task->get_membertask_project($where);
				foreach($prolist as $k => $v){
					$list =array();
					$proinfo = $this->project->get_one_by_id(array('p.id'=>$v['projectid'],'p.company_id'=>$company_id));
					$v['id']=$v['id'];
					$v['title']=$proinfo['title'];
					$taksicon=$this->pic($proinfo['typeid'],$proinfo['difficulty'],$proinfo['scale'],$company_id);
					if($taksicon){
						$v['icon'] = base_url().'uploads/pics/'.$taksicon['picname'];//任务图标
					}else{
						$v['icon'] ='';
					}
					$wheretask['where'] = array('mt.projectid'=>$v['projectid'],'mt.typeid'=>1,'mt.mid'=>$mid,'mt.company_id'=>$company_id);
					$wheretask['order'] = array('key'=>'modid','value'=>'asc');
					$list = $this->member_task->getList($wheretask);
					$res=array();
					$tasklist=array();
					foreach($list as $k1 => $v1){
						$res = $this->task->get_one_by_id(array('t.id'=>$v1['taskid'],'t.company_id'=>$company_id));
						if($res){
							$quality = $this->starval('3',$res['quality'],$company_id);
							$scale = $this->starval('1',$res['scale'],$company_id);
							$difficulty = $this->starval('2',$res['difficulty'],$company_id);
							$features =$this->starval('4',$res['features'],$company_id);
							eval("\$jg=$scale$j1$difficulty$j2$quality$j3$features;");
						}
						//获取指导中任务打分的数据
						$fentotal=0;
						$task_markinglist=$this->task_marking->get_all(array('typeid'=>1,'taskid'=>$v1['taskid'],'company_id'=>$company_id));
						if($task_markinglist){
							foreach($task_markinglist as $km => $vm){
								//$fentotal=(float)$fentotal+(float)$vm['score'];
								$fentotal = (float)$fentotal+(float)$this->starval('3',$vm['score'],$company_id);//质量分
							}
							$fentotal=$fentotal/count($task_markinglist);
						}
						$fansicout=0;
						$fansiinfo=$this->task_fansi->get_one_by_id(array('taskid'=>$v1['taskid'],'company_id'=>$company_id));
						if($fansiinfo){
							$fansicout=$this->task_fansi_reply->get_count(array('fansiid'=>$fansiinfo['id']));
						}
						$plancout=0;
						$planinfo=$this->task_plan->get_one_by_id(array('taskid'=>$v1['taskid'],'company_id'=>$company_id));
						if($planinfo){
							$planinfo=$this->task_plan_reply->get_count(array('planid'=>$planinfo['id'],'company_id'=>$company_id));
						}
						$wencout=0;
						$w['where']=array('wenti.taskid'=>$v1['taskid'],'wenti.company_id'=>$company_id);
						$wenlist=$this->task_wenti->getList($w);
						if($wenlist){
							foreach($wenlist as $kw => $vw){
								$wencout=$wencout+$this->task_wenti_reply->get_count(array('wentiid'=>$vw['id'],'company_id'=>$company_id));
							}
						}
						$res['expertscore']=$fentotal;
						$res['totlescore']=$jg;
						$res['replynum']=$fansicout+$plancout+$wencout;
						$res['typeid']=1;
						$taksicon=$this->pic("4",$res['difficulty'],$res['scale'],$company_id);
						if($taksicon){
							$res['task_icon'] = base_url().'uploads/pics/'.$taksicon['picname'];//任务图标
						}else{
							$res['task_icon'] ='';
						}
						
						$dotaskstatus=1;
						$w1['where']=array('p.taskid'=>$v1['taskid'],'mid'=>$mid,'r.status'=>0);
						$list1 = $this->task_plan_reply->getList1($w1);
						
						if($list1){
							if($dotaskstatus==1){
								$dotaskstatus=0;
								//echo 'ee';
							}
						}
						$w2['where']=array('w.taskid'=>$v1['taskid'],'mid'=>$mid,'r.status'=>0);
						$list2 = $this->task_wenti_reply->getList1($w2);
						if($list2){
							if($dotaskstatus==1){
								$dotaskstatus=0;
								//echo 'ff';
							}
						}
						$w3['where']=array('f.taskid'=>$v1['taskid'],'mid'=>$mid,'r.status'=>0);
						$list3 = $this->task_fansi_reply->getList1($w3);
						if($list3){
							if($dotaskstatus==1){
								$dotaskstatus=0;
								//echo 'gg';
							}
						}
							//是否打分情况
						$task_markinginfo=$this->task_marking->get_one_by_id(array('taskid'=>$v1['taskid'],'taskmid'=>$mid,'projectid'=>$v1['projectid'],'status'=>0,'company_id'=>$company_id));
						if($task_markinginfo){
							if($dotaskstatus==1){
								$dotaskstatus=0;
							}
						}
						
						$res['isstatus']=$dotaskstatus;
						$tasklist[]=$res;
						
						
					}
					$v['tasklist'] = $tasklist;
					$lists[] = $v;
				}
			}
			if($types==2){
				$where['where'] = array('mid'=>$mid,'typeid'=>1,'company_id'=>$company_id);
				$where['group'] ="modid";
				$where['order'] = array('key'=>'projectid','value'=>'desc');
				$modlist = $this->member_task->get_membertask_project($where);
				foreach($modlist as $k => $v){
					$list =array();
					$modinfo = $this->mod->get_one_by_id(array('id'=>$v['modid'],'company_id'=>$company_id));
					
					$v['id']=$v['projectid'];
					if($modinfo){
						$v['title']=$modinfo['m_name'];
					}else{
						$v['title']='';
					}
					$wheretask['where'] = array('mt.modid'=>$v['modid'],'mt.mid'=>$mid,'mt.typeid'=>1,'mt.company_id'=>$company_id);
					$wheretask['order'] = array('key'=>'modid','value'=>'asc');
					$list = $this->member_task->getList($wheretask);

					$res=array();
					$tasklist=array();
				
					foreach($list as $k1 => $v1){
						$res = $this->task->get_one_by_id(array('t.id'=>$v1['taskid'],'t.company_id'=>$company_id));
						$quality = $this->starval('3',$res['quality'],$company_id);
						$scale = $this->starval('1',$res['scale'],$company_id);
						$difficulty = $this->starval('2',$res['difficulty'],$company_id);
						$features =$this->starval('4',$res['features'],$company_id);
						eval("\$jg=$scale$j1$difficulty$j2$quality$j3$features;");
						//获取指导中任务打分的数据
						$fentotal=0;
						$task_markinglist=$this->task_marking->get_all(array('typeid'=>1,'taskid'=>$v1['taskid'],'company_id'=>$company_id));
						if($task_markinglist){
							foreach($task_markinglist as $km => $vm){
								//$fentotal=(float)$fentotal+(float)$vm['score'];
								$fentotal = (float)$fentotal+(float)$this->starval('3',$vm['score'],$company_id);//质量分
							}
							$fentotal=$fentotal/count($task_markinglist);
						}
						$res['expertscore']=$fentotal;
						$res['totlescore']=0;
						$fansicout=0;
						$fansiinfo=$this->task_fansi->get_one_by_id(array('taskid'=>$v1['taskid'],'company_id'=>$company_id));
						if($fansiinfo){
							$fansicout=$this->task_fansi_reply->get_count(array('fansiid'=>$fansiinfo['id'],'company_id'=>$company_id));
						}
						$plancout=0;
						$planinfo=$this->task_plan->get_one_by_id(array('taskid'=>$v1['taskid'],'company_id'=>$company_id));
						if($planinfo){
							$planinfo=$this->task_plan_reply->get_count(array('planid'=>$planinfo['id'],'company_id'=>$company_id));
						}
						$wencout=0;
						$w['where']=array('wenti.taskid'=>$v1['taskid'],'wenti.company_id'=>$company_id);
						$wenlist=$this->task_wenti->getList($w);
						if($wenlist){
							foreach($wenlist as $kw => $vw){
								$wencout=$wencout+$this->task_wenti_reply->get_count(array('wentiid'=>$vw['id'],'company_id'=>$company_id));
							}
						}
						$res['replynum']=$fansicout+$plancout+$wencout;
						$res['typeid']=1;
						$taksicon=$this->pic("4",$res['difficulty'],$res['scale'],$company_id);
						if($taksicon){
							$res['task_icon'] = base_url().'uploads/pics/'.$taksicon['picname'];//任务图标
						}else{
							$res['task_icon'] ='';
						}
						
						$dotaskstatus=1;
						$w1['where']=array('p.taskid'=>$v1['taskid'],'mid'=>$mid,'r.status'=>0);
						$list1 = $this->task_plan_reply->getList1($w1);
						
						if($list1){
							if($dotaskstatus==1){
								$dotaskstatus=0;
								//echo 'ee';
							}
						}
						$w2['where']=array('w.taskid'=>$v1['taskid'],'mid'=>$mid,'r.status'=>0);
						$list2 = $this->task_wenti_reply->getList1($w2);
						if($list2){
							if($dotaskstatus==1){
								$dotaskstatus=0;
								//echo 'ff';
							}
						}
						$w3['where']=array('f.taskid'=>$v1['taskid'],'mid'=>$mid,'r.status'=>0);
						$list3 = $this->task_fansi_reply->getList1($w3);
						if($list3){
							if($dotaskstatus==1){
								$dotaskstatus=0;
								//echo 'gg';
							}
						}
							//是否打分情况
						$task_markinginfo=$this->task_marking->get_one_by_id(array('taskid'=>$v1['taskid'],'taskmid'=>$mid,'projectid'=>$v1['projectid'],'status'=>0,'company_id'=>$company_id));
						if($task_markinginfo){
							if($dotaskstatus==1){
								$dotaskstatus=0;
							}
						}
						$res['isstatus']=$dotaskstatus;
						$tasklist[]=$res;
						
						$tasklist[]=$res;
					}
					$v['tasklist'] = $tasklist;
					
					$lists[] = $v;
				}
			}
			if($types==3){
				$where['where'] = array('mid'=>$mid,'typeid'=>2,'company_id'=>$company_id);
				$where['order'] = array('key'=>'projectid','value'=>'desc');
				$prolist = $this->member_task->get_membertask_project($where);
				foreach($prolist as $k => $v){
					$proinfo = $this->project->get_one_by_id(array('p.id'=>$v['projectid'],'p.company_id'=>$company_id));
					$taksicon=$this->pic($proinfo['typeid'],$proinfo['difficulty'],$proinfo['scale'],$company_id);
					if($taksicon){
						$proinfo['task_icon'] = base_url().'uploads/pics/'.$taksicon['picname'];//任务图标
					}else{
						$proinfo['task_icon'] ='';
					}
					$proinfo['createtime']=date('Y-m-d',$proinfo['createtime']);
					$proinfo['typeid']=1;
					$quality = $this->starval('3',$proinfo['quality'],$company_id);
					$scale = $this->starval('1',$proinfo['scale'],$company_id);
					$difficulty = $this->starval('2',$proinfo['difficulty'],$company_id);
					$features =$this->starval('4',$proinfo['features'],$company_id);
					eval("\$jg=$scale$j1$difficulty$j2$quality$j3$features;");
					$proinfo['totlescore']=$jg;
					$proinfo['headerurl']=base_url().'uploads/member/header/'.$proinfo['headerurl'];
					
					$dotaskstatus=1;
					$w1['where']=array('p.taskid'=>$v['projectid'],'mid'=>$$mid,'r.status'=>0);
					$list1 = $this->task_plan_reply->getList1($w1);
					
					if($list1){
						if($dotaskstatus==1){
							$dotaskstatus=0;
							//echo 'oo';
						}
					}
					$w2['where']=array('w.taskid'=>$v['projectid'],'mid'=>$$mid,'r.status'=>0);
					$list2 = $this->task_wenti_reply->getList1($w2);
				
					if($list2){
						if($dotaskstatus==1){
							$dotaskstatus=0;
							//echo 'pp';
						}
					}
					$w3['where']=array('f.taskid'=>$v['projectid'],'mid'=>$$mid,'r.status'=>0);
					$list3 = $this->task_fansi_reply->getList1($w3);
					
					if($list3){
						if($dotaskstatus==1){
							$dotaskstatus=0;
							//echo 'qq';
						}
					}
						//是否打分情况
					$task_markinginfo=$this->task_marking->get_one_by_id(array('taskid'=>$v['taskid'],'projectid'=>$v['projectid'],'status'=>0,'company_id'=>$company_id));
		
					if($task_markinginfo){

						if($dotaskstatus==1){
							$dotaskstatus=0;
							//echo 'yy';
						}
					}
					$proinfo['isstatus']=$dotaskstatus;
					
					$lists[]=$proinfo;
				}
			}
		
		 if($_POST){
		 $repjson = array(
			'tag'=>$data['tag'],  
			'errcode'=>0,
			'errmsg'=>'ok' ,	
			'data'=>$lists, 
			);
			$this->responseData($repjson);
		 }else{
	   $data =array('list'=>$lists);
	 //var_dump($lists);
       $this->load->view('api/dotask',$data);
	   }
	   
	   
		}else{
	   redirect('d=api&c=login','','','抱歉,请先登录或操作有误，请重试');
	   exit;
		}
	}
	
	//详情
	public function dotask_detail(){
		
		$member = $this->session->userdata('member'); 
		$data = $this->requestData();
		$mid = $member['id'];
		$company_id = $data['data']['company_id']?$data['data']['company_id']:1;//所属管理员
        $taskid = $data['data']['taskid'];//任务id或是项目id
		$typeid= $data['data']['typeid'];
		$typerole= $data['data']['typerole'];//1为基础与重大项目,2为我要点评我要评分
		$membertaskmid= $data['data']['membertaskmid'];
 
		$planstatus=0;//无发布立项与策划状态
		$wentistatus=0;//无发布问题与解决状态
		$resultstatus=0;//无发布结果与反思状态
		$planlist=array();
		$plancontent="";//发布的问题
		$wentilist=array();
		$resultinfo=null;
		$role=1;//1为普通员工，2为专家.3领导
		$fabustatus=0;//是否可以发布问题
		$fansilist=array();
		$info=null;
		$planinfo=null;
		$exgragestatus=0;//判断此专家是否打分了
		$exstatus=0;//判断此任务或项目是否专家都打分了
		$task_markinglist=array();
		if(!empty($mid) && !empty($taskid) && !empty($typeid)){
			if($typeid=="1"){
				$taskinfo=$this->task->get_one_by_id(array('t.id'=>$taskid,'t.company_id'=>$company_id));
 
				$info['id']=$taskinfo['id'];
				$info['modid']=$taskinfo['modid'];
				$info['proid']=$taskinfo['proid'];
				$info['title']=$taskinfo['title'];
				$info['intro']=$taskinfo['intro'];
				$info['scale']=$taskinfo['scale'];
				$info['difficulty']=$taskinfo['difficulty'];
				$info['quality']=$taskinfo['quality'];
				$info['features']=$taskinfo['features'];
				$info['mid']=$taskinfo['mid'];
				$info['status']=$taskinfo['status'];
				$info['ptitle']=$taskinfo['ptitle'];
				$info['type_name']=$taskinfo['type_name'];
				$info['typeid']=1;
				$projectinfo=$this->project->get_one_by_id(array('p.id'=>$taskinfo['proid'],'p.company_id'=>$company_id));
				$info['headrealname']=$projectinfo['realname'];
				$info['headheader']=base_url().'uploads/member/header/'.$projectinfo['headerurl'];
			}else{
				$projectinfo=$this->project->get_one_by_id(array('p.id'=>$taskid,'p.company_id'=>$company_id));
				$info['id']=$projectinfo['id'];
				$info['modid']=$projectinfo['modid'];
				$info['proid']=$projectinfo['id'];
				$info['title']=$projectinfo['title'];
				$info['intro']=$projectinfo['intro'];
				$info['scale']=$projectinfo['scale'];
				$info['difficulty']=$projectinfo['difficulty'];
				$info['quality']=$projectinfo['quality'];
				$info['features']=$projectinfo['features'];
				$info['mid']=$projectinfo['mid'];
				$info['status']=$projectinfo['status'];
				$info['ptitle']=$projectinfo['title'];
				$info['type_name']="";
				$info['typeid']=2;
				$info['headrealname']=$projectinfo['realname'];
				$info['headheader']=base_url().'uploads/member/header/'.$projectinfo['headerurl'];
			}
			if($typerole==1){
					//我的专家列表
					$wherememberex['where']=array('mid'=>$mid,'status'=>1,'mex.company_id'=>$company_id);
					$member_ex=$this->member_ex->getList($wherememberex);
					foreach($member_ex as $k => $v){
						$member_ex[$k]['headerurl'] = base_url().'uploads/member/header/'.$v['headerurl'];
					}
				}else{
					//我的专家列表
					$wherememberex['where']=array('mid'=>$membertaskmid,'status'=>1,'mex.company_id'=>$company_id);
					$member_ex=$this->member_ex->getList($wherememberex);
					foreach($member_ex as $k => $v){
						$member_ex[$k]['headerurl'] = base_url().'uploads/member/header/'.$v['headerurl'];
					}
				}
			if($typerole==1){
				if($typeid=="1"){
					$member_task = $this->member_task->get_one_by_id(array('taskid'=>$taskid,'mid'=>$mid,'company_id'=>$company_id));	
					//更新查看状态
					$up=array();
					$up['isstatus']=1;
					$this->member_task->update(array('taskid'=>$taskid,'mid'=>$mid),$up);
				}else{
					$member_task = $this->member_task->get_one_by_id(array('projectid'=>$taskid,'mid'=>$mid,'company_id'=>$company_id));	
					//更新查看状态
					$up=array();
					$up['isstatus']=1;
					$this->member_task->update(array('projectid'=>$taskid,'mid'=>$mid),$up);
				}
				if($typerole==1){
					if($member_task){
						if($member_task['mid']==$mid){
								$fabustatus=1;//是否可以发布问题
						}
					}
				}
				$existrue=0;
				//立项与策划状态
				$member=$this->member->get_one_by_id(array('id'=>$mid,'company_id'=>$company_id));
				if($member['roleid']=="1"){
					$role=1;//普通员工
				}
				if($member['roleid']=="2"){
					$role=2;//专家
				}
				if($member['roleid']=="3"){
					$role=3;//领导
				}
				if($member_task){
					$planinfo=$this->task_plan->get_one_by_id(array('taskid'=>$taskid,'mid'=>$member_task['mid'],'company_id'=>$company_id));
				}else{
					$planinfo=$this->task_plan->get_one_by_id(array('taskid'=>$taskid,'company_id'=>$company_id));
				}
				if($planinfo){
					$planstatus=1;//已发布问题
					//$plancontent=$planinfo['content'];
				}else{
					$planinfo=null;
				}
				//专家回复
				if($planinfo){
					$whereplanreply['where']=array('plan.planid'=>$planinfo['id'],'plan.company_id'=>$company_id);
					$planlist=$this->task_plan_reply->getList($whereplanreply);
					if($planlist){
						foreach($planlist as $k => $v){
							if($member_task['mid']==$mid){
								//更新查看状态
								$up=array();
								$up['status']=1;
								$this->task_plan_reply->update(array('id'=>$v['id']),$up);
							}
							$planlist[$k]['headerurl'] = base_url().'uploads/member/header/'.$v['headerurl'];
						}
					}
				}
				
				if($member_task){
					$wherewenti['where']=array('taskid'=>$taskid,'mid'=>$member_task['mid'],'wenti.company_id'=>$company_id);
				}else{
					$wherewenti['where']=array('taskid'=>$taskid,'wenti.company_id'=>$company_id);
				}
				$taskwentilist=$this->task_wenti->getList($wherewenti);
	
				if($taskwentilist){
					foreach($taskwentilist as $k => $v){
						$v['createtime']=date('Y-m-d',$v['createtime']);
						$wtreplyinfo=$this->task_wenti_reply->get_one_by_id(array('r.wentiid'=>$v['id'],'r.company_id'=>$company_id));
						if($wtreplyinfo){
							if($member_task['mid']==$mid){
								//更新查看状态
								$up=array();
								$up['status']=1;
								$this->task_wenti_reply->update(array('wentiid'=>$v['id']),$up);
							}
							$wtreplyinfo['createtime']=date('Y-m-d',$wtreplyinfo['createtime']);
							$wtreplyinfo['headerurl']=base_url().'uploads/member/header/'.$wtreplyinfo['headerurl'];
						}else{
							$wtreplyinfo=null;
						}
						if($member_task['mid']==$mid){
							//更新查看状态
							$up=array();
							$up['status']=1;
							$this->task_wenti_reply->update(array('wentiid'=>$v['id']),$up);
						}
						$replycount=$this->task_wenti_reply->get_count(array('wentiid'=>$v['id'],'company_id'=>$company_id));
						$v['replycount']=$replycount;
						$v['wtreply'] = $wtreplyinfo;
						$v['headerurl'] = base_url().'uploads/member/header/'.$v['headerurl'];
						$wentilist[] = $v;
					}
					$wentistatus=1;
				}
				//结果与反思
				if($member_task){
					$fansiinfo=$this->task_fansi->get_one_by_id(array('taskid'=>$taskid,'mid'=>$member_task['mid'],'company_id'=>$company_id));
				}else{
					$fansiinfo=$this->task_fansi->get_one_by_id(array('taskid'=>$taskid,'company_id'=>$company_id));
				}
				if($fansiinfo){
					$resultstatus=1;//已发布结果与反思
					$resultinfo=$fansiinfo;
					
					$wherefansireply['where']=array('f.fansiid'=>$fansiinfo['id'],'f.company_id'=>$company_id);
					$fansilist=$this->task_fansi_reply->getList($wherefansireply);
					
					if($fansilist){
						foreach($fansilist as $k => $v){
							if($member_task['mid']==$mid){
								//更新查看状态
								$up=array();
								$up['status']=1;
								$this->task_fansi_reply->update(array('id'=>$v['id']),$up);
							}
							$fansilist[$k]['headerurl'] = base_url().'uploads/member/header/'.$v['headerurl'];
						}
					}
				}
				//判断当前用户是否是某人的专家
				$wherememberex1['where']=array('mid'=>$mid,'status'=>1,'mex.company_id'=>$company_id);
				$member_ex1=$this->member_ex->getList($wherememberex1);
			
				//获取指导中任务打分的数据
				$fentotal=0;
				if($typeid=="1"){
					$task_markinglist=$this->task_marking->get_all(array('typeid'=>1,'taskid'=>$taskid,'taskmid'=>$membertaskmid,'company_id'=>$company_id));
					if($task_markinglist){
						foreach($task_markinglist as $km => $vm){
							$fentotal = (float)$fentotal+(float)$this->starval('3',$vm['score'],$company_id);//质量分
							$task_markinglist[$km]['headerurl'] = base_url().'uploads/member/header/'.$vm['headerurl'];
							
						}
						$fentotal=$fentotal/count($task_markinglist);
					}
					
					if(count($member_ex1)==count($task_markinglist)){
						$exstatus=1;
					}
					if($membertaskmid==$mid){
						//更新查看状态
						$up=array();
						$up['status']=1;
						$this->task_marking->update(array('taskid'=>$taskid,'typeid'=>1),$up);
					}
				}else{
					$task_markinglist=$this->task_marking->get_all(array('typeid'=>2,'projectid'=>$taskid,'taskmid'=>$membertaskmid,'company_id'=>$company_id));
					if($task_markinglist){
						foreach($task_markinglist as $km => $vm){
							$fentotal = (float)$fentotal+(float)$this->starval('3',$vm['score'],$company_id);//质量分
							$task_markinglist[$km]['headerurl'] = base_url().'uploads/member/header/'.$vm['headerurl'];
							
						}
						$fentotal=$fentotal/count($task_markinglist);
					}
					if(count($member_ex1)==count($task_markinglist)){
						$exstatus=1;
					}
					if($membertaskmid==$mid){
						//更新查看状态
						$up=array();
						$up['status']=1;
						$this->task_marking->update(array('projectid'=>$taskid,'typeid'=>2),$up);
					}
				}
				$userinfo=$this->userinfofen($mid,$company_id);
			}else{//我要评分我要点评
				if($typeid=="1"){
					$member_task = $this->member_task->get_one_by_id(array('taskid'=>$taskid,'mid'=>$membertaskmid,'company_id'=>$company_id));	
					if($membertaskmid==$mid){
						//更新查看状态
						$up=array();
						$up['isstatus']=1;
						$this->member_task->update(array('taskid'=>$taskid,'mid'=>$mid),$up);
					}
				}else{
					$member_task = $this->member_task->get_one_by_id(array('projectid'=>$taskid,'mid'=>$membertaskmid,'company_id'=>$company_id));	
					if($membertaskmid==$mid){
						//更新查看状态
						$up=array();
						$up['isstatus']=1;
						$this->member_task->update(array('projectid'=>$taskid,'mid'=>$mid),$up);
					}
				}
				if($typerole==1){
					if($member_task){
						if($member_task['mid']==$membertaskmid){
								$fabustatus=1;//是否可以发布问题
						}
					}
				}
				$existrue=0;
				//立项与策划状态
				$member=$this->member->get_one_by_id(array('id'=>$membertaskmid,'company_id'=>$company_id));
				if($member['roleid']=="1"){
					$role=1;//普通员工
				}
				if($member['roleid']=="2"){
					$role=2;//专家
				}
				if($member['roleid']=="3"){
					$role=3;//领导
				}
				if($member_task){
					$planinfo=$this->task_plan->get_one_by_id(array('taskid'=>$taskid,'mid'=>$member_task['mid'],'company_id'=>$company_id));
				}else{
					$planinfo=$this->task_plan->get_one_by_id(array('taskid'=>$taskid,'company_id'=>$company_id));
				}
				if($planinfo){
					$planstatus=1;//已发布问题
					//$plancontent=$planinfo['content'];
				}else{
					$planinfo=null;
				}
				//专家回复
				if($planinfo){
					$whereplanreply['where']=array('plan.planid'=>$planinfo['id'],'plan.company_id'=>$company_id);
					$planlist=$this->task_plan_reply->getList($whereplanreply);
					if($planlist){
						foreach($planlist as $k => $v){
							$planlist[$k]['headerurl'] = base_url().'uploads/member/header/'.$v['headerurl'];
							if($member_task['mid']==$mid){
								//更新查看状态
								$up=array();
								$up['status']=1;
								$this->task_plan_reply->update(array('id'=>$v['id']),$up);
							}
						}
					}
				}
				
				if($member_task){
					$wherewenti['where']=array('taskid'=>$taskid,'mid'=>$member_task['mid'],'wenti.company_id'=>$company_id);
				}else{
					$wherewenti['where']=array('taskid'=>$taskid,'wenti.company_id'=>$company_id);
				}
				$taskwentilist=$this->task_wenti->getList($wherewenti);
				if($taskwentilist){
					foreach($taskwentilist as $k => $v){
						$v['createtime']=date('Y-m-d',$v['createtime']);
						$wtreplyinfo=$this->task_wenti_reply->get_one_by_id(array('r.wentiid'=>$v['id'],'r.company_id'=>$company_id));
						if($wtreplyinfo){
							if($member_task['mid']==$mid){
								//更新查看状态
								$up=array();
								$up['status']=1;
								$this->task_wenti_reply->update(array('wentiid'=>$v['id']),$up);
							}
							$wtreplyinfo['createtime']=date('Y-m-d',$wtreplyinfo['createtime']);
							$wtreplyinfo['headerurl']=base_url().'uploads/member/header/'.$wtreplyinfo['headerurl'];
						}else{
							$wtreplyinfo=null;
						}
						$replycount=$this->task_wenti_reply->get_count(array('wentiid'=>$v['id'],'company_id'=>$company_id));
						$v['replycount']=$replycount;
						$v['wtreply'] = $wtreplyinfo;
						$v['headerurl'] = base_url().'uploads/member/header/'.$v['headerurl'];
						
						$wentilist[] = $v;
						if($member_task['mid']==$mid){
							//更新查看状态
							$up=array();
							$up['status']=1;
							$this->task_wenti_reply->update(array('wentiid'=>$v['id']),$up);
						}
					}
					$wentistatus=1;
				}
				//结果与反思
				if($member_task){
					$fansiinfo=$this->task_fansi->get_one_by_id(array('taskid'=>$taskid,'mid'=>$member_task['mid'],'company_id'=>$company_id));
				}else{
					$fansiinfo=$this->task_fansi->get_one_by_id(array('taskid'=>$taskid,'company_id'=>$company_id));
				}
				if($fansiinfo){
					$resultstatus=1;//已发布结果与反思
					$resultinfo=$fansiinfo;
					
					$wherefansireply['where']=array('f.fansiid'=>$fansiinfo['id'],'f.company_id'=>$company_id);
					$fansilist=$this->task_fansi_reply->getList($wherefansireply);
					if($fansilist){
						foreach($fansilist as $k => $v){
							if($member_task['mid']==$mid){
								//更新查看状态
								$up=array();
								$up['status']=1;
								
								$this->task_fansi_reply->update(array('id'=>$v['id']),$up);
							}
							$fansilist[$k]['headerurl'] = base_url().'uploads/member/header/'.$v['headerurl'];
						}
					}
				}
				//判断当前用户是否是某人的专家
				$wherememberex1['where']=array('mid'=>$membertaskmid,'status'=>1,'mex.company_id'=>$company_id);
				$member_ex1=$this->member_ex->getList($wherememberex1);
				
				//获取指导中任务打分的数据
				$fentotal=0;
				if($typeid=="1"){
					$task_markinglist=$this->task_marking->get_all(array('typeid'=>1,'taskid'=>$taskid,'taskmid'=>$membertaskmid,'company_id'=>$company_id));
					if($task_markinglist){
						foreach($task_markinglist as $km => $vm){
							$fentotal = (float)$fentotal+(float)$this->starval('3',$vm['score'],$company_id);//质量分
							$task_markinglist[$km]['headerurl'] = base_url().'uploads/member/header/'.$vm['headerurl'];
						}
						$fentotal=$fentotal/count($task_markinglist);
					}
					$task_markinginfo=$this->task_marking->get_one_by_id(array('taskid'=>$taskid,'typeid'=>1,'mid'=>$mid,'taskmid'=>$membertaskmid,'company_id'=>$company_id));
					if($task_markinginfo){
						$exgragestatus=1;
					}
					if(count($member_ex1)==count($task_markinglist)){
						$exstatus=1;
					}
					if($member_task['mid']==$mid){
						//更新查看状态
						$up=array();
						$up['status']=1;
						$this->task_marking->update(array('taskid'=>$taskid,'typeid'=>1),$up);
					}
				}else{
					$task_markinglist=$this->task_marking->get_all(array('typeid'=>2,'projectid'=>$taskid,'mid'=>$mid,'taskmid'=>$membertaskmid,'company_id'=>$company_id));
					if($task_markinglist){
						foreach($task_markinglist as $km => $vm){
							$fentotal = (float)$fentotal+(float)$this->starval('3',$vm['score'],$company_id);//质量分
							$task_markinglist[$km]['headerurl'] = base_url().'uploads/member/header/'.$vm['headerurl'];
						}
						$fentotal=$fentotal/count($task_markinglist);
					}
					$task_markinginfo=$this->task_marking->get_one_by_id(array('projectid'=>$taskid,'typeid'=>2,'taskmid'=>$membertaskmid,'company_id'=>$company_id));
					if($task_markinginfo){
						$exgragestatus=1;
					}
					if(count($member_ex1)==count($task_markinglist)){
						$exstatus=1;
					}
					if($member_task['mid']==$mid){
						//更新查看状态
						$up=array();
						$up['status']=1;
						$this->task_marking->update(array('projectid'=>$taskid,'typeid'=>2),$up);
					}
				}
				//$userinfo=$this->userinfofen($mid);	
			}
			$repjson = array(
			'tag'=>$data['tag'],  
			'errcode'=>0,
			'errmsg'=>'ok' ,	
			'data'=>array(
				'roletype'=>$role, //角色
				'fabustatus'=>$fabustatus,//是否可以发布问题0为不可，1可以发布
		 		'taskinfo'=>$info, //任务详细
		 		'member_ex'=>$member_ex, //我的专家
		 		'planlist'=>$planlist, //专家回复立项与策划
				//'plancontent'=>$plancontent,//发布的问题
				'planinfo'=>$planinfo,//立项与策划
				'planstatus'=>$planstatus,//立项与策划发布的状态
				'wentistatus'=>$wentistatus,//问题与解决的状态
				'taskwentilist'=>$wentilist,//问题列表
				'resultstatus'=>$resultstatus,//结果与反思状态
				'resultinfo'=>$resultinfo,//结果与反思详细
				'resultexlist'=>$fansilist,//结果与反思专家回复列表
				'task_markinglist'=>$task_markinglist,//专家评分列表
				'fentotal'=>$fentotal,//总分
				'exgragestatus'=>$exgragestatus,//判断此专家是否打分了
				'exstatus'=>$exstatus,//判断专家是否全都打分了，0为未，1为都打完了
				'userfentotal'=>0,
		 		)
			);
			$data= array(
				'roletype'=>$role, //角色
				'fabustatus'=>$fabustatus,//是否可以发布问题0为不可，1可以发布
		 		'taskinfo'=>$info, //任务详细
		 		'member_ex'=>$member_ex, //我的专家
		 		'planlist'=>$planlist, //专家回复立项与策划
				//'plancontent'=>$plancontent,//发布的问题
				'planinfo'=>$planinfo,//立项与策划
				'planstatus'=>$planstatus,//立项与策划发布的状态
				'wentistatus'=>$wentistatus,//问题与解决的状态
				'taskwentilist'=>$wentilist,//问题列表
				'resultstatus'=>$resultstatus,//结果与反思状态
				'resultinfo'=>$resultinfo,//结果与反思详细
				'resultexlist'=>$fansilist,//结果与反思专家回复列表
				'task_markinglist'=>$task_markinglist,//专家评分列表
				'fentotal'=>$fentotal,//总分
				'exgragestatus'=>$exgragestatus,//判断此专家是否打分了
				'exstatus'=>$exstatus,//判断专家是否全都打分了，0为未，1为都打完了
				'userfentotal'=>0,
		 		);
			  //ar_dump($data); 
		    $this->load->view('api/dotask_detail',$data);
				
			
			
			
		}else{
			$repjson = array(
       		'errcode'=>-1,
		 	'errmsg'=>'抱歉,请先登录或操作有误，请重试' , 
		 	'data'=>array()
			);
			$this->responseData($repjson);
		}
	}
	
	//立项与策划普遍会员发布问题
	public function dotask_plan(){
		
		$member = $this->session->userdata('member'); 
		$data = $this->requestData();
		$mid = $member['id'];
		$company_id = $data['data']['company_id']?$data['data']['company_id']:1;//所属管理员
		
		
		$taskid = $data['data']['taskid'];//任务id
		$content = $data['data']['content'];//发布内容
 
		if(!empty($mid) && !empty($taskid)){	
			$member=$this->member->get_one_by_id(array('id'=>$mid));
			//if($member['roleid'] !="1"){
//				$repjson = array(
//				'errcode'=>-1,
//				'errmsg'=>'抱歉,普通员工角色才可操作！' , 
//				'data'=>array()
//				);
//				$this->responseData($repjson);
//			}
			$planinfo=$this->task_plan->get_one_by_id(array('taskid'=>$taskid,'mid'=>$mid,'company_id'=>$company_id));
			if($planinfo){
				$repjson = array(
				'errcode'=>-1,
				'errmsg'=>'抱歉,您已发布问题！' , 
				'data'=>array()
				);
				$this->responseData($repjson);
			}
			//$taskinfo=$this->task->get_one_by_id(array('t.id'=>$taskid,'t.company_id'=>$company_id));
			//if($taskinfo){
				$add['content']=$content;
				$add['taskid']=$taskid;
				$add['mid']=$mid;
				$add['company_id']=$company_id;
				$add['createtime']=time();
				$res=$this->task_plan->add($add);
				if($res){
					$repjson = array(
					'errcode'=>0,
					'errmsg'=>'提交成功！' , 
					'data'=>array()
					);
					$this->responseData($repjson);
				}else{
					$repjson = array(
					'errcode'=>-1,
					'errmsg'=>'抱歉,提交失败！' , 
					'data'=>array()
					);
					$this->responseData($repjson);
				}
			//}else{
//				$repjson = array(
//				'errcode'=>-1,
//				'errmsg'=>'抱歉,不存在此任务！' , 
//				'data'=>array()
//				);
//				$this->responseData($repjson);
//			}
			
		}else{
			$repjson = array(
       		'errcode'=>-1,
		 	'errmsg'=>'抱歉,请先登录或操作有误，请重试' , 
		 	'data'=>array()
			);
			$this->responseData($repjson);
		}
	}
	
	//立项与策划专家回复
	public function dotask_plan_reply(){
		$member = $this->session->userdata('member'); 
		$data = $this->requestData();
		$mid = $member['id'];
		$company_id = $data['data']['company_id']?$data['data']['company_id']:1;//所属管理员
		 
		$planid = $data['data']['planid'];//问题id
		$content = $data['data']['content'];//回复内容
 
		if(!empty($mid) && !empty($planid)){
			//$member=$this->member->get_one_by_id(array('id'=>$mid));
//			if($member['roleid'] !="2"){
//				$repjson = array(
//				'errcode'=>-1,
//				'errmsg'=>'抱歉,专家角色才可操作！' , 
//				'data'=>array()
//				);
//				$this->responseData($repjson);
//			}
			$planinfo=$this->task_plan->get_one_by_id(array('id'=>$planid,'company_id'=>$company_id));
			if($planinfo){
				////更新查看状态
//				$up=array();
//				$up['isstatus']=0;
//				$this->member_task->update(array('id'=>$v['id']),$up);
			
				$existrue=0;
				$wherememberex['where']=array('mid'=>$planinfo['mid'],'status'=>1,'mex.company_id'=>$company_id);
				$member_ex=$this->member_ex->getList($wherememberex);	
				if($member_ex){
					foreach($member_ex as $k => $v){
						if($mid==$v['exid']){
							$existrue=1;
						}
					}
				}else{
					$repjson = array(
							'errcode'=>-1,
							'errmsg'=>'抱歉,专家角色才可操作！' , 
							'data'=>array()
							);
					$this->responseData($repjson);
				}
				if($existrue==0){
					$repjson = array(
						'errcode'=>-1,
						'errmsg'=>'抱歉,专家角色才可操作！' , 
						'data'=>array()
						);
					$this->responseData($repjson);
				}
				$add['content']=$content;
				$add['planid']=$planid;
				$add['exid']=$mid;
				$add['company_id']=$company_id;
				$add['createtime']=time();
				$res=$this->task_plan_reply->add($add);
				if($res){
					//人气累加
					$config3 = array('tags'=>'renqi','company_id'=>$company_id);
					$renqifen = $this->gongshi->get_one_by_id($config3);
					$qiinfo=$this->member_qi->get_one_by_where(array('mid'=>$mid,'company_id'=>$company_id));
					if($qiinfo){
						$this->member_qi->update(array('mid'=>$mid),array('total'=>(float)$qiinfo['total']+(float)$renqifen['info']));
					}else{
						$qiadd['mid']=$mid;
						$qiadd['typeid']=1;
						$qiadd['company_id']=$company_id;
						$qiadd['total']=$renqifen['info'];
						$this->member_qi->add($qiadd);
					}
					$repjson = array(
						'errcode'=>0,
						'errmsg'=>'提交成功！' , 
						'data'=>array()
					);
					$this->responseData($repjson);
				}else{
					$repjson = array(
						'errcode'=>-1,
						'errmsg'=>'抱歉,提交失败！' , 
						'data'=>array()
					);
					$this->responseData($repjson);
				}
			}else{
				$repjson = array(
				'errcode'=>-1,
				'errmsg'=>'抱歉,不存在此问题！' , 
				'data'=>array()
				);
				$this->responseData($repjson);
			}
		}else{
			$repjson = array(
       		'errcode'=>-1,
		 	'errmsg'=>'抱歉,请先登录或操作有误，请重试' , 
		 	'data'=>array()
			);
			$this->responseData($repjson);
		}
	}
	
	//问题与解决普通员工发布问题
	public function dotask_wenti(){
		$member = $this->session->userdata('member'); 
		$data = $this->requestData();
		$mid = $member['id'];
		$company_id = $data['data']['company_id']?$data['data']['company_id']:1;//所属管理员
		
		
		$taskid = $data['data']['taskid'];//任务id
		$content = $data['data']['content'];//发布内容
		 
		if(!empty($mid) && !empty($taskid)){	
			$member=$this->member->get_one_by_id(array('id'=>$mid,'company_id'=>$company_id));
			//if($member['roleid'] !="1"){
//				$repjson = array(
//				'errcode'=>-1,
//				'errmsg'=>'抱歉,普通员工角色才可操作！' , 
//				'data'=>array()
//				);
//				$this->responseData($repjson);
//			}
			//$taskinfo=$this->task->get_one_by_id(array('t.id'=>$taskid,'t.company_id'=>$company_id));
//			if($taskinfo){
				
				$add['content']=$content;
				$add['taskid']=$taskid;
				$add['mid']=$mid;
				$add['company_id']=$company_id;
				$add['createtime']=time();
				$res=$this->task_wenti->add($add);
				if($res){
					$repjson = array(
						'errcode'=>0,
						'errmsg'=>'提交成功！' , 
						'data'=>array()
					);
					$this->responseData($repjson);
				}else{
					$repjson = array(
						'errcode'=>-1,
						'errmsg'=>'抱歉,提交失败！' , 
						'data'=>array()
					);
					$this->responseData($repjson);
				}
			//}else{
//				$repjson = array(
//					'errcode'=>-1,
//					'errmsg'=>'抱歉,不存在此任务！' , 
//					'data'=>array()
//				);
//				$this->responseData($repjson);
//			}
			
		}else{
			$repjson = array(
       		'errcode'=>-1,
		 	'errmsg'=>'抱歉,请先登录或操作有误，请重试' , 
		 	'data'=>array()
			);
			$this->responseData($repjson);
		}
	}
	
	//问题与解决专家回复
	public function dotask_wenti_reply(){
		$data = $this->requestData();
		$mid = $data['data']['mid'];
		$token = $data['data']['token'];
		$wentiid = $data['data']['wentiid'];//问题id
		$content = $data['data']['content'];//回复内容
		$company_id = $data['data']['company_id'];//所属管理员
		if(!empty($mid) && !empty($wentiid)){	
			$member=$this->member->get_one_by_id(array('id'=>$mid,'company_id'=>$company_id));
		//	if($member['roleid'] !="2"){
//				$repjson = array(
//				'errcode'=>-1,
//				'errmsg'=>'抱歉,专家角色才可操作！' , 
//				'data'=>array()
//				);
//				$this->responseData($repjson);
//			}
			$wentiinfo=$this->task_wenti->get_one_by_id(array('id'=>$wentiid,'company_id'=>$company_id));
			if($wentiinfo){
				
				$existrue=0;
				$wherememberex['where']=array('mid'=>$wentiinfo['mid'],'status'=>1,'mex.company_id'=>$company_id);
				$member_ex=$this->member_ex->getList($wherememberex);	
				if($member_ex){
					foreach($member_ex as $k => $v){
						if($mid==$v['exid']){
							$existrue=1;
						}
					}
				}else{
					$repjson = array(
							'errcode'=>-1,
							'errmsg'=>'抱歉,专家角色才可操作！' , 
							'data'=>array()
						);
					$this->responseData($repjson);
				}
				if($existrue==0){
					$repjson = array(
						'errcode'=>-1,
						'errmsg'=>'抱歉,专家角色才可操作！' , 
						'data'=>array()
					);
					$this->responseData($repjson);
				}
				$add['content']=$content;
				$add['wentiid']=$wentiid;
				$add['company_id']=$company_id;
				$add['exid']=$mid;
				$add['createtime']=time();
				$add['status']=0;
				$res=$this->task_wenti_reply->add($add);
				if($res){
					//人气累加
					$config3 = array('tags'=>'renqi','company_id'=>$company_id);
					$renqifen = $this->gongshi->get_one_by_id($config3);
					$qiinfo=$this->member_qi->get_one_by_where(array('mid'=>$mid,'company_id'=>$company_id));
					if($qiinfo){
						$this->member_qi->update(array('mid'=>$mid),array('total'=>(float)$qiinfo['total']+(float)$renqifen['info']));
					}else{
						$qiadd['mid']=$mid;
						$qiadd['typeid']=2;
						$qiadd['company_id']=$company_id;
						$qiadd['total']=$renqifen['info'];
						$this->member_qi->add($qiadd);
					}

					$repjson = array(
						'errcode'=>0,
						'errmsg'=>'提交成功！' , 
						'data'=>array()
					);
					$this->responseData($repjson);
				}else{
					$repjson = array(
					'errcode'=>-1,
					'errmsg'=>'抱歉,提交失败！' , 
					'data'=>array()
					);
					$this->responseData($repjson);
				}
			}else{
				$repjson = array(
					'errcode'=>-1,
					'errmsg'=>'抱歉,不存在！' , 
					'data'=>array()
				);
				$this->responseData($repjson);
			}
		}else{
			$repjson = array(
       		'errcode'=>-1,
		 	'errmsg'=>'抱歉,请先登录或操作有误，请重试' , 
		 	'data'=>array()
			);
			$this->responseData($repjson);
		}
	}
	
	//某问题的回复列表
	public function dotask_wenti_reply_list(){
		$data = $this->requestData();
		$mid = $data['data']['mid'];
		$token = $data['data']['token'];
		$wentiid = $data['data']['wentiid'];//问题id
		$company_id = $data['data']['company_id'];//所属管理员
		$list=array();
		if(!empty($mid) && !empty($wentiid)){	
			$wentiinfo=$this->task_wenti->get_one_by_id(array('id'=>$wentiid,'company_id'=>$company_id));
			if($wentiinfo){
				$up=array();
				$up['status']=1;
				$this->task_wenti_reply->update(array('wentiid'=>$wentiid),$up);
				$wentiinfo['createtime']=date('Y-m-d',$wentiinfo['createtime']);
				$replycount=$this->task_wenti_reply->get_count(array('wentiid'=>$wentiid,'company_id'=>$company_id));
				$wentiinfo['replycount']=$replycount;
				$where['where']=array('w.wentiid'=>$wentiid,'w.company_id'=>$company_id);
				$list=$this->task_wenti_reply->getList($where);
				$member=$this->member->get_one_by_id(array('id'=>$mid,'company_id'=>$company_id));
				if($member){
					$wentiinfo['realname']=$member['realname'];
				}else{
					$wentiinfo['realname']='';
				}
				if($list){
					foreach($list as $k => $v){
						$list[$k]['headerurl'] = base_url().'uploads/member/header/'.$v['headerurl'];
					}
				}
				$repjson = array(
				'tag'=>$data['tag'],  
				'errcode'=>0,
				'errmsg'=>'ok' ,	
				'data'=>array(
					'info'=>$wentiinfo, //问题详细
					'list'=>$list, //回复列表
					)
				);
				$this->responseData($repjson);
			}else{
				$repjson = array(
				'errcode'=>-1,
				'errmsg'=>'抱歉,不存在！' , 
				'data'=>array()
				);
				$this->responseData($repjson);
			}
		}else{
			$repjson = array(
       		'errcode'=>-1,
		 	'errmsg'=>'抱歉,请先登录或操作有误，请重试' , 
		 	'data'=>array()
			);
			$this->responseData($repjson);
		}
	}
	
	
	//结果与反思发布文体
	public function dotask_result(){
		
			$member = $this->session->userdata('member'); 
		$data = $this->requestData();
		$mid = $member['id'];
		$company_id = $data['data']['company_id']?$data['data']['company_id']:1;//所属管理员
	    $taskid = $data['data']['taskid'];//任务id
		$qingkuang = $data['data']['qingkuang'];//情况
		$feiyong = $data['data']['feiyong'];//费用
		$tianshu = $data['data']['tianshu'];//情况
 
		if(!empty($mid) && !empty($taskid)){	
			$member=$this->member->get_one_by_id(array('id'=>$mid,'company_id'=>$company_id));
			//if($member['roleid'] !="1"){
//				$repjson = array(
//				'errcode'=>-1,
//				'errmsg'=>'抱歉,普通员工角色才可操作！' , 
//				'data'=>array()
//				);
//				$this->responseData($repjson);
//			}
			$fansiinfo=$this->task_fansi->get_one_by_id(array('taskid'=>$taskid,'mid'=>$mid,'company_id'=>$company_id));
			if($fansiinfo){
				$repjson = array(
				'errcode'=>-1,
				'errmsg'=>'抱歉,您已发布问题！' , 
				'data'=>array()
				);
				$this->responseData($repjson);
			}
			//$taskinfo=$this->task->get_one_by_id(array('t.id'=>$taskid,'t.company_id'=>$company_id));
//			if($taskinfo){
				$add['qingkuang']=$qingkuang;
				$add['feiyong']=$feiyong;
				$add['tianshu']=$tianshu;
				$add['taskid']=$taskid;
				$add['company_id']=$company_id;
				$add['mid']=$mid;
				$add['createtime']=time();
				$res=$this->task_fansi->add($add);
				if($res){
					$repjson = array(
					'errcode'=>0,
					'errmsg'=>'提交成功！' , 
					'data'=>array()
					);
					$this->responseData($repjson);
				}else{
					$repjson = array(
					'errcode'=>-1,
					'errmsg'=>'抱歉,提交失败！' , 
					'data'=>array()
					);
					$this->responseData($repjson);
				}
			//}else{
//				$repjson = array(
//				'errcode'=>-1,
//				'errmsg'=>'抱歉,不存在此任务！' , 
//				'data'=>array()
//				);
//				$this->responseData($repjson);
//			}
			
		}else{
			$repjson = array(
       		'errcode'=>-1,
		 	'errmsg'=>'抱歉,请先登录或操作有误，请重试' , 
		 	'data'=>array()
			);
			$this->responseData($repjson);
		}
	}
	
	
	//结果与反思发布文体专家回复
	public function dotask_result_reply(){
		
		$member = $this->session->userdata('member'); 
		$data = $this->requestData();
		$mid = $member['id'];
		$company_id = $data['data']['company_id']?$data['data']['company_id']:1;//所属管理员
		
		$fansiid = $data['data']['fansiid'];//结果与反思id
		$content = $data['data']['content'];//回复内容
 
		if(!empty($mid) && !empty($fansiid)){	
			$member=$this->member->get_one_by_id(array('id'=>$mid,'company_id'=>$company_id));
			//if($member['roleid'] !="2"){
//				$repjson = array(
//				'errcode'=>-1,
//				'errmsg'=>'抱歉,专家角色才可操作！' , 
//				'data'=>array()
//				);
//				$this->responseData($repjson);
//			}
			$fansiinfo=$this->task_fansi->get_one_by_id(array('id'=>$fansiid,'company_id'=>$company_id));
			if($fansiinfo){
				$existrue=0;
				$wherememberex['where']=array('mid'=>$fansiinfo['mid'],'status'=>1,'mex.company_id'=>$company_id);
				$member_ex=$this->member_ex->getList($wherememberex);	
				if($member_ex){
					foreach($member_ex as $k => $v){
						if($mid==$v['exid']){
							$existrue=1;
						}
					}
				}else{
					$repjson = array(
							'errcode'=>-1,
							'errmsg'=>'抱歉,专家角色才可操作！' , 
							'data'=>array()
							);
							$this->responseData($repjson);
				}
				if($existrue==0){
					$repjson = array(
						'errcode'=>-1,
						'errmsg'=>'抱歉,专家角色才可操作！' , 
						'data'=>array()
						);
						$this->responseData($repjson);
				}
				$add['content']=$content;
				$add['fansiid']=$fansiid;
				$add['exid']=$mid;
				$add['createtime']=time();
				$res=$this->task_fansi_reply->add($add);
				if($res){
					//人气累加
					$config3 = array('tags'=>'renqi','company_id'=>$company_id);
					$renqifen = $this->gongshi->get_one_by_id($config3);
					$qiinfo=$this->member_qi->get_one_by_where(array('mid'=>$mid));
					if($qiinfo){
						$this->member_qi->update(array('mid'=>$mid),array('total'=>(float)$qiinfo['total']+(float)$renqifen['info']));
					}else{
						$qiadd['mid']=$mid;
						$qiadd['company_id']=$company_id;
						$qiadd['typeid']=3;
						$qiadd['total']=$renqifen['info'];
						$this->member_qi->add($qiadd);
					}
					$repjson = array(
					'errcode'=>0,
					'errmsg'=>'提交成功！' , 
					'data'=>array()
					);
					$this->responseData($repjson);
				}else{
					$repjson = array(
					'errcode'=>-1,
					'errmsg'=>'抱歉,提交失败！' , 
					'data'=>array()
					);
					$this->responseData($repjson);
				}
			}else{
				$repjson = array(
				'errcode'=>-1,
				'errmsg'=>'抱歉,不存在此问题！' , 
				'data'=>array()
				);
				$this->responseData($repjson);
			}
		}else{
			$repjson = array(
       		'errcode'=>-1,
		 	'errmsg'=>'抱歉,请先登录或操作有误，请重试' , 
		 	'data'=>array()
			);
			$this->responseData($repjson);
		}
	}
	
	
	//我要点评 
	public function dotask_review(){
		$member = $this->session->userdata('member'); 
		$data = $this->requestData();
		$mid = $member['id'];
		$company_id = $data['data']['company_id']?$data['data']['company_id']:1;//所属管理员
		
		
		$tasklist=array();
		if(!empty($mid)){	
			//判断当前用户是否是某人的专家
			$wherememberex['where']=array('exid'=>$mid,'status'=>1,'mex.company_id'=>$company_id);
			$member_ex=$this->member_ex->getList($wherememberex);
			$ex=array();//作为专家的用户
			if($member_ex){
				foreach($member_ex as $k => $v){
					$ex[$k]=$v['mid'];
				}
			}
			if(!empty($ex)){
				$where['wherein'] =$ex;
				$where['order'] =array('key'=>'id','value'=>'desc');
				$member_tasklist = $this->member_task->get_membertask_project($where);
				
				$res=array();
				foreach($member_tasklist as $k1 => $v1){
					if($v1['typeid']=="1"){
						$res = $this->task->get_one_by_id(array('t.id'=>$v1['taskid'],'t.company_id'=>$company_id));
						$member=$this->member->get_one_by_id(array('id'=>$v1['mid'],'company_id'=>$company_id));
						
						$resv['id']=$v1['id'];
						$resv['taskid']=$v1['taskid'];
						$resv['typeid']=$v1['typeid'];	
						$resv['projectid']=$v1['projectid'];	
						$resv['title']=$res['title'];
						$resv['ptitle']=$res['ptitle'];
						$resv['mid']=$v1['mid'];
						if($member){
							$resv['realname']=$member['realname'];
							$resv['headerurl']=base_url().'uploads/member/header/'.$member['headerurl'];
						}else{
							$resv['realname']='';
							$resv['headerurl']='';
						}
						$planinfo=$this->task_plan->get_one_by_id(array('taskid'=>$v1['taskid'],'mid'=>$v1['mid'],'company_id'=>$company_id));
						$wentiinfo=$this->task_wenti->get_one_by_id(array('taskid'=>$v1['taskid'],'mid'=>$v1['mid'],'company_id'=>$company_id));
						if($planinfo || $wentiinfo){
							if($v1['isstatus']==0){
								$resv['isstatus']=0;	
							}else{
								$resv['isstatus']=1;	
							}
							$tasklist[]=$resv;
						}
					}elseif($v1['typeid']=="2"){
						$proinfo = $this->project->get_one_by_id(array('p.id'=>$v1['projectid'],'p.company_id'=>$company_id));
						$member=$this->member->get_one_by_id(array('id'=>$v1['mid'],'company_id'=>$company_id));
						$resv['id']=$v1['id'];
						$resv['typeid']=$v1['typeid'];	
						$resv['taskid']=$v1['taskid'];	
						$resv['projectid']=$v1['projectid'];	
						$resv['title']=$proinfo['title'];
						$resv['ptitle']='';
						$resv['mid']=$v1['mid'];
						if($member){
							$resv['realname']=$member['realname'];
							$resv['headerurl']=base_url().'uploads/member/header/'.$member['headerurl'];
						}else{
							$resv['realname']='';
							$resv['headerurl']='';
						}
						$planinfo=$this->task_plan->get_one_by_id(array('taskid'=>$v1['projectid'],'mid'=>$v1['mid'],'company_id'=>$company_id));
							
						$wentiinfo=$this->task_wenti->get_one_by_id(array('taskid'=>$v1['projectid'],'mid'=>$v1['mid'],'company_id'=>$company_id));
						if($planinfo || $wentiinfo){
							if($v1['isstatus']==0){
								$resv['isstatus']=0;	
							}else{
								$resv['isstatus']=1;	
							}
							$tasklist[]=$resv;
						}
					}
				}

				$repjson = array(
				'tag'=>$data['tag'],  
				'errcode'=>0,
				'errmsg'=>'ok' ,	
				'data'=>$tasklist, 
				);
				//$this->responseData($repjson);
			}
			$repjson = array(
			'tag'=>$data['tag'],  
			'errcode'=>0,
			'errmsg'=>'ok' ,	
			'data'=>array(), 
			);
		//	$this->responseData($repjson);
		
		}else{
				$repjson = array(
				'errcode'=>-1,
				'errmsg'=>'抱歉,请先登录或操作有误，请重试' , 
				'data'=>array()
				);
				$this->responseData($repjson);
			}
		     
			$data =array('list'=>$tasklist); 
		    $this->load->view('api/dotask_review',$data);	
	}
	
	//我要评分 
	public function dotask_score(){
		$member = $this->session->userdata('member'); 
		$data = $this->requestData();
		$mid = $member['id'];
		$company_id = $data['data']['company_id']?$data['data']['company_id']:1;//所属管理员
		
		$tasklist=array();
		if(!empty($mid)){	
			//判断当前用户是否是某人的专家
			$wherememberex['where']=array('exid'=>$mid,'status'=>1,'mex.company_id'=>$company_id);
			$member_ex=$this->member_ex->getList($wherememberex);
			$ex=array();//作为专家的用户
			if($member_ex){
				foreach($member_ex as $k => $v){
					$ex[$k]=$v['mid'];
				}
			}
			if(!empty($ex)){
				$where['wherein'] =$ex;
				$where['order'] =array('key'=>'taskid','value'=>'desc');
				$member_tasklist = $this->member_task->get_membertask_project($where);
				$res=array();
				foreach($member_tasklist as $k1 => $v1){
					if($v1['typeid']=="1"){
						$res = $this->task->get_one_by_id(array('t.id'=>$v1['taskid'],'t.company_id'=>$company_id));
						$member=$this->member->get_one_by_id(array('id'=>$v1['mid'],'company_id'=>$company_id));
						$resv['id']=$v1['id'];
						$resv['typeid']=$v1['typeid'];	
						$resv['projectid']=$v1['projectid'];	
						$resv['taskid']=$v1['taskid'];	
						$resv['title']=$res['title'];
						$resv['ptitle']=$res['ptitle'];
						$resv['realname']=$member['realname'];
						$resv['mid']=$v1['mid'];
						$resv['headerurl']=base_url().'uploads/member/header/'.$member['headerurl'];
						$planinfo=$this->task_plan->get_one_by_id(array('taskid'=>$v1['taskid'],'mid'=>$v1['mid'],'company_id'=>$company_id));
						$wentiinfo=$this->task_wenti->get_one_by_id(array('taskid'=>$v1['taskid'],'mid'=>$v1['mid'],'company_id'=>$company_id));
						$fansiinfo=$this->task_fansi->get_one_by_id(array('taskid'=>$v1['taskid'],'mid'=>$v1['mid'],'company_id'=>$company_id));
						if($planinfo && $wentiinfo && $fansiinfo){
							if($v1['isstatus']==0){
								$resv['isstatus']=0;	
							}else{
								$resv['isstatus']=1;	
							}
							$tasklist[]=$resv;
						}
					}else{
						$proinfo = $this->project->get_one_by_id(array('p.id'=>$v1['projectid'],'p.company_id'=>$company_id));
						$member=$this->member->get_one_by_id(array('id'=>$v1['mid'],'company_id'=>$company_id));
						$resv['id']=$v1['id'];
						$resv['typeid']=$v1['typeid'];	
						$resv['projectid']=$v1['projectid'];	
						$resv['taskid']=$v1['taskid'];	
						$resv['title']=$proinfo['title'];
						$resv['ptitle']='';
						$resv['realname']=$member['realname'];
						$resv['mid']=$v1['mid'];
						$resv['headerurl']=base_url().'uploads/member/header/'.$member['headerurl'];
						$planinfo=$this->task_plan->get_one_by_id(array('taskid'=>$v1['projectid'],'mid'=>$v1['mid'],'company_id'=>$company_id));
						$wentiinfo=$this->task_wenti->get_one_by_id(array('taskid'=>$v1['projectid'],'mid'=>$v1['mid'],'company_id'=>$company_id));
						$fansiinfo=$this->task_fansi->get_one_by_id(array('taskid'=>$v1['projectid'],'mid'=>$v1['mid'],'company_id'=>$company_id));
						if($planinfo && $wentiinfo && $fansiinfo){
							if($v1['isstatus']==0){
								$resv['isstatus']=0;	
							}else{
								$resv['isstatus']=1;	
							}
							$tasklist[]=$resv;
						}
					}
				}
			}
			$repjson = array(
					'tag'=>$data['tag'],  
					'errcode'=>0,
					'errmsg'=>'ok' ,	
					'data'=>$tasklist, 
				);
				//$this->responseData($repjson);
		}else{
				$repjson = array(
				'errcode'=>-1,
				'errmsg'=>'抱歉,请先登录或操作有误，请重试' , 
				'data'=>array()
				);
				$this->responseData($repjson);
			}
			
		    $data =array('list'=>$tasklist); 
		    $this->load->view('api/dotask_review',$data);
	}
	
	
	//请打分
	public function dotask_marking(){
		
		$member = $this->session->userdata('member'); 
		$data = $this->requestData();
		$mid = $member['id'];
		$company_id = $data['data']['company_id']?$data['data']['company_id']:1;//所属管理员
 
		$taskid = $data['data']['taskid'];//任务id
		$typeid = $data['data']['typeid'];//1为重大项目2位基础项目
		$projectid = $data['data']['proid'];//项目id
		$taskmid = $data['data']['taskmid'];//任务或所属项目mid
		$score=$data['data']['score'];//分数
		
		if(!empty($mid) && !empty($typeid)){	
			$task_markinginfo=$this->task_marking->get_one_by_id(array('taskmid'=>$taskmid,'taskid'=>$taskid,'projectid'=>$projectid,'typeid'=>$typeid,'mid'=>$mid));
			if($task_markinginfo){
				$repjson = array(
				'errcode'=>-1,
				'errmsg'=>'抱歉,您已打分！' , 
				'data'=>array()
				);
				$this->responseData($repjson);
			}else{
				$add['mid']=$mid;
				$add['typeid']=$typeid;
				$add['taskid']=$taskid;
				$add['projectid']=$projectid;
				$add['score']=$score;
				$add['taskmid']=$taskmid;
				$add['createtime']=time();
				$res=$this->task_marking->add($add);
				if($res){
					//项目结束
					$prostatus=0;
					$wheretask['where']=array('proid'=>$projectid,'t.company_id'=>$company_id);
					$tasklist = $this->task->getList($wheretask);
					foreach($tasklist as $k => $v){
						$task_markinginfo=$this->task_marking->get_one_by_id(array('taskid'=>$v['id'],'projectid'=>$projectid,'mid'=>$mid));
						if($task_markinginfo){
							$prostatus=0;
						}else{
							$prostatus=1;
							break;
						}
					}
					//修改项目状态
					if($prostatus==1){
						$up['status']=3;
						$this->project->update(array('id'=>$proid),$up);
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
					//统计个人得分
					$userfen=$this->userinfofen($mid,$company_id);
					if($userfen){
						$config = array('id'=>$mid);
						$updatedata['integraltotal'] = $userfen['total'];
						$this->member->update($config,$updatedata);
					}
					
					
					$repjson = array(
					'errcode'=>0,
					'errmsg'=>'提交成功！' , 
					'data'=>array()
					);
					$this->responseData($repjson);
				}else{
					$repjson = array(
					'errcode'=>-1,
					'errmsg'=>'抱歉,提交失败！' , 
					'data'=>array()
					);
					$this->responseData($repjson);
				}
			}
		}else{
				$repjson = array(
				'errcode'=>-1,
				'errmsg'=>'抱歉,请先登录或操作有误，请重试' , 
				'data'=>array()
				);
				$this->responseData($repjson);
		}
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
}
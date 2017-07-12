<?php
/**
*
*@用户信息接口
*/


class Userinfo extends Api_Controller
{
	public function __construct()
	{
		     
		parent::__construct();
		$this->load->model('member_mdl','member');
		$this->load->model('member_ex_mdl','member_ex');
		$this->load->model('project_mdl','project');
		$this->load->model('task_mdl','task');
		$this->load->model('member_task_mdl','member_task');
		$this->load->model('star_mdl','star');
		$this->load->model('gongshi_mdl','gongshi');
		$this->load->model('task_marking_mdl','task_marking');
		$this->load->model('messages_mdl','messages');
		$this->load->model('member_group_mdl','member_group');
		$this->load->model('member_group_relation_mdl','member_group_relation');
		$this->load->model('conquer_reply_mdl','conquer_reply');
		$this->load->model('member_qi_mdl','member_qi');
		$this->load->model('department_mdl','department');
		$this->load->model('jobs_mdl','jobs');
		$this->load->model('user_mdl','user');
		$this->load->model('invite_mdl','invite');
		$this->load->model('review_staff_mdl','review_staff');
		$this->load->model('task_plan_reply_mdl','task_plan_reply');
		$this->load->model('task_plan_mdl','task_plan');
		$this->load->model('task_wenti_mdl','task_wenti');
		$this->load->model('task_wenti_reply_mdl','task_wenti_reply');
		$this->load->model('task_fansi_mdl','task_fansi');
		$this->load->model('task_fansi_reply_mdl','task_fansi_reply');
		$this->load->library('session');
	}
	
	//通过域名获取所属管理员的id
	public function getDomain(){
		$data = $this->requestData();
		$domain = $data['data']['domain'];//域名
		$token = $data['data']['token'];
		$userinfo = $this->user->get_one_by_id(array('userdomain'=>$domain));
		if($userinfo){
			if($userinfo['id'] !=1 && date('Y-m-d',$userinfo['createtime'])<date('Y-m-d',time())){
					$result = array(
					'errcode'=>-1,
					'errmsg'=>'抱歉，您权限使用的期限已到期',
				);
				$this->responseData($result);
				exit;
			}else{
				$result = array(
					'company_id'=>$userinfo['id'],
					'errcode'=>0,
					'errmsg'=>'ok!',
				);
				$this->responseData($result);
				exit;
			}
		}else{
			$result = array(
				'errcode'=>-1,
				'errmsg'=>'抱歉，无权使用此应用',
			);
			$this->responseData($result);
			exit;
		}
	}
	
	//消息提醒
	public function message_reminder(){
		
		 $member = $this->session->userdata('member'); 
		$data = $this->requestData();
		$mid = $member['id'];
		$company_id = $data['data']['company_id']?$data['data']['company_id']:1;//所属管理员
		
		
		$message=array();
		if(!empty($mid) && !empty($company_id)){
			//项目
			$projectstatus=0;
			$where['where'] = array('headid'=>$mid,'status'=>0,'company_id'=>$company_id);
			$list = $this->invite->getList($where);
			if($list){
				$projectstatus=1;
			}
			//评审
			$reviewstatus=0;
			$wherere['where'] = array('mid'=>$mid,'isstatus'=>0,'company_id'=>$company_id);
			$listre = $this->review_staff->getList1($wherere);
			if($listre){
				$reviewstatus=1;
			}
			//指导专家评分与点评
			$dotaskstatus=0;
			$wheretask['wherein'] =$mid;
			$wheretask['order'] =array('key'=>'taskid','value'=>'desc');
			$member_tasklist = $this->member_task->get_membertask_project($wheretask);
			foreach($member_tasklist as $k1 => $v1){
				if($v1['typeid']=="1"){
					$planinfo=$this->task_plan->get_one_by_id(array('taskid'=>$v1['taskid'],'mid'=>$v1['mid'],'company_id'=>$company_id));
					$wentiinfo=$this->task_wenti->get_one_by_id(array('taskid'=>$v1['taskid'],'mid'=>$v1['mid'],'company_id'=>$company_id));
					$fansiinfo=$this->task_fansi->get_one_by_id(array('taskid'=>$v1['taskid'],'mid'=>$v1['mid'],'company_id'=>$company_id));
					if($planinfo && $wentiinfo && $fansiinfo){
						if($dotaskstatus==0){
							if($v1['isstatus']==0){
								$dotaskstatus=1;
								//echo 'aa';
							}
						}
					}
					if($planinfo || $wentiinfo){
						if($dotaskstatus==0){
							if($v1['isstatus']==0){
								$dotaskstatus=1;
								//echo 'bb';
							}
						}
					}
				}else{
					$proinfo = $this->project->get_one_by_id(array('p.id'=>$v1['projectid'],'p.company_id'=>$company_id));
					$planinfo=$this->task_plan->get_one_by_id(array('taskid'=>$v1['projectid'],'mid'=>$proinfo['mid'],'company_id'=>$company_id));
					$wentiinfo=$this->task_wenti->get_one_by_id(array('taskid'=>$v1['projectid'],'mid'=>$proinfo['mid'],'company_id'=>$company_id));
					$fansiinfo=$this->task_fansi->get_one_by_id(array('taskid'=>$v1['projectid'],'mid'=>$proinfo['mid'],'company_id'=>$company_id));
					if($planinfo && $wentiinfo && $fansiinfo){
						if($dotaskstatus==0){
							if($v1['isstatus']==0){
								$dotaskstatus=1;
								//echo 'cc';
							}
						}
					}
					if($planinfo || $wentiinfo){
						if($dotaskstatus==0){
							if($v1['isstatus']==0){
								$dotaskstatus=1;
								//echo 'dd';
							}
						}
					}
				}
			}
			//指导学员重大与基础项目
			$wherepro['where'] = array('mid'=>$mid,'company_id'=>$company_id);
			$wherepro['group'] ="projectid";
			$wherepro['order'] = array('key'=>'projectid','value'=>'desc');
			$prolist = $this->member_task->get_membertask_project($wherepro);
			if($prolist){
				if($dotaskstatus==0){
					foreach($prolist as $k => $v){
						if($v['typeid']==1){
							$w1['where']=array('p.taskid'=>$v['taskid'],'p.mid'=>$mid,'r.status'=>0);
							$list1 = $this->task_plan_reply->getList1($w1);
							
							if($list1){
								if($dotaskstatus==0){
									$dotaskstatus=1;
									//echo 'ee';
								}
							}
							$w2['where']=array('w.taskid'=>$v['taskid'],'w.mid'=>$mid,'r.status'=>0);
							$list2 = $this->task_wenti_reply->getList1($w2);
							if($list2){
								if($dotaskstatus==0){
									$dotaskstatus=1;
								}
							}
							$w3['where']=array('f.taskid'=>$v['taskid'],'f.mid'=>$mid,'r.status'=>0);
							$list3 = $this->task_fansi_reply->getList1($w3);
							if($list3){
								if($dotaskstatus==0){
									$dotaskstatus=1;
									//echo 'gg';
								}
							}
								//是否打分情况
							$task_markinginfo=$this->task_marking->get_one_by_id(array('taskid'=>$v['taskid'],'taskmid'=>$mid,'projectid'=>$v['projectid'],'status'=>0,'company_id'=>$company_id));
							if($task_markinginfo){
								if($dotaskstatus==0){
									$dotaskstatus=1;
									//echo 'hh';
								}
							}
							
						}else{
							$w1['where']=array('p.taskid'=>$v['projectid'],'p.mid'=>$mid,'r.status'=>0);
							$list1 = $this->task_plan_reply->getList1($w1);
							if($list1){
								if($dotaskstatus==0){
									$dotaskstatus=1;
									//echo 'oo';
								}
							}
							$w2['where']=array('w.taskid'=>$v['projectid'],'w.mid'=>$mid,'r.status'=>0);
							$list2 = $this->task_wenti_reply->getList1($w2);
							if($list2){
								if($dotaskstatus==0){
									$dotaskstatus=1;
									//echo 'pp';
								}
							}
							$w3['where']=array('f.taskid'=>$v['projectid'],'f.mid'=>$mid,'r.status'=>0);
							$list3 = $this->task_fansi_reply->getList1($w3);
							if($list3){
								if($dotaskstatus==0){
									$dotaskstatus=1;
									//echo 'qq';
								}
							}
								//是否打分情况
							$task_markinginfo=$this->task_marking->get_one_by_id(array('taskid'=>$v['taskid'],'projectid'=>$v['projectid'],'status'=>0,'company_id'=>$company_id));
							if($task_markinginfo){

								if($dotaskstatus==0){
									$dotaskstatus=1;
									//echo 'yy';
								}
							}
						
						}
					}
				}
			}
			
			//专家邀请提示
			$memberstatus=0;
			$wherememberex['where']=array('mex.exid'=>$mid,'status'=>0,'mex.company_id'=>$company_id);
			$member_ex=$this->member_ex->getList($wherememberex);
			if($member_ex){
				$memberstatus=1;
			}
			
			//问答箱提示
			$questionstatus=0;
			$messageswhere['where']=array('user_id'=>$mid,'status'=>0,'company_id'=>$company_id);
			$messageslist=$this->messages->getList($messageswhere);
			if($messageslist){
				$questionstatus=1;
			}
			$message[0]=array('type'=>1,'status'=>$projectstatus);//项目邀请
			$message[1]=array('type'=>2,'status'=>$reviewstatus);//评审
			$message[2]=array('type'=>3,'status'=>$dotaskstatus);//指导
			$message[3]=array('type'=>4,'status'=>$memberstatus);//邀请专家
			$message[4]=array('type'=>5,'status'=>$questionstatus);//问答箱提示
			
			$result = array(
			'errcode'=>0,
			'errmsg'=>'ok',
			'data'=>$message
			);
			$this->responseData($result);
		}else{
			$repjson = array(
			'errcode'=>-1,
			'errmsg'=>'抱歉,请先登录或操作有误，请重试' , 
			'data'=>$lists
			);
			$this->responseData($repjson);
		}
	}
	

	//获取用户信息
	public function index()
	{    
	    $member = $this->session->userdata('member'); 
		$data = $this->requestData();
		$mid = $member['id'];
		$company_id = $data['data']['company_id']?$data['data']['company_id']:1;//所属管理员
		
		$config = array('id'=>$mid,'company_id'=>$company_id);
 
		
		$userinfo = $this->member->get_one_by_id($config);

		if(empty($userinfo)){
		 //if($member['is_login']){
		    redirect('d=api&c=login');
		//} 
			exit;
		}
		$user['mobile'] = $userinfo['mobile'];
		$user['realname'] = $userinfo['realname'];
		$user['gender'] = $userinfo['gender'];
		$user['email'] = $userinfo['email'];
		$user['company'] = $userinfo['company'];
		$user['depid'] = $userinfo['depid'];
		$user['integraltotal'] = $userinfo['integraltotal'];
		
		$infodep = $this->department->get_one_by_id(array('id'=>$userinfo['depid'],'company_id'=>$company_id));
		if($infodep){
			$user['dep_name'] = $infodep['dep_name'];
		}else{
			$user['dep_name'] ='';
		}
		$infojob = $this->jobs->get_one_by_id(array('id'=>$userinfo['zhiwei'],'company_id'=>$company_id));
		if($infojob){
			$user['zhiweiname'] = $infojob['dep_name'];
		}else{
			$user['zhiweiname'] ='';
		}
		$user['zhiweiid'] =$userinfo['zhiwei'];
		$user['intro'] = $userinfo['intro'];
		$user['headerurl'] = base_url().'uploads/member/header/'.$userinfo['headerurl'];

		$result = array(
			'errcode'=>0,
			'errmsg'=>'ok',
			'data'=>$user
			);
			
		     //专家邀请提示
			$wherememberex['where']=array('mex.exid'=>$mid,'status'=>0,'mex.company_id'=>$company_id);
			$member_ex=$this->member_ex->getList($wherememberex);	
				 $jf = $this->member_integral();
			 
	    $data=array('user'=>$user,'member_ex'=>$member_ex,'jf'=>$jf);	
	 
		$this->load->view('api/user',$data);	
		//$this->responseData($result);
	}


    //获取用户信息
	public function user()
	{    
	    $member = $this->session->userdata('member'); 
		$data = $this->requestData();
		$mid = $member['id'];
		$company_id = $data['data']['company_id']?$data['data']['company_id']:1;//所属管理员
		
		$config = array('id'=>$mid,'company_id'=>$company_id);
 
		
		$userinfo = $this->member->get_one_by_id($config);

		if(empty($userinfo)){
		 //if($member['is_login']){
		    redirect('d=api&c=login');
		//} 
			exit;
		}
		$user['mobile'] = $userinfo['mobile'];
		$user['realname'] = $userinfo['realname'];
		$user['gender'] = $userinfo['gender'];
		$user['email'] = $userinfo['email'];
		$user['company'] = $userinfo['company'];
		$user['depid'] = $userinfo['depid'];
		$user['integraltotal'] = $userinfo['integraltotal'];
		
		$infodep = $this->department->get_one_by_id(array('id'=>$userinfo['depid'],'company_id'=>$company_id));
		if($infodep){
			$user['dep_name'] = $infodep['dep_name'];
		}else{
			$user['dep_name'] ='';
		}
		$infojob = $this->jobs->get_one_by_id(array('id'=>$userinfo['zhiwei'],'company_id'=>$company_id));
		if($infojob){
			$user['zhiweiname'] = $infojob['dep_name'];
		}else{
			$user['zhiweiname'] ='';
		}
		$user['zhiweiid'] =$userinfo['zhiwei'];
		$user['intro'] = $userinfo['intro'];
		$user['headerurl'] = base_url().'uploads/member/header/'.$userinfo['headerurl'];

		$result = array(
			'errcode'=>0,
			'errmsg'=>'ok',
			'data'=>$user
			);


			 
	    $data=array('user'=>$user);	
	 
		$this->load->view('api/userinfo',$data);	
		//$this->responseData($result);
	}




	//更新信息
	public function update()
	{
		$member = $this->session->userdata('member'); 
		$data = $this->requestData();
		$mid = $member['id'];
		$company_id = $data['data']['company_id']?$data['data']['company_id']:1;//所属管理员
		
		
		
        $add['realname'] = $data['data']['realname'];
        $add['depid'] = $data['data']['depid'];
        $add['zhiwei'] = $data['data']['position'];
        $add['gender'] = $data['data']['gender'];
        $add['intro'] = $data['data']['intro'];
        $add['email'] = $data['data']['email'];
        $add['intro'] = $data['data']['intro'];
      	$add['company'] = $data['data']['company'];
      	
        $config = array('id'=>$mid);
        $userinfo = $this->member->update($config,$add);

        $result = array('errcode'=>0,'errmsg'=>'ok');
        $this->responseData($result);
	}

	//更改用户头像
	public function update_header()
	{
		$data = $this->requestData();
		$mid = $data['data']['mid'];
		$token = $data['data']['token'];
		$dir = FCPATH.'/uploads/member/header/';
		$filedata = $data['data']['filedata']; //流数据
		$extension = $data['data']['extension'];   //文件类型(jpg,png,.....)
		if(!empty($filedata) && !empty($extension) && !empty($mid)){
			$filedata = str_replace(' ', '', $filedata);
			$filedata = urldecode($filedata);
			$img = base64_decode($filedata);
			$filename = 'h_'.time().'.'.$extension;
			$filedir = $dir.$filename;
			if(file_put_contents($filedir,$img)){
				$config = array('id'=>$mid);
				$updatedata['headerurl'] = $filename;
				$this->member->update($config,$updatedata);
				$repjson = array(
					'errcode'=>0,
					'errmsg'=>'修改成功' , 
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

	//修改密码

	public function changepwd()
	{
		$member = $this->session->userdata('member'); 
		$data = $this->requestData();
		$mid = $member['id'];
		 
		 if($_POST){
		
		$passwd = $data['data']['passwd'];

		if(!empty($mid) && !empty($passwd)){
			$config = array('id'=>$mid);
			$add['passwd'] = md5($passwd);
			$this->member->update($config,$add);
			$result = array('errcode'=>0,'errmsg'=>'ok');
        
		}else{
			$result = array('errcode'=>-1,'errmsg'=>'信息不完整');
		}
		$this->responseData($result);
		 }else{
			 
			$this->load->view('api/user_pass');		 
		  }
	}
	
	//获取个人积分数
	public function member_integral(){
		$member = $this->session->userdata('member'); 
		$data = $this->requestData();
		if($data['data']['mid']){
	    	$mid = $data['data']['mid'];
		}else{
		    $mid = $member['id'];
		}
		
	 
		$company_id = $data['data']['company_id']?$data['data']['company_id']:1;//所属管理员
		
		
 
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
						//$quality=0;
//						$task_markinglist=$this->task_marking->get_all(array('typeid'=>2,'projectid'=>$v['projectid'],'company_id'=>$company_id));
//						if($task_markinglist){
//							$mcout=count($task_markinglist);
//							foreach($task_markinglist as $km => $vm){
//								$quality=(float)$quality+(float)$vm['score'];
//							}
//							eval("\$jgq=$quality/$mcout;");
//							$quality=$jgq;
//						}else{
							$quality = $this->starval('3',$proinfo['quality'],$company_id);
						//}
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
			
			//专家邀请提示
			$wherememberex['where']=array('mex.exid'=>$mid,'status'=>0,'mex.company_id'=>$company_id);
			$member_ex=$this->member_ex->getList($wherememberex);

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
			//统计个人得分
			$config = array('id'=>$mid);
			$updatedata['integraltotal'] = $total;
		    $this->member->update($config,$updatedata);
			$memberinfo=$this->member->get_one_by_id(array('id'=>$mid,'company_id'=>$company_id));
					 
			 
			$datas = array(
					'majorcount'=>sprintf('%.2f',$majorcount),//重大项目分数
					'basiccount'=>sprintf('%.2f',$basiccount),//基础项目分数
					'conquercount'=>sprintf('%.2f',$conquercount),//复盘项目分数
					'peoplecount'=>sprintf('%.2f',$peoplecount),//人气分数
					'total'=>sprintf('%.2f',$total),//总分数
					'member_extotal'=>count($member_ex),//总分数
					'realname'=>$memberinfo['realname']
					);
			 
		    if($data['data']['mid']){
 
			 $this->load->view('api/index_user_info',$datas);	
			 }else{
			
			return	$datas;
					}
				//$this->responseData($repjson);
		}else{
				$repjson = array(
				'errcode'=>-1,
				'errmsg'=>'抱歉,请先登录或操作有误，请重试' , 
				'data'=>$lists
				);
				$this->responseData($repjson);
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
	
	
	//专家邀请列表
	public function invite_list(){
		//专家邀请列表
	    $member = $this->session->userdata('member'); 
		$data = $this->requestData();
		$mid = $member['id'];
		$company_id = $data['data']['company_id']?$data['data']['company_id']:1;//所属管理员
	 
		$lists=array();
		if(!empty($mid)){
			$wherememberex['where']=array('mex.exid'=>$mid,'mex.status'=>0,'mex.company_id'=>$company_id);
			$list=$this->member_ex->getList1($wherememberex);
			foreach($list as $k => $v){
				$memberinfo['exid']=$v['id'];
				$memberinfo['realname']=$v['realname'];
				$memberinfo['headerurl']=base_url().'uploads/member/header/'.$v['headerurl'];
				$memberinfo['mobile']=$v['mobile'];
				$lists[]=$memberinfo;
			}
			$repjson = array(
					'errcode'=>0,
					'errmsg'=>'提交成功！' , 
					'data'=>array('list'=>$lists, 
					)
			);
			$this->responseData($repjson);
		}else{
			$repjson = array(
				'errcode'=>-1,
				'errmsg'=>'抱歉,请先登录或操作有误，请重试' , 
				'data'=>array()
				);
				$this->responseData($repjson);
		}
	}
	
	//专家邀请拒绝与通过
	public function invite_submit(){
		//专家邀请列表
		$member = $this->session->userdata('member'); 
		$data = $this->requestData();
		$mid = $member['id'];
		$company_id = $data['data']['company_id']?$data['data']['company_id']:1;//所属管理员
		
		$exid = $data['data']['exid'];
	 	$type = $data['data']['type'];//1为接受,2为拒绝
		
		if(!empty($exid)){
			if($type==2){
				$this->member_ex->del(array('id'=>$exid,'company_id'=>$company_id));
			}
			if($type==1){
				$this->member_ex->update(array('id'=>$exid),array('status'=>1,'company_id'=>$company_id));
			}
			$repjson = array(
				'errcode'=>0,
				'errmsg'=>'操作成功' , 
				'data'=>array()
				);
			$this->responseData($repjson);
		}else{
			$repjson = array(
				'errcode'=>-1,
				'errmsg'=>'抱歉,请先登录或操作有误，请重试' , 
				'data'=>array()
				);
			$this->responseData($repjson);
		}
	}
	
	//会员联系人列表
	public function member_list(){
	    $member = $this->session->userdata('member'); 
		$data = $this->requestData();
		$mid = $member['id'];
		$company_id = $data['data']['company_id']?$data['data']['company_id']:1;//所属管理员
	    $name = $data['data']['name'];
		
	   $lists=array();
		if(!empty($mid)){
			$where['mid']=$mid;
			if(!empty($name)){
				$where['like']=array('realname'=>$name);
			}
			$where['where']=array('company_id'=>$company_id);
			$list=$this->member->get_all($where);
		 
			foreach($list as $k => $v){
				$memberinfo['id']=$v['id'];
				$memberinfo['realname']=$v['realname'];
				$memberinfo['headerurl']=base_url().'uploads/member/header/'.$v['headerurl'];
				$memberinfo['phone']=$v['mobile'];
				if($v['roleid']==1){
					$memberinfo['role']='员工';
				}
				if($v['roleid']==2){
					$memberinfo['role']='专家';
				}
				if($v['roleid']==3){
					$memberinfo['role']='领导';
				}
				$member_exinfo=$this->member_ex->get_one_by_id(array('mid'=>$mid,'exid'=>$v['id'],'company_id'=>$company_id));
			
				//if(!$member_exinfo){
					$lists[]=$memberinfo;
				//}
			}
			
			//邀请专家个数
			$wherememberex['where']=array('mid'=>$mid,'status'=>1,'mex.company_id'=>$company_id);
			$member_ex=$this->member_ex->getList($wherememberex);
		 
			 $data=array('list'=>$lists,'ex_num'=>count($member_ex),'ex_surplus'=>3-count($member_ex));
		 	//print_r($data);
			 $this->load->view('api/user_list',$data);
		}else{
		   	$repjson = array(
				'errcode'=>-1,
				'errmsg'=>'抱歉,请先登录或操作有误，请重试' , 
				'data'=>array()
				);
				
			$this->responseData($repjson);
		}
	}
	
	
	
		//会员联系人列表
	public function member_ajax_list(){
	    $member = $this->session->userdata('member'); 
		$data = $this->requestData();
		$mid = $member['id'];
		$company_id = $data['data']['company_id']?$data['data']['company_id']:1;//所属管理员
	    $name = $data['data']['name'];
	    $lists=array();
		if(!empty($mid)){
			//$where['mid']=$mid;
			if(!empty($name)){
				$where['like']=array('realname'=>$name);
			}
			$where['where']=array('company_id'=>$company_id);
			$list=$this->member->get_all($where);
 
			foreach($list as $k => $v){
				$memberinfo['id']=$v['id'];
				$memberinfo['realname']=$v['realname'];
				$memberinfo['headerurl']=base_url().'uploads/member/header/'.$v['headerurl'];
				$memberinfo['phone']=$v['mobile'];
				if($v['roleid']==1){
					$memberinfo['role']='员工';
				}
				if($v['roleid']==2){
					$memberinfo['role']='专家';
				}
				if($v['roleid']==3){
					$memberinfo['role']='领导';
				}
				$member_exinfo=$this->member_ex->get_one_by_id(array('mid'=>$mid,'exid'=>$v['id'],'company_id'=>$company_id));
				//if(!$member_exinfo){
					$lists[]=$memberinfo;
				//}
			}
			
			//邀请专家个数
			$wherememberex['where']=array('mid'=>$mid,'status'=>1,'mex.company_id'=>$company_id);
			$member_ex=$this->member_ex->getList($wherememberex);
		   $repjson = array(
				'errcode'=>0,
				'errmsg'=>'OK!' , 
				'data'=>array('list'=>$lists,'ex_num'=>count($member_ex),'ex_surplus'=>3-count($member_ex)
				)
			);
			 $data=array('list'=>$lists,'ex_num'=>count($member_ex),'ex_surplus'=>3-count($member_ex));
			 $this->load->view('api/ajax/member_list',$data);
			 
		}else{
		   	$repjson = array(
				'errcode'=>-1,
				'errmsg'=>'抱歉,请先登录或操作有误，请重试' , 
				'data'=>array()
				);
			$this->responseData($repjson);
		}
	}
	
		//会员联系人列表
	public function member_lists(){
		 $member = $this->session->userdata('member'); 
		$data = $this->requestData();
		$mid = $member['id'];
		$company_id = $data['data']['company_id']?$data['data']['company_id']:1;//所属管理员
	    $name = $data['data']['name'];
 
		$lists=array();
		if(!empty($mid)){
			$where['mid']=$mid;
			if(!empty($name)){
				$where['like']=array('realname'=>$name);
			}
			$where['where']=array('company_id'=>$company_id);
			$list=$this->member->get_all($where);
			foreach($list as $k => $v){
				$memberinfo['id']=$v['id'];
				$memberinfo['realname']=$v['realname'];
				$memberinfo['headerurl']=base_url().'uploads/member/header/'.$v['headerurl'];
				$memberinfo['phone']=$v['mobile'];
				if($v['roleid']==1){
					$memberinfo['role']='员工';
				}
				if($v['roleid']==2){
					$memberinfo['role']='专家';
				}
				if($v['roleid']==3){
					$memberinfo['role']='领导';
				}
				$member_exinfo=$this->member_ex->get_one_by_id(array('mid'=>$mid,'exid'=>$v['id'],'company_id'=>$company_id));
				if(!$member_exinfo){
					$lists[]=$memberinfo;
				}
			}
			
			//邀请专家个数
			$wherememberex['where']=array('mid'=>$mid,'status'=>1,'mex.company_id'=>$company_id);
			$member_ex=$this->member_ex->getList($wherememberex);
			$repjson = array(
				'errcode'=>0,
				'errmsg'=>'OK!' , 
				'data'=>array('list'=>$lists,'ex_num'=>count($member_ex),'ex_surplus'=>3-count($member_ex)
				)
			);
			$this->responseData($repjson);
		}else{
			$repjson = array(
				'errcode'=>-1,
				'errmsg'=>'抱歉,请先登录或操作有误，请重试' , 
				'data'=>array()
				);
			$this->responseData($repjson);
		}
	}
	
	
	//邀请专家提交
	public function invite_member_ex(){
	
	
	    $member = $this->session->userdata('member'); 
		$data = $this->requestData();
		$mid = $member['id'];
		$company_id = $data['data']['company_id']?$data['data']['company_id']:1;//所属管理员
	    $ex_list = $data['data']['ex_list'];
 
		if(!empty($mid)){
			//邀请专家个数
			$wherememberex['where']=array('mid'=>$mid,'status'=>1,'mex.company_id'=>$company_id);
			$member_ex=$this->member_ex->getList($wherememberex);
			
			if(count($member_ex)>3){
				$repjson = array(
					'errcode'=>-1,
					'errmsg'=>'抱歉,您的已有三位专家！' , 
					'data'=>array()
				);
				$this->responseData($repjson);
			}
			if($ex_list){
				if(count($ex_list)>(3-count($member_ex))){
					$repjson = array(
						'errcode'=>-1,
						'errmsg'=>'抱歉,拥有的专家人数不能超过三人！' , 
						'data'=>array()
						);
					$this->responseData($repjson);
				}
			 
				foreach($ex_list as $k => $v){
					$add['mid']=$mid;
					$add['exid']=$v;
					$add['status']=0;
					$add['company_id']=$company_id;
					$res=$this->member_ex->add($add);
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
				'errmsg'=>'抱歉,请选择人员，请重试' , 
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
	
	//问答箱
	public function messages_list(){
	    $member = $this->session->userdata('member'); 
		$data = $this->requestData();
		$mid = $member['id'];
		$company_id = $data['data']['company_id']?$data['data']['company_id']:1;//所属管理员
		 
		$limit = !empty($data['data']['limit']) ? $data['data']['limit'] : 10;
		$offset = !empty($data['data']['offset']) ? $data['data']['offset'] : 0;
		$lists=array();
		if(!empty($mid)){
			//我的专家
			$wherememberex['where']=array('mid'=>$mid,'status'=>1,'mex.company_id'=>$company_id);
			$member_ex=$this->member_ex->getList($wherememberex);
			foreach($member_ex as $k => $v){
				$member_ex[$k]['headerurl']=base_url().'uploads/member/header/'.$v['headerurl'];
			}
			$where['order']=array('key'=>'id','value'=>'desc');
			$where['group']='send_id';
			$where['where']=array('user_id'=>$mid);
			$where['page'] = true;
			$where['limit'] = $limit;
			$where['offset'] = $offset;
			$messages_list=$this->messages->getList($where);
			foreach($messages_list as $k => $v){
				$messagesinfo=$this->messages->get_one_by_id(array('send_id'=>$v['send_id'],'user_id'=>$v['user_id'],'company_id'=>$company_id));
				if($messagesinfo){
					$messagesinfo['headerurl']=base_url().'uploads/member/header/'.$messagesinfo['headerurl'];
					$messagesinfo['sendheaderurl']=base_url().'uploads/member/header/'.$messagesinfo['sendheaderurl'];
					$lists[]=$messagesinfo;
				}
			}
			$repjson = array(
					'errcode'=>0,
					'errmsg'=>'提交成功！' , 
					'data'=>array('member_ex'=>$member_ex, 'messages_list'=>$lists,
					)
					);
			//$this->responseData($repjson);
			$data = array('member_ex'=>$member_ex, 'messages_list'=>$lists,'member'=>$member);
		    
		    $this->load->view('api/message_list',$data);	
		}else{	
			 redirect('d=api&c=login','','','抱歉,请先登录或操作有误，请重试');
			 exit;
		}
		
		
	}
	
	//留言发送
	public function messages_send(){
	
	
	
	    $member = $this->session->userdata('member'); 
		$data = $this->requestData();
		$mid = $member['id'];
		$company_id = $data['data']['company_id']?$data['data']['company_id']:1;//所属管理员
		 
		$sendid = $data['data']['sendid'];
        $msg = $data['data']['msg'];
 
		if(!empty($mid) && !empty($sendid) && !empty($msg) && !empty($company_id)){
			$add['send_id']=$mid;
			$add['user_id']=$sendid;
			$add['company_id']=$company_id;
			$add['msg']=$msg;
			$add['send_id']=$mid;
			$add['createtime']=time();
			if($mid<$sendid){
				$add['messagesign']=$mid.$sendid.'no';
			}else{
				$add['messagesign']=$sendid.$mid.'no';
			}	
			$res=$this->messages->add($add);
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
		}else{	
			$repjson = array(
				'errcode'=>-1,
				'errmsg'=>'抱歉,请先登录或操作有误，请重试' , 
				'data'=>array()
				);
			$this->responseData($repjson);
		}
	}
	
	//个人留言窗口信息
	public function messages(){
	      $member = $this->session->userdata('member'); 
		$data = $this->requestData();
		$mid = $member['id'];
		$company_id = $data['data']['company_id']?$data['data']['company_id']:1;//所属管理员
		$sendid = $data['data']['sendid'];
 
		$limit = !empty($data['data']['limit']) ? $data['data']['limit'] : 10;
		$offset = !empty($data['data']['offset']) ? $data['data']['offset'] : 0;
		if(!empty($mid) && !empty($sendid) ){
			$memberinfo=$this->member->get_one_by_id(array('id'=>$sendid,'company_id'=>$company_id));
		 
			$where['order']=array('key'=>'createtime','value'=>'desc');
			if($mid<$sendid){
				$where['where']=array('messagesign'=>$mid.$sendid.'no','company_id'=>$company_id);
			}else{
				$add['messagesign']=$sendid.$mid.'no';
				$where['where']=array('messagesign'=>$sendid.$mid.'no','company_id'=>$company_id);
			}	
			
			$where['page'] = true;
			$where['limit'] = $limit;
			$where['offset'] = $offset;
			$messages_list=$this->messages->getList($where);
			foreach($messages_list as $k => $v){
				if($mid==$messages_list[$k]['send_id']){
					$messages_list[$k]['mestatus']=1;//我发送的
				}else{
					$messages_list[$k]['mestatus']=0;
				}
				$messages_list[$k]['createtime'] = date("Y-m-d",$v['createtime']);
				$messages_list[$k]['headerurl']=base_url().'uploads/member/header/'.$v['headerurl'];
				$messages_list[$k]['sendheaderurl']=base_url().'uploads/member/header/'.$v['sendheaderurl'];
				$this->messages->update(array('send_id'=>$sendid,'user_id'=>$mid,'status'=>0),array('status'=>1));//更新状态
			}
			$repjson = array(
					'errcode'=>0,
					'errmsg'=>'ok！' , 
					'data'=>array('username'=>$memberinfo['realname'],'uid'=>$mid, 'messages_list'=>$messages_list,
					)
					);
			$this->responseData($repjson);
		}else{	
			$repjson = array(
				'errcode'=>-1,
				'errmsg'=>'抱歉,请先登录或操作有误，请重试' , 
				'data'=>array()
				);
			$this->responseData($repjson);
		}
	}
	
	//分组联系人除了登陆人之外的联系人222222
	public function group_member_list(){
		$data = $this->requestData();
		$mid = $data['data']['mid'];
		$name = $data['data']['name'];
		$token = $data['data']['token'];
		$company_id = $data['data']['company_id'];//所属管理员
		$lists=array();
		if(!empty($mid)){
			$where['mid']=$mid;
			if(!empty($name)){
				$where['like']=array('realname'=>$name);
			}
			$where['where']=array('company_id'=>$company_id);
			$list=$this->member->get_all($where);
			foreach($list as $k => $v){
				$memberinfo['id']=$v['id'];
				$memberinfo['realname']=$v['realname'];
				$memberinfo['headerurl']=base_url().'uploads/member/header/'.$v['headerurl'];
				$memberinfo['phone']=$v['mobile'];
				if($v['roleid']==1){
					$memberinfo['role']='员工';
				}
				if($v['roleid']==2){
					$memberinfo['role']='专家';
				}
				if($v['roleid']==3){
					$memberinfo['role']='领导';
				}
				$lists[]=$memberinfo;
			}
			$repjson = array(
				'errcode'=>0,
				'errmsg'=>'OK!' , 
				'data'=>$lists
				);
			$this->responseData($repjson);
		}else{
			$repjson = array(
				'errcode'=>-1,
				'errmsg'=>'抱歉,请先登录或操作有误，请重试' , 
				'data'=>array()
				);
			$this->responseData($repjson);
		}
	}
	
	//会员创建新分组
	public function create_group(){
		$member = $this->session->userdata('member'); 
		$data = $this->requestData();
		$mid = $member['id'];
		$company_id = $data['data']['company_id']?$data['data']['company_id']:1;//所属管理员
		$title = $data['data']['title'];
 
		$lists=array();
		if(!empty($mid) && !empty($title)&& !empty($company_id)){
			$add['mid']=$mid;
			$add['title']=$title;
			$add['company_id']=$company_id;
			$add['createtime']=time();
			$res=$this->member_group->add($add);
			if($res){
				$repjson = array(
				'errcode'=>0,
				'errmsg'=>'提交成功！' , 
				'data'=>array('id'=>$this->member_group->insert_id())
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
				'errmsg'=>'抱歉,请先登录或操作有误，请重试' , 
				'data'=>array()
				);
			$this->responseData($repjson);
		}
	}
	
	//删除分组
	public function group_del(){
		$data = $this->requestData();
		$id = $data['data']['id'];
		$company_id = $data['data']['company_id'];//所属管理员
		$token = $data['data']['token'];
		if(!empty($id)){
			$this->member_group->del(array('id'=>$id,'company_id'=>$company_id));
			$this->member_group_relation->del(array('group_id'=>$id,'company_id'=>$company_id));
			$repjson = array(
				'errcode'=>0,
				'errmsg'=>'删除成功' , 
				'data'=>array()
				);
			$this->responseData($repjson);
		}else{
			$repjson = array(
				'errcode'=>-1,
				'errmsg'=>'抱歉,操作有误，请重试' , 
				'data'=>array()
				);
			$this->responseData($repjson);
		}
	}
	
	//会员加入到分组中
	public function group_member_add(){
	    $member = $this->session->userdata('member'); 
		$data = $this->requestData();
		$mid = $member['id'];
		$company_id = $data['data']['company_id']?$data['data']['company_id']:1;//所属管理员
		
		$groupid = $data['data']['groupid'];
 
		$member_list = $data['data']['member_list'];
	     foreach($member_list as $k=>$v){   
         if( !$v )   
         unset(  $member_list[$k] );   
        } 
 
		$token = $data['data']['token'];
		if(!empty($groupid) && !empty($mid)&& !empty($company_id)){
			if($member_list){
				foreach($member_list as $k => $v){
					$add['group_id']=$groupid;
					$add['company_id']=$company_id;
					$add['mid']=$v;
					$add['createtime']=time();
					$res=$this->member_group_relation->add($add);
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
				'errmsg'=>'抱歉,未选择会员' , 
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
	
	//删除分组中的成员
	public function group_member_del(){
		$data = $this->requestData();
		$id = $data['data']['id'];
		$mid = $data['data']['mid'];
		$company_id = $data['data']['company_id'];//所属管理员
		$token = $data['data']['token'];
		if(!empty($id) && !empty($mid) && !empty($company_id)){
			$this->member_group_relation->del(array('group_id'=>$id,'mid'=>$mid,'company_id'=>$company_id));
			$repjson = array(
				'errcode'=>0,
				'errmsg'=>'删除成功' , 
				'data'=>array()
				);
			$this->responseData($repjson);
		}else{
			$repjson = array(
				'errcode'=>-1,
				'errmsg'=>'抱歉,操作有误，请重试' , 
				'data'=>array()
				);
			$this->responseData($repjson);
		}
	}
	
	//分组列表
	public function group_list(){
		$member = $this->session->userdata('member'); 
		$data = $this->requestData();
		$mid = $member['id'];
		$company_id = $data['data']['company_id']?$data['data']['company_id']:1;//所属管理员
 
		$list=array();
		if(!empty($mid)){
			$where['where']=array('mid'=>$mid,'company_id'=>$company_id);
			$list=$this->member_group->getList($where);
			foreach($list as $k => $v){
				$wheregroup['where']=array('g.group_id'=>$v['id'],'g.company_id'=>$company_id);
				$wheregroup['order']=array('key'=>'integraltotal','value'=>'desc');
				$grouplist=$this->member_group_relation->getList($wheregroup);
				foreach($grouplist as $k1 => $v1){
					if($v1['roleid']==1){
						$grouplist[$k1]['role']='员工';
					}
					if($v1['roleid']==2){
						$grouplist[$k1]['role']='专家';
					}
					if($v1['roleid']==3){
						$grouplist[$k1]['role']='领导';
					}
					$grouplist[$k1]['headerurl']=base_url().'uploads/member/header/'.$v1['headerurl'];
				}
				$list[$k]['member_list']=$grouplist;
				$list[$k]['member_count']=count($grouplist);
				$list[$k]['headerurl']=base_url().'uploads/member/header/'.$v['headerurl'];
			}
			$repjson = array(
				'errcode'=>0,
				'errmsg'=>'OK!' , 
				'data'=>array('list'=>$list
				)
			);
	 
			
			 $data=array('list'=>$list);
			 $this->load->view('api/user_group_list',$data);
			
		}else{	
			$repjson = array(
				'errcode'=>-1,
				'errmsg'=>'抱歉,请先登录或操作有误，请重试' , 
				'data'=>array()
				);
			$this->responseData($repjson);
		}
	}
	
	//积分排行表
	public function group_list_inv(){
		$member = $this->session->userdata('member'); 
		$data = $this->requestData();
		$mid = $member['id'];
		$company_id = $data['data']['company_id']?$data['data']['company_id']:1;//所属管理员
 
		$list=array();
		if(!empty($mid)){
			$where['where']=array('mid'=>$mid,'company_id'=>$company_id);
			$list=$this->member_group->getList($where);
			foreach($list as $k => $v){
				$wheregroup['where']=array('g.group_id'=>$v['id'],'g.company_id'=>$company_id);
				$wheregroup['order']=array('key'=>'integraltotal','value'=>'desc');
				$grouplist=$this->member_group_relation->getList($wheregroup);
				foreach($grouplist as $k1 => $v1){
					if($v1['roleid']==1){
						$grouplist[$k1]['role']='员工';
					}
					if($v1['roleid']==2){
						$grouplist[$k1]['role']='专家';
					}
					if($v1['roleid']==3){
						$grouplist[$k1]['role']='领导';
					}
					$grouplist[$k1]['headerurl']=base_url().'uploads/member/header/'.$v1['headerurl'];
				}
				$list[$k]['member_list']=$grouplist;
				$list[$k]['member_count']=count($grouplist);
				$list[$k]['headerurl']=base_url().'uploads/member/header/'.$v['headerurl'];
			}
			$repjson = array(
				'errcode'=>0,
				'errmsg'=>'OK!' , 
				'data'=>array('list'=>$list
				)
			);
	 
			
			 $data=array('list'=>$list);
			// var_dump($list);
			 $this->load->view('api/user_group_list_inv',$data);
			
		}else{	
			$repjson = array(
				'errcode'=>-1,
				'errmsg'=>'抱歉,请先登录或操作有误，请重试' , 
				'data'=>array()
				);
			$this->responseData($repjson);
		}
	}
	
	
	
	//项目分布
	public function project_distribution(){
		
		$member = $this->session->userdata('member'); 
		$data = $this->requestData();
		$mid = $member['id'];
		$company_id = $data['data']['company_id']?$data['data']['company_id']:1;//所属管理员
		
		$counttotal=$this->project->get_count(array());//发布的项目总数
		$mtotal=$this->project->get_count(array('typeid'=>1,'company_id'=>$company_id));//重大项目总数
		$jtotal=$this->project->get_count(array('typeid'=>2,'company_id'=>$company_id));//基础项目总数
		eval("\$majortotal=$mtotal/$counttotal*100;");
		eval("\$basictotal=$jtotal/$counttotal*100;");
		
		//专家
		$ztotal=$this->project->get_count1(array('m2.roleid'=>2,'p.company_id'=>$company_id));
		//员工
		$ytotal=$this->project->get_count1(array('m2.roleid'=>1,'p.company_id'=>$company_id));
		//领导
		$ltotal=$this->project->get_count1(array('m2.roleid'=>3,'p.company_id'=>$company_id));
		
	  	eval("\$experttotal=$ztotal/$counttotal*100;");
		eval("\$employeetotal=$ytotal/$counttotal*100;");
		eval("\$leadertotal=$ltotal/$counttotal*100;");
		
		
		//重大项目特性
		$where1['where']=array('features'=>5,'typeid'=>1,'company_id'=>$company_id);
		$where1['sum']='features';
		$majorfeatures1=$this->project->get_sum($where1);
		$where2['where']=array('features'=>4,'typeid'=>1,'company_id'=>$company_id);
		$where2['sum']='features';
		$majorfeatures2=$this->project->get_sum($where2);
		$where3['where']=array('features'=>3,'typeid'=>1,'company_id'=>$company_id);
		$where3['sum']='features';
		$majorfeatures3=$this->project->get_sum($where3);
		$where4['where']=array('features'=>2,'typeid'=>1,'company_id'=>$company_id);
		$where4['sum']='features';
		$majorfeatures4=$this->project->get_sum($where4);
		$where5['where']=array('features'=>1,'typeid'=>1,'company_id'=>$company_id);
		$where5['sum']='features';
		$majorfeatures5=$this->project->get_sum($where5);
		//基础项目特性
		$bwhere1['where']=array('features'=>5,'typeid'=>2,'company_id'=>$company_id);
		$bwhere1['sum']='features';
		$basicfeatures1=$this->project->get_sum($bwhere1);
		$bwhere2['where']=array('features'=>4,'typeid'=>2,'company_id'=>$company_id);
		$bwhere2['sum']='features';
		$basicfeatures2=$this->project->get_sum($bwhere2);
		$bwhere3['where']=array('features'=>3,'typeid'=>2,'company_id'=>$company_id);
		$bwhere3['sum']='features';
		$basicfeatures3=$this->project->get_sum($bwhere3);
		$bwhere4['where']=array('features'=>2,'typeid'=>2,'company_id'=>$company_id);
		$bwhere4['sum']='features';
		$basicfeatures4=$this->project->get_sum($bwhere4);
		$bwhere5['where']=array('features'=>1,'typeid'=>2,'company_id'=>$company_id);
		$bwhere5['sum']='features';
		$basicfeatures5=$this->project->get_sum($bwhere5);
		$repjson = array(
				'errcode'=>0,
				'errmsg'=>'ok!' , 
				'data'=>array(
					'project'=>array('majorproject'=>round($majortotal),'basicproject'=>round($basictotal)),
					'member'=>array('experttotal'=>round($experttotal),'employeetotal'=>round($employeetotal),'leadertotal'=>round($leadertotal)),
					'majorfeatures'=>array('majorfeatures1'=>$majorfeatures1,'majorfeatures2'=>$majorfeatures2,'majorfeatures3'=>$majorfeatures3,'majorfeatures4'=>$majorfeatures4,'majorfeatures5'=>$majorfeatures5),
					'basicfeatures'=>array('basicfeatures1'=>$basicfeatures1,'basicfeatures2'=>$basicfeatures2,'basicfeatures3'=>$basicfeatures3,'basicfeatures4'=>$basicfeatures4,'basicfeatures5'=>$basicfeatures5),
				)
				);
			
			$datas  =array(
					'project'=>array('majorproject'=>round($majortotal),'basicproject'=>round($basictotal)),
					'member'=>array('experttotal'=>round($experttotal),'employeetotal'=>round($employeetotal),'leadertotal'=>round($leadertotal)),
					'majorfeatures'=>array('majorfeatures1'=>sprintf("%.2f",$majorfeatures1),'majorfeatures2'=>sprintf("%.2f",$majorfeatures2),'majorfeatures3'=>sprintf("%.2f",$majorfeatures3),'majorfeatures4'=>sprintf("%.2f",$majorfeatures4),'majorfeatures5'=>sprintf("%.2f",$majorfeatures5)),
					'basicfeatures'=>array('basicfeatures1'=>sprintf("%.2f",$basicfeatures1),'basicfeatures2'=>sprintf("%.2f",$basicfeatures2),'basicfeatures3'=>sprintf("%.2f",$basicfeatures3),'basicfeatures4'=>sprintf("%.2f",$basicfeatures4),'basicfeatures5'=>sprintf("%.2f",$basicfeatures5)),
				);
 
		    $this->load->view('api/user_fenbu',$datas);			 
				 
			//$this->responseData($repjson);
	}
	//画圆形图
	public function putimg(){
	 $data = $this->requestData();
	 	
		
	$image = imagecreatetruecolor(100, 100);                //创建画布大小为100x100
         //设置图像中所需的颜色，相当于在画画时准备的染料盒
    $white = imagecolorallocate($image,242, 246,255);          //为图像分配颜色为白色
	 imagefill($image, 0, 0, $white);  
	$a=$data['data']['a'];
	$c1=$data['data']['c1'];
	$c2= $data['data']['c2'];
	$c3= $data['data']['c3'];
 
	if($a ==1 ){
	$dongda = imagecolorallocate($image, 255, 148, 10);      
	$jichu = imagecolorallocate($image, 255, 182, 51);      
   
	$b1 = round(360/(100/$c1));
	$b2 = round(360/(100/$c2)); 
	        
    imagefilledarc($image, 50, 50, 100, 100, 0, $b1, $dongda, IMG_ARC_PIE);      //画一椭圆弧且填充
    imagefilledarc($image, 50, 50, 100, 100, $b1,360, $jichu, IMG_ARC_PIE);      //画一椭圆弧且填充
    imagestring($image, 2, 45, 65, $c1.'%', $white);                //水平地画一行字符串
    imagestring($image, 2, 45, 15, $c2.'%', $white);                //水平地画一行字符串
	}
	
	if($a ==2 ){
	$yuangong = imagecolorallocate($image, 67, 189, 238);      
	$zhuangjia = imagecolorallocate($image, 0, 169, 236);    
	$lingdao = imagecolorallocate($image, 105, 212, 255);   
	
	array('yuangong'=>array());
	
	   
    if($c1>0){
    $b1 = round(360/(100/$c1));
		}
	if($c2>0){
	$b2 = round(360/(100/$c2)); 
	}
	if($c3>0){
    $b3 = round(360/(100/$c3));
	}
 
    if($c3 >0){
    imagefilledarc($image, 50, 50, 100, 100, 0, $b1, $yuangong, IMG_ARC_PIE);      //画一椭圆弧且填充
	imagefilledarc($image, 50, 50, 100, 100, $b1,$b2+$b1, $zhuangjia, IMG_ARC_PIE);      //画一椭圆弧且填充
	imagefilledarc($image, 50, 50, 100, 100, ($b2+$b1),360, $lingdao, IMG_ARC_PIE);      //画一椭圆弧且填充
		
		}
		if($c3 <= 0){
			
 imagefilledarc($image, 50, 50, 100, 100, 0, $b1, $yuangong, IMG_ARC_PIE);      //画一椭圆弧且填充
	imagefilledarc($image, 50, 50, 100, 100, $b1,360, $zhuangjia, IMG_ARC_PIE);      //画一椭圆弧且填充
			
			}
    imagestring($image, 2, 65, 65, $c1.'%', $white);                //水平地画一行字符串
    imagestring($image, 2, 45, 15, $c2.'%', $white);                //水平地画一行字符串
	
	if($c3){
		imagestring($image, 2, 25, 15, $c3.'%', $white);                //水平地画一行字符串
		}
	
	
	}
   
	
 
    //向浏览器中输出一个GIF格式的图片
    header('Content-type:image/png');               //使用头函数告诉浏览器以图像方式处理以下输出
    imagepng($image);                       //向浏览器输出
    imagedestroy($image);                   //销毁图像释放资源
		
		
		}
	
	
	
	
	//部门列表
	public function department_list(){
		$data = $this->requestData();
		$token = $data['data']['token'];
		$company_id = $data['data']['company_id'];//所属管理员
		$where['where']=array('company_id'=>$company_id);
		$list = $this->department->getList($where);
		$repjson = array(
       			'errcode'=>0,
		 		'errmsg'=>'ok' , 
		 		'data'=>$list,
        );
       	$this->responseData($repjson);
	}
	
	//职位列表
	public function jobs_list(){
		$data = $this->requestData();
		$token = $data['data']['token'];
		$company_id = $data['data']['company_id'];//所属管理员
		$where['where']=array('company_id'=>$company_id);
		$list = $this->jobs->getList($where);
		$repjson = array(
       			'errcode'=>0,
		 		'errmsg'=>'ok' , 
		 		'data'=>$list,
        );
       	$this->responseData($repjson);
	}
	
	
	//删除聊天
	public function messages_del(){
		$data = $this->requestData();
		$token = $data['data']['token'];
		$company_id = $data['data']['company_id'];//所属管理员
		$messagesign = $data['data']['messagesign'];
		$messages_list=$this->messages->del(array('messagesign'=>$messagesign,'company_id'=>$company_id));
		$repjson = array(
       			'errcode'=>0,
		 		'errmsg'=>'ok' , 
		 		'data'=>array(),
        );
       	$this->responseData($repjson);
	
	}
	
	
	//人气积分列表
	public function integral_list(){
 
		$data = $this->requestData();
		$mid = $data['data']['id'];
		$company_id = $data['data']['company_id']?$data['data']['company_id']:1;//所属管理员
	    
		$typeid = $data['data']['typeid'];//1为重大项目2基础项目
 
		$list=array();
		$array=array();
		
		if(!empty($mid)){
			
			if($typeid=='1'){
				for($i=5;$i;$i--){
					$total=0;
					$c1=0;
					$c2=0;
					$c3=0;
					$majordifficulty1=0;
					$majordifficulty2=0;
					$majordifficulty3=0;
					$rwhere['where']=array('t.difficulty'=>$i,'mt.typeid'=>1,'mt.mid'=>$mid,'mt.company_id'=>$company_id);
					$alist=$this->member_task->get_task_member($rwhere);
				
					foreach($alist as $k => $v){
						$memberinfo=$this->member->get_one_by_id(array('id'=>$v['mid'],'company_id'=>$company_id));
			
						if($memberinfo){
							if($memberinfo['roleid']==1){
								$c1=$this->majorfen($mid,$v['taskid'],$v['projectid'],$company_id);
								$majordifficulty1=(float)$majordifficulty1+(float)$c1;
							}
							if($memberinfo['roleid']==2){
								$c2=$this->majorfen($mid,$v['taskid'],$v['projectid'],$company_id);
								$majordifficulty2=(float)$majordifficulty2+(float)$c2;
							}
							if($memberinfo['roleid']==3){
								$c3=$this->majorfen($mid,$v['taskid'],$v['projectid'],$company_id);
								$majordifficulty3=(float)$majordifficulty3+(float)$c3;
							}
						}
					}
					$arr['leadertotal']=$majordifficulty3;
					$arr['employeetotal']=$majordifficulty1;
					$arr['experttotal']=$majordifficulty2;
					$arr['total']=(float)$majordifficulty1+(float)$majordifficulty2+(float)$majordifficulty3;
					$memberinfo=$this->member->get_one_by_id(array('id'=>$mid));
					$arr['realname']=$memberinfo['realname'];
					if($memberinfo['roleid'] == '1' ){
					$name='员工';
					}elseif($memberinfo['roleid'] == '2' ){
					$name='专家';
					}else{
					$name='领导';
					}
					$arr['rolename']=$name;
					$array[]=$arr;
				}
				$list=$array;
			}
			if($typeid=='2'){
				for($i=5;$i;$i--){
					$total=0;
					$c1=0;
					$c2=0;
					$c3=0;
					$majordifficulty1=0;
					$majordifficulty2=0;
					$majordifficulty3=0;
					$rwhere['where']=array('p.difficulty'=>$i,'mt.typeid'=>2,'mt.mid'=>$mid,'mt.company_id'=>$company_id);
					$alist=$this->member_task->get_project_member($rwhere);
					
					foreach($alist as $k => $v){
						$memberinfo=$this->member->get_one_by_id(array('id'=>$v['mid'],'company_id'=>$company_id));
						if($memberinfo){
							if($memberinfo['roleid']==1){
								$c1=$this->basicfen($mid,$v['projectid'],$company_id);
								$majordifficulty1=(float)$majordifficulty1+(float)$c1;
							}
							if($memberinfo['roleid']==2){
								$c2=$this->basicfen($mid,$v['projectid'],$company_id);
								$majordifficulty2=(float)$majordifficulty2+(float)$c2;
							}
							if($memberinfo['roleid']==3){
								$c3=$this->basicfen($mid,$v['projectid'],$company_id);
								$majordifficulty3=(float)$majordifficulty3+(float)$c3;
							}
						
						}
					}
					$arr['employeetotal']=$majordifficulty1;
					$arr['experttotal']=$majordifficulty2;
					$arr['leadertotal']=$majordifficulty3;
					
					$arr['total']=(float)$majordifficulty1+(float)$majordifficulty2+(float)$majordifficulty3;
					$memberinfo=$this->member->get_one_by_id(array('id'=>$mid,'company_id'=>$company_id));
					$arr['realname']=$memberinfo['realname'];
					 
					$array[]=$arr;
				}
				$list=$array;
			}
			$repjson = array(
				'errcode'=>0,
				'errmsg'=>'ok!' , 
				'data'=>$list
				);
		 $datas=array('list'=>$list);
		 
			
			$this->load->view('api/user_integral_list',$datas);			
		}else{	
			$repjson = array(
				'errcode'=>-1,
				'errmsg'=>'抱歉,请先登录或操作有误，请重试' , 
				'data'=>array()
				);
			$this->responseData($repjson);
			
		}
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
		$majorcount=0;
		$taskinfo = $this->task->get_one_by_id(array('t.id'=>$taskid,'t.company_id'=>$company_id));	
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
				$majorcount=(float)$majorcount+(float)$taskcount;
				//echo (float)$taskcount.'cc';
			}
			$canyulistcout=$this->member_task->get_all(array('projectid'=>$projectid,'taskid'=>$taskid,'roleid'=>3,'company_id'=>$company_id));
			$hexinlistcout=$this->member_task->get_all(array('projectid'=>$projectid,'taskid'=>$taskid,'roleid'=>2,'company_id'=>$company_id));
			
			$hexinlist=$this->member_task->get_one_by_id(array('projectid'=>$projectid,'roleid'=>2,'mid'=>$mid,'taskid'=>$taskid,'company_id'=>$company_id));
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
			$canyulist=$this->member_task->get_all(array('projectid'=>$projectid,'roleid'=>3,'mid'=>$mid,'taskid'=>$taskid,'company_id'=>$company_id));
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
		return $majorcount;
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
			$procount= $jg; //标准分
			//领取情况,1-独立,2-核心,3-参与
			$dulilist=$this->member_task->get_one_by_id(array('projectid'=>$projectid,'roleid'=>1,'mid'=>$mid,'company_id'=>$company_id));
			if($dulilist){
				$basiccount=(float)$basiccount+(float)$procount;
				//echo $basiccount.'cc';
			}
			$canyulistcout=$this->member_task->get_all(array('projectid'=>$projectid,'roleid'=>3,'company_id'=>$company_id));
			$hexinlistcout=$this->member_task->get_all(array('projectid'=>$projectid,'roleid'=>2,'company_id'=>$company_id));
			$hexinlist=$this->member_task->get_one_by_id(array('projectid'=>$projectid,'roleid'=>2,'mid'=>$mid,'company_id'=>$company_id));
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
			$canyulist=$this->member_task->get_all(array('projectid'=>$projectid,'roleid'=>3,'mid'=>$mid,'company_id'=>$company_id));
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
		return $basiccount;
	}
	
	//分组添加会员联系人列表
	public function group_addmember(){
		$member = $this->session->userdata('member'); 
		$data = $this->requestData();
		$mid = $member['id'];
		$company_id = $data['data']['company_id']?$data['data']['company_id']:1;//所属管理员
		$name = $member['realname'];
		$groupid = $data['data']['groupid'];//分组id
		$list=array();
		$array=array();
		$lists=array();
		if(!empty($mid) && !empty($groupid)){
			$where['mid']=$mid;
			 
			if(!empty($name)){
				$where['like']=array('realname'=>$name);
			}
			
			$where['where']=array('company_id'=>$company_id);
			
			$list=$this->member->get_all($where);
			
			foreach($list as $k => $v){
				$memberinfo['id']=$v['id'];
				$memberinfo['realname']=$v['realname'];
				$memberinfo['headerurl']=base_url().'uploads/member/header/'.$v['headerurl'];
				$memberinfo['phone']=$v['mobile'];
				if($v['roleid']==1){
					$memberinfo['role']='员工';
				}
				if($v['roleid']==2){
					$memberinfo['role']='专家';
				}
				if($v['roleid']==3){
					$memberinfo['role']='领导';
				}
				$whereg['where']=array('g.mid'=>$mid,'r.mid'=>$v['id'],'g.company_id'=>$company_id);
				$listgroup=$this->member_group->getList1($whereg);
				
				if(!$listgroup){
					$lists[]=$memberinfo;
				}
			}
			
			$repjson = array(
				'errcode'=>0,
				'errmsg'=>'OK!' , 
				'data'=>$lists
				);
		     $data =array('list'=>$lists);
			 
			 $this->load->view('api/ajax/group_member_list',$data);	
		 
		
		}else{	
			$repjson = array(
				'errcode'=>-1,
				'errmsg'=>'抱歉,请先登录或操作有误，请重试' , 
				'data'=>array()
				);
			$this->responseData($repjson);
		}
	
	}
	
	
	//分组添加会员联系人列表(包括自己的)
	public function group_addmember1(){
	$member = $this->session->userdata('member'); 
		$data = $this->requestData();
		$mid = $member['id'];
		$company_id = $data['data']['company_id']?$data['data']['company_id']:1;//所属管理员
		//$name = $member['realname'];
		
		$groupid = $data['data']['groupid'];//分组id
 
		$list=array();
		$array=array();
		$lists=array();
		if(!empty($mid) && !empty($groupid)){
			//$where['mid']=$mid;
			if(!empty($name)){
				$where['like']=array('realname'=>$name);
			}
			$where['where']=array('company_id'=>$company_id);
			$list=$this->member->get_all($where);
			 
			foreach($list as $k => $v){
				$memberinfo['id']=$v['id'];
				$memberinfo['realname']=$v['realname'];
				$memberinfo['headerurl']=base_url().'uploads/member/header/'.$v['headerurl'];
				$memberinfo['phone']=$v['mobile'];
				if($v['roleid']==1){
					$memberinfo['role']='员工';
				}
				if($v['roleid']==2){
					$memberinfo['role']='专家';
				}
				if($v['roleid']==3){
					$memberinfo['role']='领导';
				}
				$whereg['where']=array('g.mid'=>$mid,'r.mid'=>$v['id'],'g.company_id'=>$company_id);
				$listgroup=$this->member_group->getList1($whereg);
				
				if(!$listgroup){
					$lists[]=$memberinfo;
				}
			}
			$repjson = array(
				'errcode'=>0,
				'errmsg'=>'OK!' , 
				'data'=>$lists
				);
	    $data =array('list'=>$lists);
			 
			 $this->load->view('api/ajax/group_member_list',$data);	
		
		}else{	
			$repjson = array(
				'errcode'=>-1,
				'errmsg'=>'抱歉,请先登录或操作有误，请重试' , 
				'data'=>array()
				);
			$this->responseData($repjson);
		}
	
	}
	
}
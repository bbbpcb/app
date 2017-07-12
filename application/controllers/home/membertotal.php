<?php

class Membertotal extends Admin_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('member_mdl','member');
        $this->load->model('member_ex_mdl','member_ex');
		$this->load->model('user_mdl','user');
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
	}

    //会员列表
	public function index()
	{
	    $page = isset($_GET['page']) ? $_GET['page'] : 0;
        $page = ($page && is_numeric($page)) ? intval($page) : 1;
		$data['pagesize']=$page;
        $roleid = isset($_REQUEST['typeid']) ? intval($_REQUEST['typeid']) : 0;
		$depid = isset($_REQUEST['depid']) ? intval($_REQUEST['depid']) : 0;
		$zhiweiid = isset($_REQUEST['zhiwei']) ? intval($_REQUEST['zhiwei']) : 0;
		$type_id = isset($_REQUEST['type']) ? intval($_REQUEST['type']) : 0;
       	$keyword = isset($_REQUEST['keyword']) ? $_REQUEST['keyword'] : '';
		$data['type_id'] = $type_id;
		$data['depid'] = $depid;
		$data['zhiweiid'] = $zhiweiid;
        $limit = 10;
        $offset = ($page - 1) * $limit;
        $pagination = ''; 
		$admininfo= $this->userinfo;//登陆信息
        $where1 = array();
		$where2 = array();
		$where=array();
		$wherelist=array();
        if(!empty($roleid)){
            $where1 =array_merge_recursive($where1, array('roleid'=>$roleid));
			$where2 =array_merge_recursive($where1, array('m.roleid'=>$roleid));
        }
		$where1=array_merge_recursive($where1,array('company_id'=>$admininfo['roleid']));
		$where2=array_merge_recursive($where2,array('d.company_id'=>$admininfo['roleid']));
		if(!empty($depid)){
			$where1=array_merge_recursive($where1,array('depid'=>$depid));
			$where2=array_merge_recursive($where2,array('m.depid'=>$depid));
		}
		if(!empty($zhiweiid)){
			$where1=array_merge_recursive($where1,array('zhiwei'=>$zhiweiid));
			$where2=array_merge_recursive($where2,array('m.zhiwei'=>$zhiweiid));
		}
		$where['where']=$where1;
		if(!empty($keyword)){
            $where['likeand'] = array('realname'=>$keyword);
			 $wherelist['likeand'] = array('m.realname'=>$keyword);
        }
		$wherelist['where']=$where2;
        $count = $this->member->get_count1($where);
       
        $this->load->library('pagination');
        $config['base_url'] = base_url().'index.php?d=home&c=membertotal&m=index&typeid='.$roleid.'&keyword='.$keyword;
        $config['total_rows'] = $count;
        //设置url上第几段用于传递分页器的偏移量
        $config ['uri_segment'] = 4;
        $config['per_page'] = $limit;
        $config['use_page_numbers'] = TRUE;
        $config['query_string_segment'] = 'page';
        $this->pagination->initialize($config);
        $data['page'] = $this->pagination->create_links();

        $list = array();
        $wherelist['page'] = true;
        $wherelist['limit'] = $limit;
        $wherelist['offset'] = $offset;
        $list = $this->member->getList3($wherelist);
		foreach($list as $k => $v){
			$list[$k]['star1']=$this->getfen(1,$type_id,$v['id'],$admininfo['roleid']);
			$list[$k]['star2']=$this->getfen(2,$type_id,$v['id'],$admininfo['roleid']);
			$list[$k]['star3']=$this->getfen(3,$type_id,$v['id'],$admininfo['roleid']);
			$list[$k]['star4']=$this->getfen(4,$type_id,$v['id'],$admininfo['roleid']);
			$list[$k]['star5']=$this->getfen(5,$type_id,$v['id'],$admininfo['roleid']);
		}
        $data['list'] = $list;
		$data['keyword'] = $keyword; 
		$data['roleid'] = $roleid; 

		 $this->load->model('department_mdl','dep');
		$wheredep['where'] = array('company_id'=>$admininfo['roleid']);
		$dep = $this->dep->getList($wheredep);
		$data['dep'] = $dep;
		
		$this->load->model('jobs_mdl','jobs');
		$wheredep['where'] = array('company_id'=>$admininfo['roleid']);
		$joblist = $this->jobs->getList($wheredep);
		$data['jobs'] = $joblist;
	   $this->load->view('home/home_member_total',$data);
	}
	
	public function getfen($star,$type_id,$mid,$company_id){
		$majordifficulty1=0;
		$majordifficulty2=0;
		$rwhere['where']=array('t.difficulty'=>$star,'mt.typeid'=>1,'mt.mid'=>$mid,'mt.company_id'=>$company_id);
		$alist=$this->member_task->get_task_member($rwhere);
		foreach($alist as $k => $v){
			$c1=$this->majorfen($mid,$v['taskid'],$v['projectid'],$company_id);
			$majordifficulty1=(float)$majordifficulty1+(float)$c1;
		}
		
		$rwhere1['where']=array('p.difficulty'=>$star,'mt.typeid'=>2,'mt.mid'=>$mid,'mt.company_id'=>$company_id);
		$alist=$this->member_task->get_project_member($rwhere1);

		foreach($alist as $k => $v){
			$c1=$this->basicfen($mid,$v['projectid'],$company_id);
			$majordifficulty2=(float)$majordifficulty2+(float)$c1;
		}
		if($type_id==1){
			return sprintf("%.2f",$majordifficulty1);
		}elseif($type_id==2){
			return sprintf("%.2f",$majordifficulty2);
		}
		$total=(float)$majordifficulty1+(float)$majordifficulty2;
		return sprintf("%.2f",$total);
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
}
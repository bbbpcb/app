<?php

class project extends Admin_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('project_mdl','project');
		$this->load->model('task_mdl','task');
        $this->load->model('member_mdl','member');
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
		$this->load->model('project_total_mdl','project_total');
	}

    //会员列表
	public function index()
	{
	    $page = isset($_GET['page']) ? $_GET['page'] : 0;
        $page = ($page && is_numeric($page)) ? intval($page) : 1;
        $typeid = isset($_REQUEST['typeid']) ? intval($_REQUEST['typeid']) : 0;
		$keyword = isset($_REQUEST['keyword']) ? $_REQUEST['keyword'] : '';
		$data['pagesize'] = $page;
        $limit = 10;
        $offset = ($page - 1) * $limit;
        $pagination = ''; 
		$where=array();
		$admininfo= $this->userinfo;//登陆信息
		if(!empty($typeid)){
			$where['where']=array('typeid'=>$typeid,'company_id'=>$admininfo['roleid']);
		}else{
			$where['where']=array('company_id'=>$admininfo['roleid']);
		}
		if(!empty($keyword)){
            $where['likeand'] = array('title'=>$keyword);
        }
		
        $count = $this->project->get_count2($where);

		$this->load->library('pagination');
        $config['base_url'] = base_url().'index.php?d=home&c=project&typeid='.$typeid.'&keyword='.$keyword;
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
		if(!empty($typeid)){
			$wherelist['where']=array('p.typeid'=>$typeid,'p.company_id'=>$admininfo['roleid']);
		}
		else{
			$wherelist['where']=array('p.company_id'=>$admininfo['roleid']);
		}
		if(!empty($keyword)){
            $wherelist['likeand'] = array('p.title'=>$keyword);
        }

        $list = $this->project->getList($wherelist);
        $data['list'] = $list;
		$data['typeid'] = $typeid;
		$data['keyword'] = $keyword;
	   $this->load->view('home/home_project',$data);
	}

    public function add()
    {
		$admininfo= $this->userinfo;//登陆信息
        if(!empty($_POST)){
            $data['title'] = $this->input->post('title');
            $data['scale'] = $this->input->post('scale');
            $data['difficulty'] = $this->input->post('difficulty');
            $data['quality'] = $this->input->post('quality');
            $data['features'] = $this->input->post('features');
            $data['intro'] = $this->input->post('intro');
            $data['status'] = $this->input->post('status');
           	 $data['company_id'] = $admininfo['roleid'];

            $id = isset($_POST['id']) ? $this->input->post('id') : '0';

            if($id){
                $config = array('id'=>$id);
                $this->project->update($config,$data);
            }else{
               
                $data['createtime'] = time();
                $data['headid'] = $this->input->post('headid');
                $data['mid'] = $this->input->post('mid');
                $data['typeid'] = $this->input->post('typeid');
                $this->project->add($data);
            }

            redirect('d=home&c=project');
        }else{ 
            $this->load->model('project_type_mdl','type');
            $type = $this->type->getList();
            $data['type'] = $type;
            //部门
			$where['where']=array('m.company_id'=>$admininfo['roleid']);
           $member = $this->member->getList($where);
           $data['member'] = $member;

            $this->load->view('home/home_project_add',$data);
        }
    }

    /**
    *修改
    */
    public function update()
    {
        $id = $this->input->get('id');
        $where = array('p.id'=>$id);
        $info =  $this->project->get_one_by_id($where);
        $data['info'] = $info;

        $this->load->model('project_type_mdl','dep');
        $type = $this->dep->getList();
        $data['type'] = $type;

                    //部门
        $this->load->model('department_mdl','department');
        $dep = $this->department->getList();
        $data['dep'] = $dep;

        $this->load->view('home/home_project_update',$data);

    }

		//delete
	public function del()
    {
		$admininfo= $this->userinfo;//登陆信息
		$id = $this->input->get('id');
		$where['id'] = $id;
		$proid=$id;
		//删除任务以及相关任务的数据
		$tasklist= $this->task->select(array('proid'=>$proid,'company_id'=>$admininfo['roleid']));
		if($tasklist){
			 foreach($tasklist as $k => $v){
				$task_fansi=$this->task_fansi->select(array('taskid'=>$v['id'],'company_id'=>$admininfo['roleid']));
				if($task_fansi){
					 foreach($task_fansi as $k1 => $v1){
							$this->task_fansi_reply->del(array('fansiid'=>$v1['id'],'company_id'=>$admininfo['roleid']));
					 }
				}
				$this->task_fansi->del(array('taskid'=>$v['id'],'company_id'=>$admininfo['roleid']));
				$task_plan=$this->task_plan->select(array('taskid'=>$v['id'],'company_id'=>$admininfo['roleid']));
				if($task_plan){
					 foreach($task_plan as $k1 => $v1){
							$this->task_plan_reply->del(array('planid'=>$v1['id'],'company_id'=>$admininfo['roleid']));
					 }
				}
				$this->task_plan->del(array('taskid'=>$v['id'],'company_id'=>$admininfo['roleid']));
				$task_wenti=$this->task_wenti->select(array('taskid'=>$v['id'],'company_id'=>$admininfo['roleid']));
				if($task_wenti){
					 foreach($task_wenti as $k1 => $v1){
							$this->task_wenti_reply->del(array('wentiid'=>$v1['id'],'company_id'=>$admininfo['roleid']));
					 }
				}
				$this->task_plan->del(array('taskid'=>$v['id'],'company_id'=>$admininfo['roleid']));
			 }
		 }
		 $this->task->del(array('proid'=>$proid,'company_id'=>$admininfo['roleid']));//删除项目对应的任务
		 //删除评审以及评审相关的数据
		 $reviewlist=$this->review->select(array('proid'=>$proid,'company_id'=>$admininfo['roleid']));
		 if($reviewlist){
			foreach($reviewlist as $k => $v){
				$review_question=$this->review_question->select(array('revid'=>$v['id'],'company_id'=>$admininfo['roleid']));
				if($review_question){
					foreach($review_question as $k1 => $v1){
						$this->review_question_feedback->del(array('revid'=>$v1['id'],'company_id'=>$admininfo['roleid']));
					}
				}
				$this->review_question->del(array('revid'=>$v['id'],'company_id'=>$admininfo['roleid']));
				$this->review_staff->del(array('revid'=>$v['id'],'company_id'=>$admininfo['roleid']));
			}
		 }
		$this->review->del(array('proid'=>$proid,'company_id'=>$admininfo['roleid']));
		//删除项目负责人邀请表
		$this->invite->del(array('pid'=>$proid,'company_id'=>$admininfo['roleid']));
		//用户领取项目表
		$this->member_task->del(array('projectid'=>$proid,'company_id'=>$admininfo['roleid']));
		//删除项目统计
		$this->project_total->del(array('proid'=>$proid,'company_id'=>$admininfo['roleid']));
		$this->project->del(array('id'=>$proid,'company_id'=>$admininfo['roleid']));
		redirect('d=home&c=project');
	}
	
	/*
	 *删除多条数据
	 */
	public function delall(){
		$admininfo= $this->userinfo;//登陆信息
		$ids = $_POST['ids'];
		$ids = explode('-',$ids);
		foreach($ids as $id){
			if(!empty($id)){
				$proid=$id;
				//删除任务以及相关任务的数据
				$tasklist= $this->task->select(array('proid'=>$proid,'company_id'=>$admininfo['roleid']));
				if($tasklist){
					 foreach($tasklist as $k => $v){
						$task_fansi=$this->task_fansi->select(array('taskid'=>$v['id'],'company_id'=>$admininfo['roleid']));
						if($task_fansi){
							 foreach($task_fansi as $k1 => $v1){
									$this->task_fansi_reply->del(array('fansiid'=>$v1['id'],'company_id'=>$admininfo['roleid']));
							 }
						}
						$this->task_fansi->del(array('taskid'=>$v['id'],'company_id'=>$admininfo['roleid']));
						$task_plan=$this->task_plan->select(array('taskid'=>$v['id'],'company_id'=>$admininfo['roleid']));
						if($task_plan){
							 foreach($task_plan as $k1 => $v1){
									$this->task_plan_reply->del(array('planid'=>$v1['id'],'company_id'=>$admininfo['roleid']));
							 }
						}
						$this->task_plan->del(array('taskid'=>$v['id'],'company_id'=>$admininfo['roleid']));
						$task_wenti=$this->task_wenti->select(array('taskid'=>$v['id'],'company_id'=>$admininfo['roleid']));
						if($task_wenti){
							 foreach($task_wenti as $k1 => $v1){
									$this->task_wenti_reply->del(array('wentiid'=>$v1['id'],'company_id'=>$admininfo['roleid']));
							 }
						}
						$this->task_plan->del(array('taskid'=>$v['id'],'company_id'=>$admininfo['roleid']));
					 }
				 }
				 $this->task->del(array('proid'=>$proid,'company_id'=>$admininfo['roleid']));//删除项目对应的任务
				 //删除评审以及评审相关的数据
				 $reviewlist=$this->review->select(array('proid'=>$proid,'company_id'=>$admininfo['roleid']));
				 if($reviewlist){
					foreach($reviewlist as $k => $v){
						$review_question=$this->review_question->select(array('revid'=>$v['id'],'company_id'=>$admininfo['roleid']));
						if($review_question){
							foreach($review_question as $k1 => $v1){
								$this->review_question_feedback->del(array('revid'=>$v1['id'],'company_id'=>$admininfo['roleid']));
							}
						}
						$this->review_question->del(array('revid'=>$v['id'],'company_id'=>$admininfo['roleid']));
						$this->review_staff->del(array('revid'=>$v['id'],'company_id'=>$admininfo['roleid']));
					}
				 }
				 $this->review->del(array('proid'=>$proid,'company_id'=>$admininfo['roleid']));
				 //删除项目负责人邀请表
				 $this->invite->del(array('pid'=>$proid,'company_id'=>$admininfo['roleid']));
				 //用户领取项目表
				 $this->member_task->del(array('projectid'=>$proid,'company_id'=>$admininfo['roleid']));
				 
				 //删除项目统计
				$this->project_total->del(array('proid'=>$proid,'company_id'=>$admininfo['roleid']));
				$this->project->del(array('id'=>$id,'company_id'=>$admininfo['roleid']));
			}
		}
		return 1;
	}

}
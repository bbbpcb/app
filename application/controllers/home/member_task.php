<?php
/**
*
*@DEC会员领取任务管理
*/


class Member_task extends Admin_Controller
{
	

	public function __construct()
	{
		parent::__construct();
		$this->load->model('member_task_mdl','member_task');
	}


	public function index()
	{
		$admininfo= $this->userinfo;//登陆信息
		$page = isset($_GET['page']) ? $_GET['page'] : 0;
        $page = ($page && is_numeric($page)) ? intval($page) : 1;
        $taskid = isset($_GET['taskid']) ? intval($_GET['taskid']) : 0;
		$proid = isset($_GET['proid']) ? intval($_GET['proid']) : 0;
		$typeid = isset($_GET['type_id']) ? intval($_GET['type_id']) : 0;
		$modid = isset($_GET['modid']) ? intval($_GET['modid']) : 0;
        $limit = 20;
        $offset = ($page - 1) * $limit;
        $pagination = ''; 
		if($typeid==1){
        	empty($taskid) ? $where = array() : $where=array('taskid'=>$taskid,'modid'=>$modid,'company_id'=>$admininfo['roleid']);
		}else{
			empty($proid) ? $where = array() : $where=array('projectid'=>$proid,'company_id'=>$admininfo['roleid']);
		}
        $count = $this->member_task->get_count($where);   
		
        $this->load->library('pagination');
        $config['base_url'] = base_url().'index.php?d=home&c=member_task&taskid='.$taskid;
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
		if($typeid==1){
        	empty($taskid) ? $wherelist['where'] = array() : $wherelist['where'] = array('mt.taskid'=>$taskid,'mt.modid'=>$modid,'mt.company_id'=>$admininfo['roleid']);
		}else{
			empty($proid) ? $wherelist['where'] = array() : $wherelist['where'] = array('mt.projectid'=>$proid,'mt.company_id'=>$admininfo['roleid']);
		}
        $list = $this->member_task->getList($wherelist);
        $data['list'] = $list;

        $this->load->view('home/home_member_task',$data);
	}
	
	public function del()
    {
		$id = $this->input->get('id');
		$where['id'] = $id;
		$this->member_task->del($where);
		redirect('d=home&c=task');
	}
}
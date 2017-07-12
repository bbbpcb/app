<?php

class Mod extends Admin_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('mod_mdl','mod');
	}

    //会员列表
	public function index()
	{
	    $page = isset($_GET['page']) ? $_GET['page'] : 0;
        $page = ($page && is_numeric($page)) ? intval($page) : 1;
		$data['pagesize']=$page;
        $pid = isset($_GET['pid']) ? $_GET['pid'] : 0;
		$keyword = isset($_REQUEST['keyword']) ? $_REQUEST['keyword'] : '';
        $data['pid'] = $pid;
		$data['keyword'] = $keyword;
        $limit = 20;
        $offset = ($page - 1) * $limit;
        $pagination = ''; 
       	$admininfo= $this->userinfo;//登陆信息
        $where=array();
		if(!empty($pid)){
			$where['where']=array('pid'=>$pid,'company_id'=>$admininfo['roleid']);
		}else{
			$where['where']=array('company_id'=>$admininfo['roleid']);
		}
		if(!empty($keyword)){
            $where['likeand'] = array('m_name'=>$keyword);
        }
		
        $count = $this->mod->get_count1($where);

        $this->load->library('pagination');
        $config['base_url'] = base_url().'index.php?d=home&c=mod&keyword='.$keyword;
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
        $wherelist['order'] = array('key'=>'rank','value'=>'ASC');
		if(!empty($pid)){
			$wherelist['where']=array('pid'=>$pid,'company_id'=>$admininfo['roleid']);
		}else{
			$wherelist['where']=array('company_id'=>$admininfo['roleid']);
		}
		if(!empty($keyword)){
            $wherelist['likeand'] = array('m_name'=>$keyword);
        }
        $list = $this->mod->getList($wherelist);
        $data['list'] = $list;

        //模块任务统计
        $task = array();
        $this->load->model('task_mdl','task');
        $task = $this->task->getCountBygroup();
       // print_r($task);
        //$task = 
        $taskcount = array();
        if(!empty($task)){
            foreach($task as $k => $v){
                $taskcount[$v['modid']] = $v['total'];
            }
        }

        $data['taskcount'] = $taskcount;
        //print_R($taskcount);
	   $this->load->view('home/home_mod',$data);
	}

    public function add()
    {
		$admininfo= $this->userinfo;//登陆信息
        if(!empty($_POST)){
            $data['m_name'] = $this->input->post('m_name');
          	$data['company_id'] =$admininfo['roleid'];
            $data['rank'] = $this->input->post('rank');

            $id = isset($_POST['id']) ? $this->input->post('id') : '0';

            if($id){
                $config = array('id'=>$id);
                $this->mod->update($config,$data);
            }else{
                           
                $this->mod->add($data);
            }

            redirect('d=home&c=mod');
        }else{ 
            $this->load->model('project_mdl','project');
            $project = $this->project->getList();
            $data['project'] = $project;
            //部门

            $this->load->view('home/home_mod_add',$data);
        }
    }

    /**
    *修改
    */
    public function update()
    {
        $id = $this->input->get('id');
        $where = array('id'=>$id);
        $info =  $this->mod->get_one_by_id($where);
        $data['info'] = $info;

                    //部门
        $this->load->model('project_mdl','project');
        $project = $this->project->getList();
        $data['project'] = $project;

        $this->load->view('home/home_mod_update',$data);

    }

		//delete
	public function del()
    {
		$id = $this->input->get('id');
		$pid = $this->input->get('pid');
		$where['id'] = $id;
		$this->mod->del($where);
		redirect('d=home&c=mod&pid='.$pid);
	}
	
	/*
	 *删除多条数据
	 */
	public function delall(){
		$ids = $_POST['ids'];
		$ids = explode('-',$ids);
		foreach($ids as $id){
			if(!empty($id)){
				$this->mod->del(array('id'=>$id));
			}
		}
		return 1;
	}
}
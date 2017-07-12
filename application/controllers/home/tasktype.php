<?php
/**
*@任务类型
*
**/
class Tasktype extends Admin_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('task_type_mdl','task_type');
		$this->load->model('mod_mdl','mod');
	}

    //会员列表
	public function index()
	{
	    $page = isset($_GET['page']) ? $_GET['page'] : 0;
        $page = ($page && is_numeric($page)) ? intval($page) : 1;
		$data['pagesize']=$page;
       	$keyword = isset($_REQUEST['keyword']) ? $_REQUEST['keyword'] : '';
		$admininfo= $this->userinfo;//登陆信息
        $limit = 20;
        $offset = ($page - 1) * $limit;
        $pagination = ''; 
       	$where=array();
		$where['where']=array('company_id'=>$admininfo['roleid']);
		if(!empty($keyword)){
            $where['likeand'] = array('type_name'=>$keyword);
        }
      
        $count = $this->task_type->get_count1($where);

        $this->load->library('pagination');
        $config['base_url'] = base_url().'index.php?d=home&c=tasktype&keyword='.$keyword;
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
		if(!empty($keyword)){
            $wherelist['likeand'] = array('type_name'=>$keyword);
        }
		$wherelist['where']=array('company_id'=>$admininfo['roleid']);
        $wherelist['order'] = array('key'=>'rank','value'=>'ASC');
        
        $list = $this->task_type->getList($wherelist);
        $data['list'] = $list;

        //任务类型统计
        $tasktype = array();
        $this->load->model('task_type_mdl','task_type');
        $tasktype = $this->task_type->getCountBygroup();

        $tasktypecount = array();
        if(!empty($tasktype)){
            foreach($tasktype as $k => $v){
                $tasktypecount[$v['task_type']] = $v['total'];
            }
        }
		$data['keyword'] = $keyword;
        $data['tasktypecount'] = $tasktypecount;
        //print_r($tasktypecount);
	    $this->load->view('home/home_task_type',$data);
	}

    public function add()
    {
		$admininfo= $this->userinfo;//登陆信息
        if(!empty($_POST)){
            $data['type_name'] = $this->input->post('type_name');
          	$data['company_id'] =$admininfo['roleid'];
            $data['rank'] = $this->input->post('rank');
			$data['modid'] = $this->input->post('t_type');
            $id = isset($_POST['id']) ? $this->input->post('id') : '0';

            if($id){
                $config = array('id'=>$id);
                $this->task_type->update($config,$data);
            }else{
                           
                $this->task_type->add($data);
            }

            redirect('d=home&c=tasktype');
        }else{ 
			$w['where']=array('company_id'=>$admininfo['roleid']);
           	$list = $this->mod->getList($w);
        	$data['list'] = $list;
            $this->load->view('home/home_task_type_add',$data);
        }
    }

    /**
    *修改
    */
    public function update()
    {
		$admininfo= $this->userinfo;//登陆信息
        $id = $this->input->get('id');
        $where = array('id'=>$id);
        $info =  $this->task_type->get_one_by_id($where);
        $data['info'] = $info;
		$w['where']=array('company_id'=>$admininfo['roleid']);
        $list = $this->mod->getList($w);
		$data['list'] = $list;
        $this->load->view('home/home_task_type_update',$data);

    }

	//delete
	public function del()
    {
		$id = $this->input->get('id');
		$pid = $this->input->get('pid');
		$where['id'] = $id;
		$this->task_type->del($where);
		redirect('d=home&c=tasktype');
	}
	
	/*
	 *删除多条数据
	 */
	public function delall(){
		$ids = $_POST['ids'];
		$ids = explode('-',$ids);
		foreach($ids as $id){
			if(!empty($id)){
				$this->task_type->del(array('id'=>$id));
			}
		}
		return 1;
	}
}
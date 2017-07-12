<?php
/*
*复盘类型
**/

class replay_type extends Admin_Controller
{
	

	public function __construct()
	{
		parent::__construct();
		$this->load->model('replay_type_mdl','replay_type');
	}



	public function index()
	{
		$admininfo= $this->userinfo;//登陆信息
		$page = isset($_GET['page']) ? $_GET['page'] : 0;
        $page = ($page && is_numeric($page)) ? intval($page) : 1;
		$keyword = isset($_REQUEST['keyword']) ? $_REQUEST['keyword'] : '';
		$data['keyword'] = $keyword;
        $limit = 20;
        $offset = ($page - 1) * $limit;
        $pagination = ''; 
       
        $where=array();
		
		if(!empty($keyword)){
            $where['likeand'] = array('type_name'=>$keyword,'company_id'=>$admininfo['roleid']);
        }else{
			$where['where']=array('company_id'=>$admininfo['roleid']);
		}
		
        $count = $this->replay_type->get_count1($where);

        $this->load->library('pagination');
        $config['base_url'] = base_url().'index.php?d=home&c=replay_type&keyword='.$keyword;
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
		if(!empty($keyword)){
            $wherelist['likeand'] = array('type_name'=>$keyword,'company_id'=>$admininfo['roleid']);
        }else{
			$where['where'] = array('company_id'=>$admininfo['roleid']);
		}
		$list = $this->replay_type->getList($where);
		$data['list'] = $list;
		$data['keyword'] = $keyword;


		$this->load->view('home/home_replay_type',$data);
	}

	//新增
	public function add()
	{
		$admininfo= $this->userinfo;//登陆信息
		if(!empty($_POST)){
			$type_name = $this->input->post('type_name');
			$rank = $this->input->post('rank');
			if(!empty($type_name)){
				$add['type_name'] = $type_name;
				$add['rank'] = $rank;
				$add['company_id'] =$admininfo['roleid'];
				$this->replay_type->add($add);
				redirect('d=home&c=replay_type');
			}
		}else{
			$this->load->view('home/home_replay_type_add');
		}
		
	}

	//更新
	public function update()
	{
		if(!empty($_POST)){
			$type_name = $this->input->post('type_name');
			$rank = $this->input->post('rank');
			$id = $this->input->post('id');
			if(!empty($type_name)){
				$add['type_name'] = $type_name;
				$add['rank'] = $rank;
				$config = array('id'=>$id);
				$this->replay_type->update($config,$add);
				redirect('d=home&c=replay_type');
			}else{
				exit('info error');
			}
		}else{
			$id = $this->input->get('id');
			$config = array('id'=>$id);
			$info = $this->replay_type->get_one_by_id($config);

			$data['info'] = $info;
			$this->load->view('home/home_replay_type_update',$data);

		}
	}

	public function del()
	{
		$id = $this->input->get('id');
		$config = array('id'=>$id);
		$this->replay_type->del($config);

		redirect('d=home&c=replay_type');
	}
}
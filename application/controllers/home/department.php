<?php
/*
*复盘类型
**/

class department extends Admin_Controller
{
	

	public function __construct()
	{
		parent::__construct();
		$this->load->model('department_mdl','department');
		
	}



	public function index()
	{
		$admininfo= $this->userinfo;//登陆信息
		$page = isset($_GET['page']) ? $_GET['page'] : 0;
        $page = ($page && is_numeric($page)) ? intval($page) : 1;
		$data['pagesize']=$page;
		$keyword = isset($_REQUEST['keyword']) ? $_REQUEST['keyword'] : '';
		$data['keyword'] = $keyword;
        $limit = 20;
        $offset = ($page - 1) * $limit;
        $pagination = ''; 
       
        $where=array();
		$where['where']=array('company_id'=>$admininfo['roleid']);
		if(!empty($keyword)){
            $where['likeand'] = array('dep_name'=>$keyword);
        }
		
        $count = $this->department->get_count1($where);

        $this->load->library('pagination');
        $config['base_url'] = base_url().'index.php?d=home&c=department&keyword='.$keyword;
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
		$wherelist['where']=array('company_id'=>$admininfo['roleid']);
		if(!empty($keyword)){
            $wherelist['likeand'] = array('dep_name'=>$keyword);
        }
		$list = $this->department->getList($where);
		$data['list'] = $list;
		$data['keyword'] = $keyword;


		$this->load->view('home/home_department',$data);
	}

	//新增
	public function add()
	{
		$admininfo= $this->userinfo;//登陆信息
		if(!empty($_POST)){
			$type_name = $this->input->post('type_name');
			$rank = $this->input->post('rank');
			if(!empty($type_name)){
				$add['dep_name'] = $type_name;
				$add['company_id'] = $admininfo['roleid'];
				$this->department->add($add);
				redirect('d=home&c=department');
			}
		}else{
			$this->load->view('home/home_department_add');
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
				$add['dep_name'] = $type_name;
				$config = array('id'=>$id);
				$this->department->update($config,$add);
				redirect('d=home&c=department');
			}else{
				exit('info error');
			}
		}else{
			$id = $this->input->get('id');
			$config = array('id'=>$id);
			$info = $this->department->get_one_by_id($config);

			$data['info'] = $info;
			$this->load->view('home/home_department_update',$data);

		}
	}

	public function del()
	{
		$id = $this->input->get('id');
		$config = array('id'=>$id);
		$this->department->del($config);

		redirect('d=home&c=department');
	}
	/*
	 *删除多条数据
	 */
	public function delall(){
		$ids = $_POST['ids'];
		$ids = explode('-',$ids);
		foreach($ids as $id){
			if(!empty($id)){
				$this->department->del(array('id'=>$id));
			}
		}
		return 1;
	}
}
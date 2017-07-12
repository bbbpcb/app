<?php
/*
*复盘类型
**/

class user_role extends Admin_Controller
{
	

	public function __construct()
	{
		parent::__construct();
		$this->load->model('user_role_mdl','user_role');
		$this->load->model('user_menu_mdl','user_menu');
		$this->load->model('user_right_mdl','user_right');
	}



	public function index()
	{
		$page = isset($_GET['page']) ? $_GET['page'] : 0;
        $page = ($page && is_numeric($page)) ? intval($page) : 1;
		$keyword = isset($_REQUEST['keyword']) ? $_REQUEST['keyword'] : '';
		$data['keyword'] = $keyword;
        $limit = 20;
        $offset = ($page - 1) * $limit;
        $pagination = ''; 
       
        $where=array();
		if(!empty($keyword)){
            $where['likeand'] = array('name'=>$keyword);
        }
		
        $count = $this->user_role->get_count1($where);

        $this->load->library('pagination');
        $config['base_url'] = base_url().'index.php?d=home&c=user_role&keyword='.$keyword;
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
        $wherelist['order'] = array('key'=>'id','value'=>'ASC');
		if(!empty($keyword)){
            $wherelist['likeand'] = array('name'=>$keyword);
        }
		$list = $this->user_role->getList($where);
		$data['list'] = $list;
		$data['keyword'] = $keyword;


		$this->load->view('home/home_user_role',$data);
	}

	//新增
	public function add()
	{
		if(!empty($_POST)){
			$name = $this->input->post('txt_name');
			if(!empty($name) ){
				$add['name'] = $name;
				$this->user_role->add($add);
				redirect('d=home&c=user_role');
			}
		}else{
			
			$this->load->view('home/home_user_role_add');
		}
	}
	
	//分配权限
	public function roleright(){
		if(!empty($_POST)){
			$roleId=$_POST['roleId'];
			$rolerights=$_POST['D_ids-add'];
			$this->user_right->del(array('nodeId'=>$roleId));
			if($rolerights){
				for($i=0;$i<count($rolerights);$i++){
					$add['nodeId']=$roleId;
					$add['roleId']=$rolerights[$i];
					$this->user_right->add($add);
				}
			}
			redirect('d=home&c=user_role');
		}else{
			$id=$_REQUEST['id'];
			$where['where'] =array('parentNodeId'=>0);
			$list = $this->user_menu->getList($where);
			$mune=array();
			foreach($list as $k => $v){
				$wheres['where'] =array('parentNodeId'=>$v['nodeId']);
				$lists = $this->user_menu->getList($wheres);
				$list[$k]['text']=$v['displayName'];
				$list[$k]['items']=$lists;
				
			}
			$data['mune']=$list;
			$data['id']=$id;
			
			//选中
			$rwhere['where']=array('nodeId'=>$id);
			$rolelist=$this->user_right->getList($rwhere);
			$info=array();
			foreach($rolelist as $k => $v){
				$info[$k]=$v['roleId'];
			}
			$data['info']=$info;
			$this->load->view('home/home_user_role_right',$data);
		}
	}

	//更新
	public function update()
	{
		if(!empty($_POST)){
			$id = $this->input->post('id');
			$name = $this->input->post('txt_name');

			if(!empty($name) ){
				$add['name'] = $name;
				$config = array('rid'=>$id);
				$this->user_role->update($config,$add);
				redirect('d=home&c=user_role');
			}else{
				exit('info error');
			}
		}else{
			$id = $this->input->get('id');
			$config = array('rid'=>$id);
			$info = $this->user_role->get_one_by_id($config);

			$data['info'] = $info;
			$this->load->view('home/home_user_role_update',$data);

		}
	}

	public function del()
	{
		$id = $this->input->get('id');
		$config = array('rid'=>$id);
		$this->user_role->del($config);

		redirect('d=home&c=user_role');
	}
}
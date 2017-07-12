<?php

class Advs extends Admin_Controller
{
	

	public function __construct()
	{
		parent::__construct();
		$this->load->model('advs_mdl','advs');
	}

	public function index()
	{

		$admininfo= $this->userinfo;//登陆信息
		$page = isset($_GET['page']) ? $_GET['page'] : 0;
        $page = ($page && is_numeric($page)) ? intval($page) : 1;
		$data['pagesize']=$page;
		$keyword = isset($_REQUEST['seachname']) ? $_REQUEST['seachname'] : '';
		$where = array();
		if(!empty($keyword)){            
            $where = array_merge_recursive($where,array('title'=>$keyword));
        }
        $limit = 10;
        $offset = ($page - 1) * $limit;
        $pagination = ''; 
		$wherer['likeand']=$where;
		$wherer['where']=array('company_id'=>$admininfo['roleid']);
        $count = $this->advs->get_count($wherer);
       
        $this->load->library('pagination');
        $config['base_url'] = base_url().'index.php?d=home&c=advs&seachname='.$keyword;
        $config['total_rows'] = $count;
        $config['uri_segment'] = 4;
        $config['per_page'] = $limit;
        $config['use_page_numbers'] = TRUE;
        $config['query_string_segment'] = 'page';
        $this->pagination->initialize($config);
        $data['page'] = $this->pagination->create_links();

        $list = array();
        $wherelist['page'] = true;
        $wherelist['limit'] = $limit;
        $wherelist['offset'] = $offset;
		$wherelist['likeand'] = isset($where) ?   $where : array();
		$wherelist['where']=array('company_id'=>$admininfo['roleid']);
        $list = $this->advs->getList($wherelist);
        $data['list'] = $list;
		$data['keyword'] = $keyword; 

		$this->load->view('home/home_advs',$data);
	}

	public function add()
	{
		$admininfo= $this->userinfo;//登陆信息
		if(!empty($_POST)){
			$typeid = '1';
			$title = $this->input->post('title');
			$links = $this->input->post('links');
			if(!empty($_FILES['userfile']['name'])){

	            $config['upload_path'] = './uploads/pics/';
	               
	            //$config['allowed_types'] = '*';
	            $config['allowed_types'] = '*';
				$config['max_size'] = 0;
	            $config['file_name']  =date("YmdHis");

	            $this->load->library('upload', $config);

	            if ( ! $this->upload->do_upload('userfile')){
	                    $error = array('error' => $this->upload->display_errors());	                  
	                    header("Content-type:text/html;charset=utf-8");
	                    echo '图片大小超k了';
	                    exit;
	            }else{
	                $data = array('upload_data' => $this->upload->data());
	                $picname = $data['upload_data']['orig_name']; 
					$add['img1'] = $picname;     
	            }
			} 
			$add['typeid'] = $typeid;
			$add['title'] = $title;
			$add['links'] = $links;
			$add['company_id'] =$admininfo['roleid'];	
			if(!empty($add['title'])){
				$this->advs->add($add);
				
			}
			redirect('d=home&c=advs');
		}else{
			$this->load->view('home/home_advs_add');
		}
	}

	public function update()
	{
		if(!empty($_POST)){

			$id = $this->input->post('id');
			$typeid = 1;
			$title = $this->input->post('title');
			$links = $this->input->post('links');
			if(!empty($_FILES['userfile']['name'])){

	            $config['upload_path'] = './uploads/pics/';
	               
	            //$config['allowed_types'] = '*';
	            $config['allowed_types'] = '*';
				$config['max_size'] = 0;
	            $config['file_name']  =date("YmdHis");

	            $this->load->library('upload', $config);

	            if ( ! $this->upload->do_upload('userfile')){
	                    $error = array('error' => $this->upload->display_errors());	                  
	                    header("Content-type:text/html;charset=utf-8");
	                    echo '图片大小超k了';
	                    exit;
	            }else{
	                $data = array('upload_data' => $this->upload->data());
	                $picname = $data['upload_data']['orig_name']; 
					$add['img1'] = $picname;     
	            }
			}else{
					$add['img1'] = $_POST['fileimg'];
				}

			$add['typeid'] = $typeid;
			$add['title'] = $title;
			$add['links'] = $links;
			$config = array('id'=>$id);
			$this->advs->update($config,$add);
			redirect('d=home&c=advs');

		}else{
			$id = $this->input->get('id');
			$config = array('id'=>$id);
			$info = $this->advs->get_one_by_id($config);
			$data['info'] = $info;

			$this->load->view('home/home_advs_update',$data);
		}

	}

                //delete
    public function del()
    {
        $id = $this->input->get('id');
        $where['id'] = $id;
        $this->advs->del($where);
        redirect('d=home&c=advs');
    }

		/*
	 *删除多条数据
	 */
	public function delall(){
		$ids = $_POST['ids'];
		$ids = explode('-',$ids);
		foreach($ids as $id){
			if(!empty($id)){
				$this->advs->del(array('id'=>$id));
			}
		}
		return 1;
	}
}
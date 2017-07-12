<?php

class Pics extends Admin_Controller
{
	

	public function __construct()
	{
		parent::__construct();
		$this->load->model('pics_mdl','pics');
	}

	public function index()
	{

		$admininfo= $this->userinfo;//登陆信息
		$page = isset($_GET['page']) ? $_GET['page'] : 0;
        $page = ($page && is_numeric($page)) ? intval($page) : 1;
		$data['pagesize']=$page;
        $limit = 20;
        $offset = ($page - 1) * $limit;
        $pagination = ''; 
		$where=array('company_id'=>$admininfo['roleid']);
        $count = $this->pics->get_count($where);
       
        $this->load->library('pagination');
        $config['base_url'] = base_url().'index.php?d=home&c=pics';
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
		$wherelist['where']=array('company_id'=>$admininfo['roleid']);
        $list = $this->pics->getList($wherelist);
        $data['list'] = $list;


		$this->load->view('home/home_pics',$data);
	}

	public function add()
	{
		$admininfo= $this->userinfo;//登陆信息
		if(!empty($_POST)){
			$typeid = $this->input->post('typeid');
			$nandu = $this->input->post('nandu');
			$guimo = $this->input->post('guimo');
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
					$add['picname'] = $picname;     
	            }
			}
			$add['typeid'] = $typeid;
			$add['nandu'] = $nandu;
			$add['guimo'] = $guimo;
			$add['company_id'] =$admininfo['roleid'];	
			if(!empty($add['picname'])){
				$this->pics->add($add);
				
			}
			redirect('d=home&c=pics');
		}else{
			$this->load->view('home/home_pics_add');
		}
	}

	public function update()
	{
		if(!empty($_POST)){

			$id = $this->input->post('id');
			$typeid = $this->input->post('typeid');
			$nandu = $this->input->post('nandu');
			$guimo = $this->input->post('guimo');
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
					$add['picname'] = $picname;     
	            }
			}else{
					$add['picname'] = $_POST['fileimg'];
				}

			$add['typeid'] = $typeid;
			$add['nandu'] = $nandu;
			$add['guimo'] = $guimo;
			$config = array('id'=>$id);
			$this->pics->update($config,$add);
			redirect('d=home&c=pics');
		}else{
			$id = $this->input->get('id');
			$config = array('id'=>$id);
			$info = $this->pics->get_one_by_id($config);
			$data['info'] = $info;

			$this->load->view('home/home_pics_update',$data);
		}

	}

                //delete
    public function del()
    {
        $id = $this->input->get('id');
        $where['id'] = $id;
        $this->pics->del($where);
        redirect('d=home&c=pics');
    }
	
		/*
	 *删除多条数据
	 */
	public function delall(){
		$ids = $_POST['ids'];
		$ids = explode('-',$ids);
		foreach($ids as $id){
			if(!empty($id)){
				$this->pics->del(array('id'=>$id));
			}
		}
		return 1;
	}

}
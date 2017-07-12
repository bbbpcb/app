<?php

class Task extends Admin_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('task_mdl','task');
		$this->load->model('task_type_mdl','task_type');
		$this->load->model('project_mdl','project');
	}

    //会员列表
	public function index()
	{
	    $page = isset($_GET['page']) ? $_GET['page'] : 0;
        $page = ($page && is_numeric($page)) ? intval($page) : 1;
		$data['pagesize']=$page;
        $mid = isset($_GET['mid']) ? $_GET['mid'] : 0;
        $pid = isset($_GET['pid']) ? $_GET['pid'] : 0;
		$keyword = isset($_REQUEST['keyword']) ? $_REQUEST['keyword'] : '';
		$admininfo= $this->userinfo;//登陆信息
        $data['mid'] = $mid;
        $data['pid'] = $pid;
       	$data['keyword'] = $keyword;
        $limit = 10;
        $offset = ($page - 1) * $limit;
        $pagination = ''; 
		$admininfo= $this->userinfo;//登陆信息
        $where =array();
		$w =array();
        if(!empty($mid)){
			$w=array('modid'=>$mid);
		}
		if(!empty($pid)){
			$w=array('proid'=>$pid);
		}
		$w = array_merge_recursive($w,array('company_id'=>$admininfo['roleid']));
		$where['where']=$w;
		if(!empty($keyword)){
            $where['likeand'] = array('title'=>$keyword);
        }
		
        $count = $this->task->get_count1($where);
      
        $this->load->library('pagination');
        $config['base_url'] = base_url().'index.php?d=home&c=task&keyword='.$keyword.'&pid='.$pid.'&mid='.$mid;
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
		$wl =array();
        if(!empty($pid)){
			$wl=array('t.proid'=>$pid);
		}
		if(!empty($mid)){
			$wl=array('t.modid'=>$mid);
		}
		$wl = array_merge_recursive($wl,array('t.company_id'=>$admininfo['roleid']));
		$wherelist['where']=$wl;
		if(!empty($keyword)){
            $wherelist['likeand'] = array('t.title'=>$keyword);
        }
		$wherelist = array_merge_recursive($wherelist,array('company_id'=>$admininfo['roleid']));
        $list = $this->task->getList($wherelist);
        $data['list'] = $list;


	   $this->load->view('home/home_task',$data);
	}

    //添加任务
    public function add()
    {
		$admininfo= $this->userinfo;//登陆信息
        if(!empty($_POST)){
            $data['title'] = $this->input->post('t_name');
            $data['task_type'] = $this->input->post('t_type');
            $data['scale'] = $this->input->post('t_scale');
            $data['quality'] = $this->input->post('t_quality');
            $data['difficulty'] = $this->input->post('t_difficulty');
			$data['features'] = $this->input->post('t_features');
            $data['status'] = $this->input->post('status');
            $data['intro'] = $this->input->post('t_content');
            $data['modid'] = $this->input->post('t_typemod');
            $data['proid'] = $this->input->post('t_proid');
			 $data['company_id'] = $admininfo['roleid'];
            $id = isset($_POST['id']) ? $this->input->post('id') : '0';

             /**图片上传**/
            if(!empty($_FILES['userfile']['name'])){

                $config['upload_path'] = FCPATH.'/uploads/task/';
                //echo $config[upload_path];
                //exit;
                $config['allowed_types'] = '*';
                $config['file_name']  =date("YmdHis");

                $this->load->library('upload', $config);

                if ( ! $this->upload->do_upload('userfile')){
                    $error = array('error' => $this->upload->display_errors());
                    echo json_encode($error);
                }else{
                    $dataupload = array('upload_data' => $this->upload->data());
                    $picname = $dataupload['upload_data']['orig_name'];
                    $data['icon'] = $picname;
                }
				
            }

            if($id){
                $config = array('id'=>$id);
                $this->task->update($config,$data);
            }else{
               
                $data['createtime'] = time();
                $this->task->add($data);
            }

            redirect('d=home&c=task&pid='.$data['proid']);
        }else{ 
            $mid = $this->input->get('mid');
            $pid = $this->input->get('pid');
            $data['mid'] = $mid;
            $data['pid'] = $pid;
			
			$this->load->model('mod_mdl','mod');
			$mw['where']=array('company_id'=>$admininfo['roleid']);
            $typemod = $this->mod->getList($mw);
			$data['typemod'] = $typemod;
			$wherelist['where']=array('p.company_id'=>$admininfo['roleid'],'p.typeid'=>1);
			$list = $this->project->getList($wherelist);
			$data['prolist'] = $list;
            $this->load->view('home/home_task_add',$data);
        }
    }

    /**
    *修改
    */
    public function update()
    {
		$admininfo= $this->userinfo;//登陆信息
        $id = $this->input->get('id');
        $where = array('t.id'=>$id);
        $info =  $this->task->get_one_by_id($where);
	
        $data['info'] = $info;

        $type = $this->task_type->getList();
        $data['type'] = $type;
		
		 $this->load->model('mod_mdl','mod');
		$mw['where']=array('company_id'=>$admininfo['roleid']);
       $typemod = $this->mod->getList($mw);
		$data['typemod'] = $typemod;
		
		$wherelist['where']=array('p.company_id'=>$admininfo['roleid'],'p.typeid'=>1);
			$list = $this->project->getList($wherelist);
			$data['prolist'] = $list;
		
        $this->load->view('home/home_task_update',$data);

    }

		//delete
	public function del()
    {
		$id = $this->input->get('id');
		$where['id'] = $id;
		$this->task->del($where);
		redirect('d=home&c=task');
	}
	
	/*
	 *删除多条数据
	 */
	public function delall(){
		$ids = $_POST['ids'];
		$ids = explode('-',$ids);
		foreach($ids as $id){
			if(!empty($id)){
				$this->task->del(array('id'=>$id));
			}
		}
		return 1;
	}
	
	public function get_modtype(){ 
		$admininfo= $this->userinfo;//登陆信息
		$mid = $this->input->post('mid');
		$where['where']=array('modid'=>$mid,'company_id'=>$admininfo['roleid']);
		$where['page']=false;
		$data['list'] = $this->task_type->getList($where);
		echo json_encode($data);
	}

}
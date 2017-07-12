<?php

class Conquer extends Admin_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Conquer_mdl','conquer');
        $this->load->model('Conquer_reply_mdl','conquer_reply');
	}

    //会员列表
	public function index()
	{
		$admininfo= $this->userinfo;//登陆信息
	    $page = isset($_GET['page']) ? $_GET['page'] : 0;
        $page = ($page && is_numeric($page)) ? intval($page) : 1;
		$keyword = isset($_REQUEST['keyword']) ? $_REQUEST['keyword'] : '';
		$data['pagesize']=$page;
        $limit = 10;
        $offset = ($page - 1) * $limit;
        $pagination = ''; 
		$where=array();
		if(!empty($keyword)){
            $where['likeand'] = array('title'=>$keyword,'company_id'=>$admininfo['roleid']);
        }else{
			$where['where']=array('company_id'=>$admininfo['roleid']);
		}
        $count = $this->conquer->get_count2($where);
       
        $this->load->library('pagination');
        $config['base_url'] = base_url().'index.php?d=home&c=conquer&keyword='.$keyword;
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
            $wherelist['likeand'] = array('c.title'=>$keyword,'c.company_id'=>$admininfo['roleid']);
        }else{
			$wherelist['where']=array('c.company_id'=>$admininfo['roleid']);
		}
        $list = $this->conquer->getList($wherelist);
        $data['list'] = $list;
		$data['keyword'] = $keyword;
	   $this->load->view('home/home_conquer',$data);
	}

    /**
    *
    * @员工解答
    **/

    public function reply()
    {
		$admininfo= $this->userinfo;//登陆信息
        $page = isset($_GET['page']) ? $_GET['page'] : 0;
        $page = ($page && is_numeric($page)) ? intval($page) : 1;
        $id = $this->input->get('id');

        $limit = 20;
        $offset = ($page - 1) * $limit;
        $pagination = ''; 
        $where = array('cid'=>$id,'company_id'=>$admininfo['roleid']);
        $count = $this->conquer_reply->get_count( $where);


       
        $this->load->library('pagination');
        $config['base_url'] = base_url().'index.php?d=home&c=conquer&m=reply';
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
        $wherelist['where'] = array('c.cid'=>$id,'c.company_id'=>$admininfo['roleid']);
        $list = $this->conquer_reply->getList($wherelist);
        $data['list'] = $list;
       $this->load->view('home/home_conquer_reply',$data);
    }

    /**
    *添加集体攻关
    */
    public function add()
    {
		$admininfo= $this->userinfo;//登陆信息
        if(!empty($_POST)){
            $data['title'] = $this->input->post('title');
            $data['typeid'] = $this->input->post('typeid');
  			$data['proid'] = $this->input->post('proid');
            $data['status'] = $this->input->post('status');
            $data['content'] = $this->input->post('content');
            $data['total'] = $this->input->post('total');
            $data['uid'] = $this->input->post('uid');
			$data['company_id'] =$admininfo['roleid'];
            $id = isset($_POST['id']) ? $this->input->post('id') : '0';

            /**图片上传**/
            if(!empty($_FILES['userfile']['name'])){

                $config['upload_path'] = FCPATH.'/uploads/conquer/';
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

            }else{
					$data['icon'] = 'default.jpg';
					if($id){
						$data['icon'] = $_POST['fileimg'];
					}
				}

            if($id){
                $config = array('id'=>$id);
                $this->conquer->update($config,$data);
            }else{
               
                $data['createtime'] = time();
                $data['icon'] = empty($picname) ? 'default.jpg' : $data['icon'];
                $this->conquer->add($data);
            }

            redirect('d=home&c=conquer');
        }else{ 

            $this->load->model('replay_type_mdl','type');
			$where['where'] = array('company_id'=>$admininfo['roleid']);
            $type = $this->type->getList($where);
            $data['type'] = $type;
            //项目归属
            $this->load->model('project_mdl','project');
			$wp['where'] = array('p.company_id'=>$admininfo['roleid']);
            $project = $this->project->getList($wp);
            $data['project'] = $project;
            //员工
            $this->load->model('member_mdl','member');
			$wm['where'] = array('m.company_id'=>$admininfo['roleid']);
            $ex = $this->member->getList($wm);
            $data['ex'] = $ex;

            $this->load->view('home/home_conquer_add',$data);
        }
    }

    /**
    *修改
    */
    public function update()
    {
		$admininfo= $this->userinfo;//登陆信息
        $id = $this->input->get('id');
        $where = array('c.id'=>$id);
        $info =  $this->conquer->get_one_by_where($where);
        $data['info'] = $info;

         $this->load->model('replay_type_mdl','type');
		$where['where'] = array('company_id'=>$admininfo['roleid']);
        $type = $this->type->getList($where);
		$data['type'] = $type;
		//项目归属
		$this->load->model('project_mdl','project');
		$wp['where'] = array('p.company_id'=>$admininfo['roleid']);
        $project = $this->project->getList($wp);
		$data['project'] = $project;
		//专家
		$this->load->model('member_mdl','member');
		$wm['where'] = array('m.company_id'=>$admininfo['roleid']);
       $ex = $this->member->getList($wm);
		$data['ex'] = $ex;

        $this->load->view('home/home_conquer_update',$data);

    }

		//delete
	public function del()
    {
		$id = $this->input->get('id');
		$where['id'] = $id;
		$this->conquer->del($where);
		redirect('d=home&c=conquer');
	}
	
	/*
	 *删除多条数据
	 */
	public function delall(){
		$ids = $_POST['ids'];
		$ids = explode('-',$ids);
		foreach($ids as $id){
			if(!empty($id)){
				$this->conquer->del(array('id'=>$id));
			}
		}
		return 1;
	}
	
	public function replydel()
    {
		$id = $this->input->get('id');
		$where['id'] = $id;
		$this->conquer_reply->del($where);
		redirect('d=home&c=conquer');
	}
	
	/*
	 *删除多条数据
	 */
	public function replydelall(){
		$ids = $_POST['ids'];
		$ids = explode('-',$ids);
		foreach($ids as $id){
			if(!empty($id)){
				$this->conquer_reply->del(array('id'=>$id));
			}
		}
		return 1;
	}
	
}
<?php

class Review_question extends Admin_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('review_question_mdl','review_question');
	}

    //会员列表
	public function index()
	{
	    $page = isset($_GET['page']) ? $_GET['page'] : 0;
        $page = ($page && is_numeric($page)) ? intval($page) : 1;
		$data['pagesize']=$page;
        $modid = isset($_GET['modid']) ? $_GET['modid'] : 0;
		$keyword = isset($_REQUEST['keyword']) ? $_REQUEST['keyword'] : '';
        $data['modid'] = $modid;
		$data['keyword'] = $keyword;
        $limit = 20;
        $offset = ($page - 1) * $limit;
        $pagination = ''; 
       	$admininfo= $this->userinfo;//登陆信息
        $where=array();
		if(!empty($modid)){
			$where['where']=array('modid'=>$modid,'company_id'=>$admininfo['roleid']);
		}else{
			$where['where']=array('company_id'=>$admininfo['roleid']);
		}
		if(!empty($keyword)){
            $where['likeand'] = array('m_name'=>$keyword);
        }
		
        $count = $this->review_question->get_count1($where);

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
		if(!empty($modid)){
			$wherelist['where']=array('modid'=>$modid,'company_id'=>$admininfo['roleid']);
		}else{
			$wherelist['where']=array('company_id'=>$admininfo['roleid']);
		}
		if(!empty($keyword)){
            $wherelist['likeand'] = array('m_name'=>$keyword);
        }
        $list = $this->review_question->getList($wherelist);
        $data['list'] = $list;

        //print_R($taskcount);
	   $this->load->view('home/home_review_question',$data);
	}

    public function add()
    {
		$admininfo= $this->userinfo;//登陆信息
        if(!empty($_POST)){
            $data['revtitle'] = $this->input->post('m_name');
          	$data['company_id'] =$admininfo['roleid'];
            $data['modid'] = $this->input->post('modid');
			 $data['revintro'] = $this->input->post('t_content');
			 $data['revid']=0;
            $id = isset($_POST['id']) ? $this->input->post('id') : '0';

            if($id){
                $config = array('id'=>$id);
                $this->review_question->update($config,$data);
            }else{
                           
                $this->review_question->add($data);
            }

            redirect('d=home&c=review_question&m=index&modid='.$this->input->post('modid'));
        }else{ 
			 $modid =$_GET['modid'];//模块
			 $data['modid'] = $modid;
            $this->load->view('home/home_review_question_add',$data);
        }
    }

    /**
    *修改
    */
    public function update()
    {
        $id = $this->input->get('id');
        $where = array('id'=>$id);
        $info =  $this->review_question->get_one_by_id($where);
        $data['info'] = $info;

        $this->load->view('home/home_review_question_update',$data);

    }

		//delete
	public function del()
    {
		$id = $this->input->get('id');
		$modid = $this->input->get('modid');
		$where['id'] = $id;
		$this->review_question->del($where);
		redirect('d=home&c=review_question&modid='.$modid);
	}
	
	/*
	 *删除多条数据
	 */
	public function delall(){
		$ids = $_POST['ids'];
		$ids = explode('-',$ids);
		foreach($ids as $id){
			if(!empty($id)){
				$this->review_question->del(array('id'=>$id));
			}
		}
		return 1;
	}
}
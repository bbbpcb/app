<?php


class Aboutsys extends Admin_Controller
{




	public function __construct()
	{
		parent::__construct();
		$this->load->model('aboutsys_mdl','aboutsys');
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
        $count = $this->aboutsys->get_count($where);
       
        $this->load->library('pagination');
        $config['base_url'] = base_url().'index.php?d=home&c=aboutsys';
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
        $list = $this->aboutsys->getList($wherelist);
        $data['list'] = $list;


	   $this->load->view('home/home_aboutsys',$data);
	}

    public function add()
    {
		$admininfo= $this->userinfo;//登陆信息
        if(!empty($_POST)){
            $data['title'] = $this->input->post('title');
            $data['content'] = $this->input->post('content');
            $data['rank'] = $this->input->post('rank');
			$data['company_id'] =$admininfo['roleid'];
            $id = isset($_POST['id']) ? $this->input->post('id') : '0';


            if($id){
                $config = array('id'=>$id);
                $this->aboutsys->update($config,$data);
            }else{
               
                $this->aboutsys->add($data);
            }

            redirect('d=home&c=aboutsys');
        }else{ 


            $this->load->view('home/home_aboutsys_add');
        }
    }

    /**
    *修改
    */
    public function update()
    {
        $id = $this->input->get('id');
        $where = array('id'=>$id);
        $info =  $this->aboutsys->get_one_by_id($where);
        $data['info'] = $info;

        $this->load->view('home/home_aboutsys_update',$data);

    }

                //delete
    public function del()
    {
        $id = $this->input->get('id');
        $where['id'] = $id;
        $this->aboutsys->del($where);
        redirect('d=home&c=aboutsys');
    }
	
	/*
	 *删除多条数据
	 */
	public function delall(){
		$ids = $_POST['ids'];
		$ids = explode('-',$ids);
		foreach($ids as $id){
			if(!empty($id)){
				$this->aboutsys->del(array('id'=>$id));
			}
		}
		return 1;
	}

    //修改排序
    public function rank()
    {
        $rank = $this->input->post('rank');
        $id = $this->input->post('id');
        $len = count($id);
        for($i=0;$i<$len;$i++){
            $config = array('id'=>$id[$i]);
            $data['rank'] = $rank[$i];
            $this->aboutsys->update($config,$data);
        }

        redirect('d=home&c=aboutsys');
    }







}
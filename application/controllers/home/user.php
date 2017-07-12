<?php
/*
*复盘类型
**/

class user extends Admin_Controller
{
	

	public function __construct()
	{
		parent::__construct();
		$this->load->model('user_mdl','user');
		$this->load->model('user_role_mdl','user_role');
		$this->load->model('gongshi_mdl','gongshi');
		$this->load->model('star_mdl','star');
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
            $where['likeand'] = array('username'=>$keyword);
        }
		
        $count = $this->user->get_count1($where);

        $this->load->library('pagination');
        $config['base_url'] = base_url().'index.php?d=home&c=user&keyword='.$keyword;
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
            $wherelist['likeand'] = array('username'=>$keyword);
        }
		$list = $this->user->getList($where);
		$data['list'] = $list;
		$data['keyword'] = $keyword;


		$this->load->view('home/home_user',$data);
	}

	//新增
	public function add()
	{
		if(!empty($_POST)){
			$name = $this->input->post('txt_name');
			$email = $this->input->post('txt_email');
			$pwd = $this->input->post('txt_pwd');
			$date = $this->input->post('txt_date');
			$rileid = $this->input->post('txt_role');
			$domain = $this->input->post('txt_domain');
			$usernum = $this->input->post('txt_usernum');
			
			if(!empty($name) && !empty($pwd)){
				$add['username'] = $name;
				$add['email'] = $email;
				$add['pwd'] = md5($pwd);
				$add['username'] = $name;
				$add['roleid'] = $rileid;
				$add['createtime'] = time();
				$add['end_time'] = strtotime($date);
				$add['usernum'] = $usernum;
				$add['userdomain'] = $domain;
				$userid=$this->user->add_user($add);
				if($userid){
					//添加星
					for($i=1;$i<=4;$i++){
						$star['type']=$i;
						$star['company_id']= $rileid;
						$this->star->add($star);
					}
					//添加公式
					$gsadd['tags']='renqi';
					$gsadd['company_id']=$rileid;
					$this->gongshi->add($gsadd);
					//添加公式
					$gsadd2['tags']='jisuan';
					$gsadd2['company_id']=$rileid;
					$this->gongshi->add($gsadd2);
				}
				redirect('d=home&c=user');
			}
		}else{
			$list = $this->user_role->getList(array());
			$data['rolelist'] = $list;
		
			$this->load->view('home/home_user_add',$data);
		}
	}

	//更新
	public function update()
	{
		if(!empty($_POST)){
			$id = $this->input->post('id');
			$name = $this->input->post('txt_name');
			$email = $this->input->post('txt_email');
			$pwd = $this->input->post('txt_pwd');
			$date = $this->input->post('txt_date');
			$rileid = $this->input->post('txt_role');
			$domain = $this->input->post('txt_domain');
			$usernum = $this->input->post('txt_usernum');
			if(!empty($name) ){
				$add['username'] = $name;
				$add['email'] = $email;
				if(!empty($pwd)){
					$add['pwd'] = md5($pwd);
				}
				$add['username'] = $name;
				$add['roleid'] = $rileid;
				$add['createtime'] = time();
				$add['end_time'] = strtotime($date);
				$add['usernum'] = $usernum;
				$add['userdomain'] = $domain;
				$config = array('id'=>$id);
				$this->user->update($config,$add);
				
				redirect('d=home&c=user');
			}else{
				exit('info error');
			}
		}else{
			$id = $this->input->get('id');
			$config = array('id'=>$id);
			$info = $this->user->get_one_by_id($config);

			$data['info'] = $info;
			$list = $this->user_role->getList(array());
			$data['rolelist'] = $list;
			$this->load->view('home/home_user_update',$data);

		}
	}

	public function del()
	{
		
		$id = $this->input->get('id');
		$config = array('id'=>$id);
		$info = $this->user->get_one_by_id($config);
		$this->user->del($config);
		$this->star->del(array('company_id'=>$info['roleid']));
		$this->gongshi->del(array('company_id'=>$info['roleid']));
		
		redirect('d=home&c=user');
	}
}
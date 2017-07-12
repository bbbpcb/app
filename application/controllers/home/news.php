<?php

class News extends Admin_Controller{

	public function __construct(){
		parent::__construct();
		$this->load->model('news_mdl','news');
	}


	public function index(){

	
		$page = isset($_GET['page']) ? $_GET['page'] : 0;
        $page = ($page && is_numeric($page)) ? intval($page) : 1;

        $tid = isset($_GET['tid']) ? $_GET['tid'] : '0';
        $data['tid'] = $tid;
        $where['where'] = array();
        if(!empty($tid)){
        	 $where['where'] = array('tid'=>$tid);
        }
       

        $limit = 10;
        $offset = ($page - 1) * $limit;
        $pagination = '';

        $count = $this->news->get_count($where['where']);

        $this->load->library('pagination');
        $config['base_url'] = base_url().'index.php?d=home&c=news&tid='.$tid;
        $config['total_rows'] = $count;
        //设置url上第几段用于传递分页器的偏移量
        $config ['uri_segment'] = 4;
        $config['per_page'] = $limit;
        $config['use_page_numbers'] = TRUE;
        $config['query_string_segment'] = 'page';
        $this->pagination->initialize($config);
        $data['page'] = $this->pagination->create_links();

        $list = array();
        $where['page'] = true;
        $where['limit'] = $limit;
        $where['offset'] = $offset;

        $list = $this->news->getList($where);
        $data['list'] = $list;
       
		$this->load->view('home/home_news',$data);

	}

	public function add(){

		if(!empty($_POST)){
			$title = $this->input->post('title');
			$content = $this->input->post('newsContent');
			$lang = $this->input->post('rank');
			$tid = $this->input->post('tid');

	        $dataarr['title'] = $title;
	        $dataarr['content'] = $content;
	        $dataarr['rank'] = $lang;
	        $dataarr['tid'] = $tid;
	        $dataarr['createtime']  = time();

	        $this->news->add($dataarr);
	        redirect('d=home&c=news&tid='.$tid);

		}else{
			$tid = isset($_GET['tid']) ? $_GET['tid'] : '0';
            $data['tid'] = $tid;

            $this->load->model('newstype_mdl','newstype');
        	$types = $this->newstype->getList();
        	$data['types'] = $types;

			$this->load->view('home/home_news_add',$data);	
		}
	}

	//update
	public function update(){
		if(!empty($_POST)){
			
			$title = $this->input->post('title');			
			$content = $_POST['newsContent'];
			$id = $this->input->post('id');
			$tid = $this->input->post('tid');
			$rank = $this->input->post('rank');

			if(!empty($title) && !empty($content) && !empty($id)){
			
	                           
	            $dataarr['title'] = $title;
	            $dataarr['content'] = $content;
	            $dataarr['rank'] = $rank;
	            $dataarr['tid'] = $tid;
	            $where['id'] = $id;
	            $this->news->update($where,$dataarr);
	            redirect('d=home&c=news&tid='.$tid);
	        }

		}else{

			$id = $this->input->get('id');

			$config['id'] = $id;
			$info = $this->news->get_new_by_id($config);
			$data['info'] = $info;

			$this->load->model('newstype_mdl','newstype');
        	$types = $this->newstype->getList();
        	$data['types'] = $types;

			$this->load->view('home/home_news_edit',$data);
		}

	}
	//delete
	public function del(){
		$id = $this->input->get('id');
		$where['id'] = $id;
		$this->news->del($where);
		redirect('d=home&c=news');
	}
}
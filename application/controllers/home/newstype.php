<?php

class Newstype extends Admin_Controller
{

	public function __constrcut()
	{
		parent::__construct();

		
	}


	public function index()
	{
		$this->load->model('newstype_mdl','newstype');

        $list = $this->newstype->getList();
        $data['list'] = $list;
              
        $this->load->view('home/home_newstype',$data);
	}

	public function add(){

		if(!empty($_POST)){
			$typename = $this->input->post('typename');
			$rank = $this->input->post('rank');
			
			if(!empty($typename)){
	            $dataarr['typename'] = $typename;
	            $dataarr['rank'] = $rank;
			}

			$this->load->model('newstype_mdl','newstype');
            $this->newstype->add($dataarr);
            redirect('d=home&c=newstype');

		}else{
		
			$this->load->view('home/home_newstype_add');
		}
	}

	public function edit(){
		$this->load->model('newstype_mdl','newstype');
		if(!empty($_POST)){
			
			$typename = $this->input->post('typename');
			$rank = $_POST['rank'];
			$id = $this->input->post('id');

	        $dataarr['typename'] = $typename;
	        $dataarr['rank'] = $rank;

	        $where['id'] = $id;
	        $this->newstype->update($where,$dataarr);
	        redirect('d=home&c=newstype');
	    

		}else{

			$id = $this->input->get('id');

			$config['id'] = $id;
			$info = $this->newstype->get_new_by_id($config);
			$data['info'] = $info;

			$this->load->view('home/home_newstype_edit',$data);
		}

	}

			//delete
	public function del(){
		$this->load->model('newstype_mdl','newstype');
		$id = $this->input->get('id');
		$pos = $this->input->get('pos');
		$where['id'] = $id;
		$this->newstype->del($where);
		redirect('d=home&c=newstype');
	}
}
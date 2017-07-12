<?php

class Lanmu extends Admin_Controller
{

	public function __constrcut()
	{
		parent::__construct();

		
	}


	public function index()
	{
		$this->load->model('lanmu_mdl','lanmu');
		$pos = $this->input->get('pos');
		$data['pos'] = $pos;
		$where = array('where'=>array('pos'=>$pos));
        $list = $this->lanmu->getList($where);
        $data['list'] = $list;
              
        $this->load->view('home/home_lanmu',$data);
	}

	public function add(){

		if(!empty($_POST)){
			$lanmu = $this->input->post('lanmu');
			$rank = $this->input->post('rank');
			$pos = $this->input->post('pos');
			if(!empty($lanmu)){
	            $dataarr['lanmu_name'] = $lanmu;
	            $dataarr['pos'] = $pos;
	            $dataarr['rank'] = $rank;
			}

			$this->load->model('lanmu_mdl','lanmu');
            $this->lanmu->add($dataarr);
            redirect('d=home&c=lanmu&pos='.$pos);

		}else{
			$pos = $this->input->get('pos');
			$data['pos'] = $pos;
			$this->load->view('home/home_lanmu_add',$data);
		}
	}

	public function edit(){
		$this->load->model('lanmu_mdl','lanmu');
		if(!empty($_POST)){
			
			$lanmu = $this->input->post('lanmu');
			$content = $this->input->post('newsContent');
			$rank = $_POST['rank'];
			$id = $this->input->post('id');
			$pos = $this->input->post('pos');

	           //================= upload ====================
	        $dataarr['lanmu_name'] = $lanmu;
	        $dataarr['content'] = $content;
	        $dataarr['rank'] = $rank;

	        $where['id'] = $id;
	        $this->lanmu->update($where,$dataarr);
	        redirect('d=home&c=lanmu&pos='.$pos);
	    

		}else{

			$id = $this->input->get('id');

			$config['id'] = $id;
			$info = $this->lanmu->get_new_by_id($config);
			$data['info'] = $info;

			$this->load->view('home/home_lanmu_edit',$data);
		}

	}

		//delete
	public function del(){
		$this->load->model('lanmu_mdl','lanmu');
		$id = $this->input->get('id');
		$pos = $this->input->get('pos');
		$where['id'] = $id;
		$this->lanmu->del($where);
		redirect('d=home&c=lanmu&pos='.$pos);
	}
}
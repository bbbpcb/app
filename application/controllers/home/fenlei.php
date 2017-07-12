<?php


class Fenlei extends Admin_Controller{



	public function __construct(){

		parent::__construct();
		$this->load->model('fenlei_mdl','fenlei');

	}


	public function index(){
		
		$page = isset($_GET['page']) ? $_GET['page'] : 0;
        $page = ($page && is_numeric($page)) ? intval($page) : 1;

        $lang = isset($_GET['lang']) ? $_GET['lang'] : 'cn';
        $data['lang'] = $lang;
        $where['where'] = array('lang'=>$lang);

        $limit = 20;
        $offset = ($page - 1) * $limit;
        $pagination = '';

        $count = $this->fenlei->get_count($where['where']);

        $this->load->library('pagination');
        $config['base_url'] = base_url().'index.php?d=home&c=fenlei';
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
        $list = $this->fenlei->getList($where);
        $data['list'] = $list;


        $this->load->view('home/home_fenlei',$data);
	}


	public function add(){

		if(!empty($_POST)){
			$name = $this->input->post('name');
			$rank = $this->input->post('rank');
             $lang = $this->input->post('lang');
            if(!empty($name)){
                $data['name'] = $name;
                $data['rank'] = $rank;
                $data['lang'] = $lang;
                $this->fenlei->add($data);
                redirect('d=home&c=fenlei');   
            }

            //================= upload ====================

		}else{
            $lang = isset($_GET['lang']) ? $_GET['lang'] : 'cn';
            $data['lang'] = $lang;
			$this->load->view('home/home_fenlei_add',$data);
		}
	}

    //更新
    public function update(){

        if(!empty($_POST)){
            $name = $this->input->post('name');
            $rank = $this->input->post('rank');
            $id = $this->input->post('id');

            $dataarr['name'] = $name;
            $dataarr['rank'] = $rank;           
          if(!empty($name) && !empty($id)){
                $where = array('id' => $id);
                $this->fenlei->update($where,$dataarr);
                redirect('d=home&c=fenlei');
          }

        }else{

            $id = $this->input->get('id');
            $lang = isset($_GET['lang']) ? $_GET['lang'] : 'cn';
            $data['lang'] = $lang;

            $where = array(
                'id' => $id,
                
                );

            $info = $this->fenlei->get_new_by_id($where);
            $data['info'] = $info;
            $this->load->view('home/home_fenlei_update',$data);
        }
            
    }





	public function del(){
        $id = intval($_GET['id']);
        $config['id'] = $id;
        $this->fenlei->del($config);
        redirect('d=home&c=fenlei');

    }


}
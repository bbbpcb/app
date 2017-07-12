<?php


class Stores extends Admin_Controller{



	public function __construct(){

		parent::__construct();
		$this->load->model('stores_mdl','stores');

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

        $count = $this->stores->get_count($where['where']);

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
        $list = $this->stores->getList($where);
        $data['list'] = $list;


        $this->load->view('home/home_stores',$data);
	}


	public function add(){

		if(!empty($_POST)){
			$info = $this->input->post('info');
			$rank = $this->input->post('rank');
            $lang = $this->input->post('lang');
            if(!empty($info)){
                $data['info'] = $info;
                $data['rank'] = $rank;
                $data['lang'] = $lang;
                $this->stores->add($data);
                redirect('d=home&c=stores&lang='.$lang);   
            }

            //================= upload ====================

		}else{
            $lang = isset($_GET['lang']) ? $_GET['lang'] : 'cn';
            $data['lang'] = $lang;
			$this->load->view('home/home_stores_add',$data);
		}
	}

    //更新
    public function update(){

        if(!empty($_POST)){
            $info = $this->input->post('info');
            $rank = $this->input->post('rank');
            $id = $this->input->post('id');
            $lang = $this->input->post('lang');
            
            $dataarr['info'] = $info;
            $dataarr['rank'] = $rank;

          if(!empty($info) && !empty($id)){
                $where = array('id' => $id);
                $this->stores->update($where,$dataarr);
                redirect('d=home&c=stores&lang='.$lang);
          }

        }else{

            $id = $this->input->get('id');
            $where = array(
                'id' => $id
                );
            $info = $this->stores->get_new_by_id($where);
            $data['info'] = $info;
            $this->load->view('home/home_stores_update',$data);
        }
            
    }





	public function del(){
        $id = intval($_GET['id']);
        $config['id'] = $id;
        $this->stores->del($config);
        redirect('d=home&c=stores');

    }


}
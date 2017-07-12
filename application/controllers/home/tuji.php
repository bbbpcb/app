<?php

class Tuji extends Admin_Controller{

	public function __construct(){
		parent::__construct();
		$this->load->model('tuji_mdl','tuji');
	}

	public function index(){

		$page = isset($_GET['page']) ? $_GET['page'] : 0;
		$id = $this->input->get('id');

        $page = ($page && is_numeric($page)) ? intval($page) : 1;
        $limit = 60;
        $offset = ($page - 1) * $limit;
        $pagination = '';
        $countwhere = array(
        		'aid' => $id,
        	);
        $count = $this->tuji->get_count($countwhere);
        
        $this->load->library('pagination');
        $config['base_url'] = base_url().'index.php?d=home&c=tuji';
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
        $where['where'] = array('aid'=>$id);
        $list = $this->tuji->getList($where);
        $data['list'] = $list;
        $data['id'] = $id;

        $this->load->view('home/home_tuji',$data);
        
	}

	public function add(){
		$id = $this->input->get('id');
		if(!empty($_POST)){
			$title = $this->input->post('title');
			$content = $this->input->post('content');
			$rank = $this->input->post('rank');
			$aid = $this->input->post('aid');

			//================= upload ====================
                /**图片上传**/
            if(!empty($_FILES['userfile']['name'])){

                $config['upload_path'] = FCPATH.'/uploads/tuji/';
                $config['allowed_types'] = 'jpg|jpeg|png|gif';
                $config['file_name']  =date("YmdHis");

                $this->load->library('upload', $config);

                if ( ! $this->upload->do_upload('userfile')){
                    $error = array('error' => $this->upload->display_errors());
                    echo json_encode($error);
                }else{
                    $data = array('upload_data' => $this->upload->data());
                    $picname = $data['upload_data']['orig_name'];
                    $dataarr['pic'] = $picname;
                    $dataarr['title'] = $title;
                    $dataarr['rank'] = $rank;
                    $dataarr['content'] = $content;
                    $dataarr['createtime'] = time();
                    $dataarr['aid'] = $aid;

                   $this->tuji->add($dataarr);
                    redirect('d=home&c=tuji&id='.$aid);

                }

            }

            echo $picname;
            //================= upload ====================

		}else{
			$data['aid'] = $id;
			$this->load->view('home/home_tuji_add',$data);
		}

	}

	public function del(){
        $id = intval($_GET['id']);
        $aid = $this->input->get('aid');
        $config['id'] = $id;
        $this->tuji->del($config);
        redirect('d=home&c=tuji&id='.$aid);

    }
}
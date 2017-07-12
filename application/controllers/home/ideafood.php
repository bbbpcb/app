<?php


class Ideafood extends Admin_Controller{



	public function __construct(){

		parent::__construct();
		$this->load->model('ideafood_mdl','food');
        $this->load->model('foodtuji_mdl','tuji');
	}


	public function index(){

		$page = isset($_GET['page']) ? $_GET['page'] : 0;
        $page = ($page && is_numeric($page)) ? intval($page) : 1;
        $limit = 20;
        $offset = ($page - 1) * $limit;
        $pagination = '';

        $count = $this->food->get_count();

        $this->load->library('pagination');
        $config['base_url'] = base_url().'index.php?d=home&c=ideafood';
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
        $list = $this->food->getList($where);
        $data['list'] = $list;


        $this->load->view('home/home_ideafood',$data);
	}


	public function add(){

		if(!empty($_POST)){
			$title = $this->input->post('title');
			$rank = $this->input->post('rank');

			//================= upload ====================
                /**图片上传**/
            if(!empty($_FILES['userfile']['name'])){

                $config['upload_path'] = FCPATH.'/uploads/food/';
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
                    $dataarr['createtime'] = time();

                   $this->food->add($dataarr);
                   redirect('d=home&c=ideafood');

                }

            }

            echo $picname;
            //================= upload ====================

		}else{
			$this->load->view('home/home_ideafood_add');
		}
	}

    //更新
    public function update(){

        if(!empty($_POST)){
            $title = $this->input->post('title');
            $rank = $this->input->post('rank');
            $id = $this->input->post('id');

            $dataarr['title'] = $title;
            $dataarr['rank'] = $rank;           
            //================= upload ====================
                /**图片上传**/
            if(!empty($_FILES['userfile']['name'])){

                $config['upload_path'] = FCPATH.'/uploads/food/';
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

                }

            }

            $where = array('id' => $id);
            $this->food->update($where,$dataarr);
            redirect('d=home&c=ideafood');
        }else{

            $id = $this->input->get('id');
            $where = array(
                'id' => $id
                );
            $food = $this->food->get_new_by_id($where);
            $data['food'] = $food;
            $this->load->view('home/home_ideafood_update',$data);
        }
            
    }

    //图集
    public function tuji(){


        $page = isset($_GET['page']) ? $_GET['page'] : 0;
        $id = $this->input->get('id');

        $page = ($page && is_numeric($page)) ? intval($page) : 1;
        $limit = 20;
        $offset = ($page - 1) * $limit;
        $pagination = '';
        $countwhere = array(
                'aid' => $id,
            );
        $count = $this->tuji->get_count($countwhere);
        
        $this->load->library('pagination');
        $config['base_url'] = base_url().'index.php?d=home&c=ideafood&m=tuji';
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

        $this->load->view('home/home_ideafood_tuji',$data);
        
    }

    //添加图集

    public function addtuji(){
        $id = $this->input->get('id');
        if(!empty($_POST)){
            $title = $this->input->post('title');
            $rank = $this->input->post('rank');
            $aid = $this->input->post('aid');
            //================= upload ====================
                /**图片上传**/
            if(!empty($_FILES['userfile']['name'])){

                $config['upload_path'] = FCPATH.'/uploads/foodtuji/';
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
                    $dataarr['createtime'] = time();
                    $dataarr['aid'] = $aid;

                   $this->tuji->add($dataarr);
                   redirect('d=home&c=ideafood&m=tuji&id='.$aid);

                }

            }

            echo $picname;
        }else{
            $data['id'] = $id;
            $this->load->view('home/home_ideafood_tuji_add',$data);
        }
    }

	public function del(){
        $id = intval($_GET['id']);
        $config['id'] = $id;
        $this->food->del($config);

        $this->load->model('foodtuji_mdl','tuji');
        $where = array('aid' => $id);
        $this->tuji->del($where);
        redirect('d=home&c=ideafood');

    }

    public function deltuji(){
        $id = intval($_GET['id']);
        $aid = $this->input->get('aid');
        $config['id'] = $id;
        $this->tuji->del($config);
        redirect('d=home&c=ideafood&m=tuji&id='.$aid);

    }
}
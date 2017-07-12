<?php


class Anli extends Admin_Controller{



	public function __construct(){

		parent::__construct();
		$this->load->model('anli_mdl','anli');
	}


	public function index(){

		$page = isset($_GET['page']) ? $_GET['page'] : 0;
        $page = ($page && is_numeric($page)) ? intval($page) : 1;
        $limit = 20;
        $offset = ($page - 1) * $limit;
        $pagination = '';

        $count = $this->anli->get_count();

        $this->load->library('pagination');
        $config['base_url'] = base_url().'index.php?d=home&c=anli';
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
        $list = $this->anli->getList($where);
        $data['list'] = $list;


        $this->load->view('home/home_anli',$data);
	}


    //添加
	public function add(){

		if(!empty($_POST)){
			$title = $this->input->post('title');
			$content = $this->input->post('content');
			$rank = $this->input->post('rank');

			//================= upload ====================
                /**图片上传**/
            if(!empty($_FILES['userfile']['name'])){

                $config['upload_path'] = FCPATH.'/uploads/anli/';
                $config['allowed_types'] = 'jpg|jpeg|png|gif';
                $config['file_name']  =date("YmdHis");

                $this->load->library('upload', $config);

                if ( ! $this->upload->do_upload('userfile')){
                    $error = array('error' => $this->upload->display_errors());
                    echo json_encode($error);
                }else{
                    $datapic = array('upload_data' => $this->upload->data());
                    $picname = $datapic['upload_data']['orig_name'];
                    $dataarr['pic'] = $picname;
                    $dataarr['title'] = $title;
                    $dataarr['rank'] = $rank;
                    $dataarr['content'] = $content;
                    $dataarr['createtime'] = time();

                   $this->anli->add($dataarr);
                    redirect('d=home&c=anli');

                }

            }

            echo $picname;
            //================= upload ====================

		}else{
			$this->load->view('home/home_anli_add');
		}
	}

    //更新
    public function update(){

        if(!empty($_POST)){
            $title = $this->input->post('title');
            $content = $this->input->post('content');
            $rank = $this->input->post('rank');
            $id = $this->input->post('id');

            $dataarr['title'] = $title;
            $dataarr['rank'] = $rank;
            $dataarr['content'] = $content;
           
            //================= upload ====================
                /**图片上传**/
            if(!empty($_FILES['userfile']['name'])){

                $config['upload_path'] = FCPATH.'/uploads/anli/';
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
            $this->anli->update($where,$dataarr);
            redirect('d=home&c=anli');
        }else{

            $id = $this->input->get('id');
            $where = array(
                'id' => $id
                );
            $anli = $this->anli->get_new_by_id($where);
            $data['anli'] = $anli;
            $this->load->view('home/home_anli_update',$data);
        }
            
    }
    

	public function del(){
        $id = intval($_GET['id']);
        $config['id'] = $id;
        $this->anli->del($config);

        $this->load->model('tuji_mdl','tuji');
        $where = array('aid' => $id);
        $this->tuji->del($where);
        
        redirect('d=home&c=anli');

    }
}
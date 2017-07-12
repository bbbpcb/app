<?php

class Banner extends Admin_Controller{


	public function __construct(){
		parent::__construct();
		$this->load->model('banner_mdl','banner');

	}

	public function index(){

		$page = isset($_GET['page']) ? $_GET['page'] : 0;
        $page = ($page && is_numeric($page)) ? intval($page) : 1;
        $act =isset($_GET['act']) ? $_GET['act'] : '' ;


        $limit = 20;
        $offset = ($page - 1) * $limit;
        $pagination = '';

        $count = $this->banner->get_count();

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
        $list = $this->banner->getList($where);
        $data['list'] = $list;

        if($act == 'html'){
            $string = $this->output->get_output();
            echo $string;

        }
       
        $this->load->view('home/home_banner',$data);

	}

	public function add(){

		if(!empty($_POST)){
			$weizhi = $this->input->post('url');
            $rank = $this->input->post('rank');

			//================= upload ====================
                /**图片上传**/
            if(!empty($_FILES['userfile']['name'])){

                $config['upload_path'] = FCPATH.'/uploads/banner/';
                //echo $config[upload_path];
                //exit;
                $config['allowed_types'] = '*';
                $config['file_name']  =date("YmdHis");

                $this->load->library('upload', $config);

                if ( ! $this->upload->do_upload('userfile')){
                    $error = array('error' => $this->upload->display_errors());
                    echo json_encode($error);
                }else{
                    $data = array('upload_data' => $this->upload->data());
                    $picname = $data['upload_data']['orig_name'];
                    $dataarr['pic'] = $picname;
                    $dataarr['url'] = $weizhi;
                    $dataarr['rank'] = $rank;
                    $dataarr['createtime'] = time();

                    $this->banner->add($dataarr);
                    redirect('d=home&c=banner');

                }

            }

            echo $picname;
            //================= upload ====================
		}else{

			$this->load->view('home/home_banner_add');
		}
	}

    public function html(){

        $banner = $this->banner->getList(array());
        $data['banner'] = $banner;
        $out = $this->load->view('index',$data,true); 
        
        $dir = WEBDIR.'/';
        $filename = 'index2.html';
        $this->makehtml($dir.$filename,$out);
    }

    public function makehtml($dir,$data){
        $fp = fopen($dir,'w+');
        fwrite($fp,$data);
        fclose($fp);
    }
	public function del(){
        $id = intval($_GET['id']);
        $config['id'] = $id;
        $this->banner->del($config);
        redirect('d=home&c=banner');

    }
}
<?php

class Products extends Admin_Controller
{

	public function __constrcut()
	{
		parent::__construct();

		
	}


	public function index()
	{
		$types = array(
			'0'=>'未知',
			'1'=>'类房地产产品 ',
			'2'=>'金融类产品',
			'3'=>'文化传媒类产品',
			'4'=>'其他'
			);
		$status = array(
			'0'=>'未知',
			'1'=>'即将发售',
			'2'=>'正在募集',
			'3'=>'募集完毕',
			);
		$data['types'] = $types;
		$data['status'] = $status;
		
		$this->load->model('products_mdl','products');
		$page = isset($_GET['page']) ? $_GET['page'] : 0;
        $page = ($page && is_numeric($page)) ? intval($page) : 1;

        $limit = 10;
        $offset = ($page - 1) * $limit;
        $pagination = '';

        $count = $this->products->get_count();

        $this->load->library('pagination');
        $config['base_url'] = base_url().'index.php?d=home&c=products';
        $config['total_rows'] = $count;
        //设置url上第几段用于传递分页器的偏移量
        $config ['uri_segment'] = 4;
        $config['per_page'] = $limit;
        $config['use_page_numbers'] = TRUE;
        $config['query_string_segment'] = 'page';
        $config['next_tag_open'] = '<span class="next_btn">';//“下一页”链接的打开标签。
        $config['next_tag_close'] = '</span>';//“下一页”链接的关闭标签
        $config['next_link'] = '下一页';//你希望在分页中显示“下一页”链接的名字。

        $config['prev_tag_open'] = '<span class="prev_btn">';//“上一页”链接的打开标签。
        $config['prev_tag_close'] = '</span>';//“上一页”链接的关闭标签。
        $config['prev_link'] = '上一页';//你希望在分页中显示“上一页”链接的名字。
        $config['cur_tag_open'] = '<a class="on">'; // 当前页开始样式   
        $config['cur_tag_close'] = '</a>';  
         
        $this->pagination->initialize($config);
        $data['page'] = $this->pagination->create_links();

        $list = array();
        $where['page'] = true;
        $where['limit'] = $limit;
        $where['offset'] = $offset;

        $list = $this->products->getList($where);
        $data['list'] = $list;
       
		$this->load->view('home/home_products',$data);
	}

	public function add(){

		if(!empty($_POST)){
			$productname = $this->input->post('productname');
			$productname2 = $this->input->post('productname2');
			$info = $this->input->post('info');
			$publictime = $this->input->post('publictime');
			$menkan = $this->input->post('menkan');
			$qixian = $this->input->post('qixian');
			$shouyi = $this->input->post('shouyi');
			$createtime = time();
			$tel = $this->input->post('tel');
			$tjshijian = $this->input->post('tjshijian');
			$status = $this->input->post('status');
			$status = $this->input->post('status');
			$tuijian = $this->input->post('tuijian');
			$types = $this->input->post('types');
			$index = $this->input->post('index');
			$this->load->model('products_mdl','products');

			if(!empty($productname)){

				$data['productname'] = $productname;
				$data['productname2'] = $productname2;
				$data['info'] = $info;
				$data['publictime'] = $publictime;
				$data['menkan'] = $menkan;
				$data['qixian'] = $qixian;
				$data['shouyi'] = $shouyi;
				$data['createtime'] = $createtime;
				$data['tel'] = $tel;
				$data['tjshijian'] = $tjshijian;
				$data['status'] = $status;
				$data['types'] = $types;
				$data['tuijian'] = $tuijian;
				$data['index'] = $index;

					                /**图片上传**/
	            if(!empty($_FILES['userfile']['name'])){

	                $config['upload_path'] = FCPATH.'/uploads/product/';
	                $config['allowed_types'] = '*';
	                $config['file_name']  =date("YmdHis");

	                $this->load->library('upload', $config);

	                if ( ! $this->upload->do_upload('userfile')){
	                    $error = array('error' => $this->upload->display_errors());
	                    echo json_encode($error);
	                }else{
	                    $datapic = array('upload_data' => $this->upload->data());
	                    $picname = $datapic['upload_data']['orig_name'];
	                    $data['pic'] = $picname;               
	                }

	            }

				$this->products->add($data);
			}

            redirect('d=home&c=products');

		}else{

			$this->load->view('home/home_products_add');
		}
	}

	public function edit(){
		$this->load->model('products_mdl','products');

		if(!empty($_POST)){
			
			$productname = $this->input->post('productname');
			$productname2 = $this->input->post('productname2');
			$info = $this->input->post('info');
			$publictime = $this->input->post('publictime');
			$menkan = $this->input->post('menkan');
			$qixian = $this->input->post('qixian');
			$shouyi = $this->input->post('shouyi');
			$types = $this->input->post('types');
			$createtime = time();
			$tel = $this->input->post('tel');
			$tjshijian = $this->input->post('tjshijian');
			$status = $this->input->post('status');
			$tuijian = $this->input->post('tuijian');
			$index = $this->input->post('index');
			$this->load->model('products_mdl','products');

			$id = $this->input->post('id');

			if(!empty($productname)){

				$data['productname'] = $productname;
				$data['productname2'] = $productname2;
				$data['info'] = $info;
				$data['publictime'] = $publictime;
				$data['menkan'] = $menkan;
				$data['qixian'] = $qixian;
				$data['shouyi'] = $shouyi;
				$data['createtime'] = $createtime;
				$data['tel'] = $tel;
				$data['tjshijian'] = $tjshijian;
				$data['status'] = $status;
				$data['types'] = $types;
				$data['tuijian'] = $tuijian;
				$data['index'] = $index;
				$where['id'] = $id;
									                /**图片上传**/
	            if(!empty($_FILES['userfile']['name'])){

	                $config['upload_path'] = FCPATH.'/uploads/product/';
	                $config['allowed_types'] = '*';
	                $config['file_name']  =date("YmdHis");

	                $this->load->library('upload', $config);

	                if ( ! $this->upload->do_upload('userfile')){
	                    $error = array('error' => $this->upload->display_errors());
	                    echo json_encode($error);
	                }else{
	                    $datapic = array('upload_data' => $this->upload->data());
	                    $picname = $datapic['upload_data']['orig_name'];
	                    $data['pic'] = $picname;               
	                }

	            }
	        	$this->products->update($where,$data);

	        	redirect('d=home&c=products');
			}


	    

		}else{

			$id = $this->input->get('id');

			$config['id'] = $id;
			$info = $this->products->get_new_by_id($config);
			$data['info'] = $info;
			//print_r($info);
			$this->load->view('home/home_products_edit',$data);
		}

	}

		//delete
	public function del(){
		$this->load->model('products_mdl','products');
		$id = $this->input->get('id');
		
		$where['id'] = $id;
		$this->products->del($where);
		redirect('d=home&c=products');
	}
}
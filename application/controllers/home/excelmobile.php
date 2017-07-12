<?php
/*
*复盘类型
**/

class excelmobile extends Admin_Controller
{
	

	public function __construct()
	{
		parent::__construct();
		$this->load->model('excel_mobile_mdl','excel_mobile');
		
	}



	public function index()
	{
		$admininfo= $this->userinfo;//登陆信息
		$page = isset($_GET['page']) ? $_GET['page'] : 0;
        $page = ($page && is_numeric($page)) ? intval($page) : 1;
		$data['pagesize']=$page;
		$keyword = isset($_REQUEST['keyword']) ? $_REQUEST['keyword'] : '';
		$data['keyword'] = $keyword;
        $limit = 20;
        $offset = ($page - 1) * $limit;
        $pagination = ''; 
       
        $where=array();
		$where['where']=array('company_id'=>$admininfo['roleid']);
		if(!empty($keyword)){
            $where['likeand'] = array('mobile'=>$keyword);
        }
		
        $count = $this->excel_mobile->get_count1($where);

        $this->load->library('pagination');
        $config['base_url'] = base_url().'index.php?d=home&c=department&keyword='.$keyword;
        $config['total_rows'] = $count;
        //设置url上第几段用于传递分页器的偏移量
        $config ['uri_segment'] = 4;
        $config['per_page'] = $limit;
        $config['use_page_numbers'] = TRUE;
        $config['query_string_segment'] = 'page';
        $this->pagination->initialize($config);
        $data['page'] = $this->pagination->create_links();

        $list = array();
        $wherelist['page'] = true;
        $wherelist['limit'] = $limit;
        $wherelist['offset'] = $offset;
        $wherelist['order'] = array('key'=>'rank','value'=>'ASC');
		$wherelist['where']=array('company_id'=>$admininfo['roleid']);
		if(!empty($keyword)){
            $wherelist['likeand'] = array('dep_name'=>$keyword);
        }
		$list = $this->excel_mobile->getList($where);
		$data['list'] = $list;
		$data['keyword'] = $keyword;


		$this->load->view('home/home_excel_mobile',$data);
	}

	//新增
	public function add()
	{
		$admininfo= $this->userinfo;//登陆信息
		if(!empty($_POST)){
			$mobile = $this->input->post('txt_mobile');
			if(!empty($mobile)){
				$add['mobile'] = $mobile;
				$add['company_id'] = $admininfo['roleid'];
				$this->excel_mobile->add($add);
				redirect('d=home&c=excelmobile');
			}
		}else{
			$this->load->view('home/home_excel_mobile_add');
		}
		
	}

	//更新
	public function update()
	{
		if(!empty($_POST)){
			$mobile = $this->input->post('txt_mobile');
			$id = $this->input->post('id');
			if(!empty($mobile)){
				$add['mobile'] = $mobile;
				$config = array('id'=>$id);
				$this->excel_mobile->update($config,$add);
				redirect('d=home&c=excelmobile');
			}else{
				exit('info error');
			}
		}else{
			$id = $this->input->get('id');
			$config = array('id'=>$id);
			$info = $this->excel_mobile->get_one_by_id($config);

			$data['info'] = $info;
			$this->load->view('home/home_excel_mobile_update',$data);

		}
	}

	public function del()
	{
		$id = $this->input->get('id');
		$config = array('id'=>$id);
		$this->excel_mobile->del($config);

		redirect('d=home&c=excelmobile');
	}
	/*
	 *删除多条数据
	 */
	public function delall(){
		$ids = $_POST['ids'];
		$ids = explode('-',$ids);
		foreach($ids as $id){
			if(!empty($id)){
				$this->excel_mobile->del(array('id'=>$id));
			}
		}
		return 1;
	}
	
	//新增
	public function exceladd()
	{
		$admininfo= $this->userinfo;//登陆信息
		if(!empty($_POST)){
			 if (! empty ( $_FILES ['file_stu'] ['name'] )){
				$tmp_file = $_FILES ['file_stu'] ['tmp_name'];
				$file_types = explode ( ".", $_FILES ['file_stu'] ['name'] );
				$file_type = $file_types [count ( $file_types ) - 1];
				 /*判别是不是.xls文件，判别是不是excel文件*/
				 if (strtolower ( $file_type ) != "xls"){
					  exit('不是Excel文件，重新上传' );
				 }
				/*设置上传路径*/
				 $savePath = './uploads/excel/';
				/*以时间来命名上传的文件*/
				 $str = date ( 'Ymdhis' ); 
				 $file_name = $str . "." . $file_type;
				 /*是否上传成功*/
				 if (! copy ( $tmp_file, $savePath . $file_name )) {
					  exit( '上传失败' );
				 }
				$this->load->library('PHPExcel');
				$inputFileName='./uploads/excel/'. $file_name;
				$filePath='./uploads/excel/'. $file_name;
				$PHPExcel = new PHPExcel();
 				$admininfo= $this->userinfo;//登陆信息
				/**默认用excel2007读取excel，若格式不对，则用之前的版本进行读取*/
				$PHPReader = new PHPExcel_Reader_Excel2007();
				if (!$PHPReader->canRead($filePath)) {
					$PHPReader = new PHPExcel_Reader_Excel5();
					if (!$PHPReader->canRead($filePath)) {
						echo 'no Excel';
						return;
					}
				}
				$PHPExcel = $PHPReader->load($filePath);
				$currentSheet = $PHPExcel->getSheet(0); /* * 读取excel文件中的第一个工作表 */
				$allColumn = $currentSheet->getHighestColumn();/**取得最大的列号*/
				$allRow = $currentSheet->getHighestRow(); /* * 取得一共有多少行 */
				PHPExcel_Cell::columnIndexFromString(); //字母列转换为数字列 如:AA变为27
				for ($currentRow = 2; $currentRow <= $allRow; $currentRow = $currentRow + 1) {
					$pair_name = $currentSheet->getCellByColumnAndRow(0, $currentRow)->getValue();
					$add['mobile'] = $pair_name;
					$add['company_id'] = $admininfo['roleid'];
					$this->excel_mobile->add($add);
				}
			}
			redirect('d=home&c=excelmobile');
		}else{
			$this->load->view('home/home_excel_mobile_exceladd');
		}
		
	}
}
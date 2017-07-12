<?php

class projecttotal extends Admin_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('project_total_mdl','project_total');
	}

    //会员列表
	public function index()
	{
	    $page = isset($_GET['page']) ? $_GET['page'] : 0;
        $page = ($page && is_numeric($page)) ? intval($page) : 1;
        $typeid = isset($_REQUEST['typeid']) ? intval($_REQUEST['typeid']) : 0;
		$keyword = isset($_REQUEST['keyword']) ? $_REQUEST['keyword'] : '';
		$data['pagesize'] = $page;
        $limit = 10;
        $offset = ($page - 1) * $limit;
        $pagination = ''; 
		$where=array();
		$admininfo= $this->userinfo;//登陆信息
		$where['where']=array('company_id'=>$admininfo['roleid']);
		if(!empty($keyword)){
            $where['likeand'] = array('proname'=>$keyword);
        }
		
        $count = $this->project_total->get_count1($where);

		$this->load->library('pagination');
        $config['base_url'] = base_url().'index.php?d=home&c=projecttotal&typeid='.$typeid.'&keyword='.$keyword;
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

		$wherelist['where']=array('company_id'=>$admininfo['roleid']);
		if(!empty($keyword)){
            $wherelist['likeand'] = array('proname'=>$keyword);
        }

        $list = $this->project_total->getList($wherelist);
        $data['list'] = $list;
		$data['typeid'] = $typeid;
		$data['keyword'] = $keyword;
	   $this->load->view('home/home_project_total',$data);
	}

	public function del()
	{
		$id = $this->input->get('id');
		$config = array('id'=>$id);
		$this->project_total->del($config);

		redirect('d=home&c=projecttotal');
	}
	/*
	 *删除多条数据
	 */
	public function delall(){
		$ids = $_POST['ids'];
		$ids = explode('-',$ids);
		foreach($ids as $id){
			if(!empty($id)){
				$this->project_total->del(array('id'=>$id));
			}
		}
		return 1;
	}
	
		/**
     * [导出Excle]
     * @return 
     */
    public function daochu(){
		$this->load->library('PHPExcel');
		$keyword = isset($_GET['keyword']) ? $_GET['keyword'] : ''; 

 		$where = array();
		$admininfo= $this->userinfo;//登陆信息
		//======================================================= 
		$wherelist['where']=array('company_id'=>$admininfo['roleid']);
		if(!empty($keyword)){
            $wherelist['likeand'] = array('proname'=>$keyword);
        }
        $list = $this->project_total->getList($wherelist);
		
		$ty = $_GET['ty'];
        if (empty($ty)) {
        	if(empty($list)){
				header("Content-type:text/html;charset=utf-8");
				exit(json_encode(array('success'=> 0, 'msg'=>'当前数据为空，不支持打印输出！')));
			}
        }

		//新建 

		$resultPHPExcel = new PHPExcel(); 
		//设置参数 

		//设值 
		$resultPHPExcel->getActiveSheet()->setCellValue('A1', 'ID'); 
		$resultPHPExcel->getActiveSheet()->setCellValue('B1', '项目名称'); 
		$resultPHPExcel->getActiveSheet()->setCellValue('C1', '负责人'); 
		$resultPHPExcel->getActiveSheet()->setCellValue('D1', '负责人类型'); 
		$resultPHPExcel->getActiveSheet()->setCellValue('E1', '模块名称'); 
		$resultPHPExcel->getActiveSheet()->setCellValue('F1', '任务名称'); 
		$resultPHPExcel->getActiveSheet()->setCellValue('G1', '规模（前）'); 
		$resultPHPExcel->getActiveSheet()->setCellValue('H1', '难度（前）'); 
		$resultPHPExcel->getActiveSheet()->setCellValue('I1', '质量（前）'); 
		$resultPHPExcel->getActiveSheet()->setCellValue('J1', '特性（前）'); 
		$resultPHPExcel->getActiveSheet()->setCellValue('K1', '任务分数（前）'); 
		$resultPHPExcel->getActiveSheet()->setCellValue('L1', '领取人姓名（前）'); 
		$resultPHPExcel->getActiveSheet()->setCellValue('M1', '领取分（前）'); 
		$resultPHPExcel->getActiveSheet()->setCellValue('N1', '规模（后）'); 
		$resultPHPExcel->getActiveSheet()->setCellValue('O1', '难度（后）');
		$resultPHPExcel->getActiveSheet()->setCellValue('P1', '质量（后）'); 
		$resultPHPExcel->getActiveSheet()->setCellValue('Q1', '特性（后）'); 
		$resultPHPExcel->getActiveSheet()->setCellValue('R1', '任务分数（后）'); 
		$resultPHPExcel->getActiveSheet()->setCellValue('S1', '领取人姓名（后）'); 
		$resultPHPExcel->getActiveSheet()->setCellValue('T1', '领取人分数（后）'); 
		$i = 2; 

		foreach($list as $k => $v){ 
			$resultPHPExcel->getActiveSheet()->setCellValue('A' . $i, $v['id']); 
			$resultPHPExcel->getActiveSheet()->setCellValue('B' . $i, $v['proname']);
			$resultPHPExcel->getActiveSheet()->setCellValue('C' . $i, $v['realname']); 
			$resultPHPExcel->getActiveSheet()->setCellValue('D' . $i, $v['rolename']);
			$resultPHPExcel->getActiveSheet()->setCellValue('E' . $i, $v['modtitle']);
			$resultPHPExcel->getActiveSheet()->setCellValue('F' . $i, ($v['taskname']));
			$resultPHPExcel->getActiveSheet()->setCellValue('G' . $i, $v['scale']);
			$resultPHPExcel->getActiveSheet()->setCellValue('H' . $i, $v['difficulty']);
			$resultPHPExcel->getActiveSheet()->setCellValue('I' . $i, $v['quality']);
			$resultPHPExcel->getActiveSheet()->setCellValue('J' . $i, $v['features']);
			$resultPHPExcel->getActiveSheet()->setCellValue('K' . $i, $v['taskgrand']);
			$resultPHPExcel->getActiveSheet()->setCellValue('L' . $i, $v['lingname']);
			$resultPHPExcel->getActiveSheet()->setCellValue('M' . $i, $v['linggrand']);
			$resultPHPExcel->getActiveSheet()->setCellValue('N' . $i, $v['gscale']);
			$resultPHPExcel->getActiveSheet()->setCellValue('O' . $i, $v['gdifficulty']);
			$resultPHPExcel->getActiveSheet()->setCellValue('P' . $i, $v['gquality']);
			$resultPHPExcel->getActiveSheet()->setCellValue('Q' . $i, $v['gfeatures']);
			$resultPHPExcel->getActiveSheet()->setCellValue('R' . $i, $v['gtaskgrand']);
			$resultPHPExcel->getActiveSheet()->setCellValue('S' . $i, $v['glingname']);
			$resultPHPExcel->getActiveSheet()->setCellValue('T' . $i, $v['glinggrand']);
			$i ++; 
		}
		$date = date('Y-m-d',time()); 
		$outputFileName = 'projecttotal_'.$date.'.xls'; 
		$outputFileName = iconv("utf-8", "gb2312", $outputFileName);

		//$resultPHPExcel->getActiveSheet()->getColumnDimension('B1')->setAutoSize(true);
//		$resultPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(50);
//
//		$resultPHPExcel->getActiveSheet()->getColumnDimension('L1')->setAutoSize(true);
//		$resultPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(20);
//
//		$resultPHPExcel->getActiveSheet()->getColumnDimension('M1')->setAutoSize(true);
//		$resultPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(20);
//		$resultPHPExcel->getActiveSheet()->getColumnDimension('S1')->setAutoSize(true);
//		$resultPHPExcel->getActiveSheet()->getColumnDimension('S')->setWidth(20);
//
//		$resultPHPExcel->getActiveSheet()->getColumnDimension('T1')->setAutoSize(true);
//		$resultPHPExcel->getActiveSheet()->getColumnDimension('T')->setWidth(20);
		$xlsWriter = new PHPExcel_Writer_Excel5($resultPHPExcel); 

		//ob_start(); ob_flush(); 
		header("Content-Type: application/force-download"); 

		header("Content-Type: application/octet-stream"); 

		header("Content-Type: application/download"); 

		header('Content-Disposition:inline;filename="'.$outputFileName.'"'); 

		header("Content-Transfer-Encoding: binary"); 

		header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); 

		header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); 

		header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 

		header("Pragma: no-cache"); 

		$xlsWriter->save( "php://output" );
	}
}
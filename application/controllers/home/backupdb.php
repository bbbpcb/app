<?php

/**
*@dec 备份数据库
*/

class Backupdb extends Admin_Controller
{
	


	public function __construct()
	{
		parent::__construct();
	}


	public function index()
	{
		$tables = $this->db->list_tables();

		$data['list'] = $tables;
		$this->load->view('home/home_backupdb',$data);
	}

	public function bak()
	{
		// 加载数据库工具类
		$this->load->dbutil();

		// 备份整个数据库并将其赋值给一个变量
		$backup =& $this->dbutil->backup(); 

		// 加载文件辅助函数并将文件写入你的服务器
		//$this->load->helper('file');
		//write_file('/path/to/mybackup.gz', $backup); 

		// 加载下载辅助函数并将文件发送到你的桌面
		$this->load->helper('download');
		force_download('mybackup-'.date("Y-m-d-H:i:s").'.gz', $backup);
	}


}
<?php
/**
*@DEC 模型相关接口
*
**/


class Mod extends Api_Controller
{
	
		public function __construct()
		{
			parent::__construct();
			$this->load->model('mod_mdl','mod');
		}

		/**模型列表**/
		public function index()
		{
			$data = $this->requestData();
			$company_id = $data['data']['company_id'];//所属管理员
			
			$where['order'] = array('key'=>'rank','value'=>'ASC');
			$where['where']=array('m.company_id'=>$company_id);
			$list = $this->mod->getList($where);
            $repjson = array(			  	
	       		'errcode'=>0,
			 	'errmsg'=>'ok' , 
	        	'data'=>$list, //当前请求的数据列表
        	);
		    $data=array('list'=>$list);
			 if($_POST){
				 $this->responseData($repjson);
				}else{
				$this->load->view('api/ajax/mod',$data);	
					}
			

		}

}
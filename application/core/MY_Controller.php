<?php

class Api_Controller extends CI_Controller
{
	public function __construct()
	{   
		parent::__construct();
		$this->load->library('session');
	}


	//取得前端post过来的数据
    public function requestData()
    {
		//$data = file_get_contents('php://input');
       // $data = $_GET['data'];
   		//$jsonObject = json_decode($data,true);
		
		$data =$_REQUEST;
		$da = array('data'=>$data);
   		
        //$fp = fopen('log.txt','a+');
       // fwrite($fp,urldecode($data).'\r\n\r\n\r\n');
        //fclose($fp);
		//if(!empty($_GET['company_id'])){
		//	$jsonObject['data']['company_id'] = $_GET['company_id'];//公司id
		//}
   	    return $da;
		
    }
	
	 public function userinfo(){
		 
		    $member = $this->session->userdata('member'); 
			 
			 if($member){
                      return $member;
				 }else{
	                  return false;
				 }
		 
		 }

    //统一返回

    public function responseData($data)
    {
    	echo json_encode($data);
        exit;
    }
	
	public function alert($msg,$href){
	$str ='<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />';
	$str .= '<script>alert("'.$msg.'");location.href="'.base_url().$href.'";</script>';
	echo $str; 
 
	 
	 
	
	}

}
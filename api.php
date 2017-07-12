<?php

class Api extends Base_controller
{
	



	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
        header("Content-type:text/html;charset=utf-8");
        $remote_server = $_POST['url'];
		$post_string = $_POST['data'];
		$json = $this->request_by_curl($remote_server, $post_string);
        echo $json;
        echo '<p>';
        print_r(json_decode($json,true));
	}



    public function test()
    {

    	$this->load->view('test');
    	/**注册****/
    	$arr = array('name'=>'register',
    		'data'=>array(
    			'username'=>'admin',
    			'passwd'=>'123456',
    			'realname'=>'admin',
    			'mobile'=>'13800138000',
    			'roleid'=>'1',
    			));
    	/**注册****/

    	/**集体攻关****/
    	$arr = array('name'=>'conquer',
    		'data'=>array(
    			'title'=>'admin',
    			'uid'=>'123456',
    			'typeid'=>'admin',
    			'content'=>'13800138000',
    			'icon'=>'1',
    			'total' =>20,
    			));
    	/**集体攻关****/
       


    	//echo json_encode($arr);


    }


    // $post_string = "app=request&version=beta";
    function request_by_curl($remote_server, $post_string)
	{
	    $ch = curl_init();
	    curl_setopt($ch, CURLOPT_URL, $remote_server);
	    curl_setopt($ch, CURLOPT_POSTFIELDS, $post_string);
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	    curl_setopt($ch, CURLOPT_USERAGENT, "Jimmy's CURL Example beta");
	    $data = curl_exec($ch);
	    curl_close($ch);
	    return $data;
	} 
}
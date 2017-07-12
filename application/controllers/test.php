<?php

class Test extends Api_Controller
{
	

	public function __construct()
	{
		parent::__construct();
	}


	public function index()
	{
		$this->load->view('test');
    /**注册**/
    /*
    	$arr = array('tag'=>'register',
    		'data'=>array(
                'realname'=>'李明2',
                'company'=>'古梅',
                'depid'=>1,
                'roleid'=>1,
                'mobile'=>'13800138000',
    			'passwd'=>'123456',
                'authorcode'=>'1234',
 
    			)
    		);
    */
    /**注册**/

    /** 登录**/
        $arr = array('tag'=>'login',
            'data'=>array(

                'mobile'=>'13800138000',
                'passwd'=>'123456',

 
                )
            );
    /** 登录**/

    /**获取个人信息**/
        $arr = array(
            'tag'=>'userinfo',
            'data'=>array(
                'mid'=>13,
                'token'=>'123456',
                )
            );
    /**获取个人信息**/

        /**更新个人信息**/
        $arr = array(
            'tag'=>'updateuserinfo',
            'data'=>array(
                'token'=>'123123',           
                'mid'=>13,
                
                'realname'=>'alang',
                'gender'=>1,
                'depid'=>1,
                'email'=>'test@163.com',
                'position'=>'总裁',
                'company'=>'古梅',
                'intro'=>'intro'
                )
            );
    /**更新个人信息**/

        /**修改密码**/
        $arr = array(
            'tag'=>'changepwd',
            'data'=>array(
                'token'=>'123123',           
                'mid'=>13,
                'passwd'=>'123456',
                )
            );
    /**修改密码**/

        /**获取系统说明**/
        $arr = array(
            'tag'=>'aboutsys',
            'data'=>array(
                'token'=>'123123',           
                'mid'=>13,
                
                )
            );
    /**获取系统说明**/

            /**提交意见反馈**/
        $arr = array(
            'tag'=>'feedback',
            'data'=>array(
                'token'=>'123123',           
                'mid'=>13,
                'content'=>'content'
                
                )
            );
    /**提交意见反馈**/

        /**关于我们**/
        $arr = array(
            'tag'=>'aboutus',
            'data'=>array(
                'token'=>'123123',           
                'mid'=>13,
               
                )
            );
    /**关于我们**/

    /**创建项目**/
    /*
    @param string tag 接口名称
@param int mid 用户id
@param string token  token
@param string title  项目名称
@param int scale 规模
@param int difficulty 难度
@param int quality质量
@param int features  特性
@param int headid 负责人id
*/

        $arr = array(
            'tag'=>'createproject',
            'data'=>array(
                'token'=>'123123',           
                'mid'=>13,
                'title'=>'个人创建项目',
                'scale'=>3,
                'difficulty'=>4,
                'quality'=>3,
                'features'=>5,
                'headid'=>21,
                'typeid'=>1             
                )
            );
    /**创建项目**/

    /**模块列表**/
        $arr = array(
            'tag'=>'mod',
            'data'=>array(
                'token'=>'123123',           
                'mid'=>13,
                )
            );
    /**模块列表**/

        /**创建任务**/
        $arr = array(
            'tag'=>'createtask',
            'data'=>array(
                'token'=>'123123',           
                'mid'=>13,
                'title'=>'我的任务',
                'intro'=>'这是我创建的任务',
                'scale'=>3,
                'difficulty'=>4,
                'quality'=>3,
                'features'=>5,
                'modid'=>1,
                'proid'=>22
                )
            );
    /**模块列表**/

    /**项目列表**/
            $arr = array(
            'tag'=>'projectlist',
            'data'=>array(
                'token'=>'123123',           
                'mid'=>13,
                'limit'=>10,
                'offset'=>0
                )
            );
    /**项目列表**/


    /**项目详情**/
            $arr = array(
            'tag'=>'projectdetail',
            'data'=>array(
                'token'=>'123123',           
                'mid'=>13,
                'proid'=>22
                )
            );
    /**项目详情**/

    	echo json_encode($arr);
	}
	
}
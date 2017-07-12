<?php
/**
 * Created by JetBrains PhpStorm.
 * User: apple
 * Date: 14-3-16
 * Time: 下午1:40
 * To change this template use File | Settings | File Templates.
 */

class Login extends CI_Controller
{



    public function __construct()
    {
        parent::__construct();
        $this->load->library('Auth','auth');
        $this->load->library('Authcode','authcode');
       // ;
        if($this->auth->hasLogin()){

        }
    }

    public function index()
    {
        if(!empty($_POST)){
            $username = $this->input->post('username');
            $pwd = $this->input->post('password');
           // $verify = $this->input->post('verify');
            if(empty($username) || empty($pwd)){
                exit('login error info empty');
            }

            /*
            if(!$this->authcode->check($verify)){
                exit('authcode error');
            }
            */
            $this->load->model('user_mdl','user');
            $user = array();
            $user = $this->user->get_user_by_username($username);
			
            if(empty($user)){
                exit('no user');
            }
            if($user['pwd'] != md5($pwd)){
                exit('password error');
            }
			if($user['roleid'] !='1'){
				if(date('Y-m-d',$user['end_time'])<date('Y-m-d',time())){
					exit('Sorry, your authority has expired.');
				}
			}
            $this->session->set_userdata('token',$user);
           
            redirect('d=home&c=index');
            //处理登陆
        }else{

            $this->load->view('home/home_login');
        }
    }

    public function getauthcode()
    {
        echo  $this->authcode->show();

    }

    public function logout()
    {
        $this->session->unset_userdata('WX_CMS');
        redirect('d=home&c=login');
    }
}
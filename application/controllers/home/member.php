<?php

class Member extends Admin_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('member_mdl','member');
        $this->load->model('member_ex_mdl','member_ex');
		$this->load->model('user_mdl','user');
		$this->load->model('excel_mobile_mdl','excel_mobile');
	}

    //会员列表
	public function index()
	{
	    $page = isset($_GET['page']) ? $_GET['page'] : 0;
        $page = ($page && is_numeric($page)) ? intval($page) : 1;
		$data['pagesize']=$page;
        $roleid = isset($_REQUEST['typeid']) ? intval($_REQUEST['typeid']) : 0;
       	$keyword = isset($_REQUEST['keyword']) ? $_REQUEST['keyword'] : '';
        $limit = 20;
        $offset = ($page - 1) * $limit;
        $pagination = ''; 
		$admininfo= $this->userinfo;//登陆信息
        $where = array();
        if(!empty($roleid)){
            $where['where'] = array('roleid'=>$roleid,'company_id'=>$admininfo['roleid']);
            $wherelist['where'] = array('m.roleid'=>$roleid,'d.company_id'=>$admininfo['roleid']);
        }
		if(!empty($keyword)){
            $where['likeand'] = array('realname'=>$keyword);
			 $wherelist['likeand'] = array('m.realname'=>$keyword);
        }

        $count = $this->member->get_count1($where);
       
        $this->load->library('pagination');
        $config['base_url'] = base_url().'index.php?d=home&c=member&m=index&typeid='.$roleid.'&keyword='.$keyword;
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
        $list = $this->member->getList($wherelist);
        $data['list'] = $list;
		$data['keyword'] = $keyword; 
		$data['roleid'] = $roleid; 

	   $this->load->view('home/home_member',$data);
	}

    //对应专家
    public function ex()
    {
		$admininfo= $this->userinfo;//登陆信息
        $id = $this->input->get('id');

        $config['where'] = array('mex.mid'=>$id,'status'=>1,'mex.company_id'=>$admininfo['roleid']);
        $list = $this->member_ex->getList($config);

        $data['list'] = $list;

        $this->load->view('home/home_member_ex',$data);
    }


    //添加
    public function add()
    {
		$admininfo= $this->userinfo;//登陆信息
        if(!empty($_POST)){
			$userinfo = $this->user->get_one_by_id(array('id'=>$admininfo['id']));
			$count = $this->member->get_count1( array('company_id'=>$admininfo['roleid']));//会员人数
			if($count>$userinfo['usernum']){
					 exit('抱歉，您的会员数量已满，请联系管理员增加');
			}
            $username = $this->input->post('username');
            $realname = $this->input->post('realname');
            $passwd = $this->input->post('passwd');
            $mobile = $this->input->post('mobile');
            $depid = $this->input->post('depid');
            $profession = $this->input->post('profession');
            $industry = $this->input->post('industry');
            $content = $this->input->post('content');
            $enabled = $this->input->post('enabled');
            $roleid = $this->input->post('roleid');
            $company = $this->input->post('company');
            $intro = $this->input->post('intro');
			$email = $this->input->post('email');
			$sex = $this->input->post('sex');
			$zhiwei = $this->input->post('zhiwei');
			$typeid = $this->input->post('typeid');
            $id = isset($_POST['id']) ? $this->input->post('id') : '0';
			if(!$id){
				$excel_mobile=$this->excel_mobile->get_one_by_id(array('company_id'=>$admininfo['roleid'],'mobile'=>$mobile));
				if(!$excel_mobile){
					exit('抱歉，你无权注册，请联系管理员增加');
				}
			}
            if(!empty($mobile)){
                $data['username'] = $username;
                $data['realname'] = $realname;
                $data['mobile'] = $mobile;
				$data['roleid'] = $roleid;
                $data['depid'] = $depid;
                $data['profession'] = $profession;
                $data['industry'] = $industry;
                $data['intro'] = $intro;
                $data['enabled'] = $enabled;
                $data['company'] = $company;
				$data['email'] = $email;
				$data['sex'] = $sex;
				$data['zhiwei'] = $zhiwei;
				$data['company_id'] = $admininfo['roleid'];
                /**图片上传**/
                if(!empty($_FILES['userfile']['name'])){
                    $config['upload_path'] = FCPATH.'uploads/member/header/';
                   
                    $config['allowed_types'] = '*';
                    $config['file_name']  =date("YmdHis");
                    $this->load->library('upload', $config);
                    if ( ! $this->upload->do_upload('userfile')){
                        $error = array('error' => $this->upload->display_errors());
                        echo json_encode($error);
                    }else{
                        $dataupload = array('upload_data' => $this->upload->data());
                        $picname = $dataupload['upload_data']['orig_name'];
                        $data['headerurl'] = $picname;
                    }
                }else{
					$data['headerurl'] = 'default.jpg';
					if($id){
						$data['headerurl'] = $_POST['fileimg'];
					}
				}
                if($id){
                    $config = array('id'=>$id);
                    if(!empty($passwd)){
                        $data['passwd'] = md5($passwd);
                    }
                    $this->member->update($config,$data);
                }else{
                    if(!empty($passwd)){
						
                        $data['passwd'] = md5($passwd);
                        $data['createtime'] = time();
                        if(!$this->checkMobile($mobile)){
                            exit('手机号已经存在');
                        }
					
                        $this->member->add($data);
                        $id = $this->member->insert_id();
                    }else{
                         exit('密码不能为空');
                    }                
                }

                //重新添加对应专家
                $exid = $this->input->post('exid');
				if($exid){
					$len = count($exid);
					if($len > 0){
						$delconfig = array('mid'=>$id,'company_id'=>$admininfo['roleid']);
						$this->member_ex->del($delconfig);
						for($i=0;$i<$len;$i++){
							$add['mid'] = $id;
							$add['exid'] = $exid[$i];
							$add['company_id'] = $admininfo['roleid'];
							$this->member_ex->add($add);
						}
					}
				}
				if($id){
                	redirect('d=home&c=member&typeid='.$typeid);
				}else{
					redirect('d=home&c=member&typeid='.$roleid);
				}
            }

        }else{ 
            $this->load->model('department_mdl','dep');
			$wheredep['where'] = array('company_id'=>$admininfo['roleid']);
            $dep = $this->dep->getList($wheredep);
            $data['dep'] = $dep;
             //专家列表
            //$this->load->model('expert_mdl','expert');
            $where['where'] = array('m.roleid'=>2,'m.company_id'=>$admininfo['roleid']);
            $experts = $this->member->getList($where);
			
            $data['experts'] = $experts;
			
			$this->load->model('jobs_mdl','jobs');
			$wheredep['where'] = array('company_id'=>$admininfo['roleid']);
            $joblist = $this->jobs->getList($wheredep);
            $data['jobs'] = $joblist;

            $this->load->view('home/home_member_add',$data);
        }
    }

    /**
    *修改
    */
    public function update()
    {
		$admininfo= $this->userinfo;//登陆信息
        $id = $this->input->get('id');
        $where = array('id'=>$id);
        $info =  $this->member->get_one_by_id($where);
        $data['info'] = $info;

        $this->load->model('department_mdl','dep');
		$wheredep['where'] = array('company_id'=>$admininfo['roleid']);
        $dep = $this->dep->getList($wheredep);
        $data['dep'] = $dep;

        //专家列表
        $exwhere['where'] = array('m.roleid'=>2,'m.company_id'=>$admininfo['roleid']);
        $experts = $this->member->getList($exwhere);
        $data['experts'] = $experts;

        //用户所属专家      
        $exconfig['where'] = array('mex.mid'=>$id,'mex.company_id'=>$admininfo['roleid']);
        $ex = $this->member_ex->getList($exconfig);
        $exid = array();
        foreach($ex as $k => $v){
            $exid[] = $v['exid'];
        }
       // print_r($exid);

        $data['exid'] = $exid;
		$this->load->model('jobs_mdl','jobs');
			$wheredep['where'] = array('company_id'=>$admininfo['roleid']);
            $joblist = $this->jobs->getList($wheredep);
            $data['jobs'] = $joblist;
		
		
		
        $this->load->view('home/home_member_update',$data);

    }

    //删除会员对应专家
    public function del_ex()
    {
		$admininfo= $this->userinfo;//登陆信息
        $id = $this->input->get('id');
        $mid = $this->input->get('mid');
        $this->load->model('member_ex_mdl','member_ex');
        $config = array('id'=>$id,'mid'=>$mid,'company_id'=>$admininfo['roleid']);
        $this->member_ex->del($config);
        redirect('d=home&c=member&m=ex&id='.$mid);
    }

		//delete
	public function del()
    {
		$id = $this->input->get('id');
		
		$wherem = array('id'=>$id);
        $info =  $this->member->get_one_by_id($wherem);
		
		$where['id'] = $id;
		$this->member->del($where);
		redirect('d=home&c=member&typeid='.$info['roleid']);
	}
	
	/*
	 *删除多条数据
	 */
	public function delall(){
		$ids = $_POST['ids'];
		$ids = explode('-',$ids);
		foreach($ids as $id){
			if(!empty($id)){
				$this->member->del(array('id'=>$id));
			}
		}
		return 1;
	}

        //检查用户名
    private function checkMobile($mobile)
    {
        
        $config = array('mobile'=>$mobile); 
        $info = $this->member->get_one_by_id($config);
        
        if(!empty($info)){
            return false;
        }

        return true;
    }
}
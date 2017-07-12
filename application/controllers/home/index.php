<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 13-11-29
 * Time: 上午10:46
 */

class Index extends Admin_Controller
{


    public function __construct()
    {
        parent::__construct();
		$this->load->model('user_mdl','user');
		$this->load->model('user_menu_mdl','user_menu');
		$this->load->model('user_right_mdl','user_right');
		$this->load->model('member_mdl','member');
    }


    public function index()
    {
        $data['userinfo'] = $this->userinfo;
		$admininfo= $this->userinfo;
		$data['membernum']=0;
		$data['userdatestatus']=0;
		if($admininfo){
			$user=$this->user->get_one_by_id(array('id'=>$admininfo['id']));
			$where['where'] =array('parentNodeId'=>0);
			$list = $this->user_menu->getList($where);
			$mune=array();
			foreach($list as $k => $v){
				$wheres['where'] =array('parentNodeId'=>$v['nodeId']);
				$lists = $this->user_menu->getList($wheres);
				$list[$k]['text']=$v['displayName'];
				unset($list[$k]['displayName']);
				unset($list[$k]['nodeId']);
				unset($list[$k]['module_name']);
				unset($list[$k]['action_name']);
				unset($list[$k]['DisplayOrder']);
				unset($list[$k]['parentNodeId']);
				unset($list[$k]['paramVal']);
				foreach($lists as $k1 => $v1){
					$lists[$k1]['id']=$v1['nodeId'];
					$lists[$k1]['text']=$v1['displayName'];
					if($v1['paramVal'] ==0){
						$lists[$k1]['href']='index.php?d='.$v1['module_name'].'&c='.$v1['action_name'].'';
					}else{
						$lists[$k1]['href']='index.php?d='.$v1['module_name'].'&c='.$v1['action_name'].'&typeid='.$v1['paramVal'];
					}
					unset($lists[$k1]['displayName']);
					unset($lists[$k1]['nodeId']);
					unset($lists[$k1]['module_name']);
					unset($lists[$k1]['action_name']);
					unset($lists[$k1]['DisplayOrder']);
					unset($lists[$k1]['parentNodeId']);
					unset($lists[$k1]['paramVal']);
					//查询所属的权限
					$roleinfo1=$this->user_right->get_one_by_id(array('nodeId'=>$user['roleid'],'roleId'=>$v1['nodeId']));
					if(!$roleinfo1){
						unset($lists[$k1]);
					}
					
				}
				$list[$k]['items']=$lists;
				//查询所属的权限
				$roleinfo=$this->user_right->get_one_by_id(array('nodeId'=>$user['roleid'],'roleId'=>$v['nodeId']));
				if(!$roleinfo){
					unset($list[$k]);
				}
				
				$count = $this->member->get_count1( array('company_id'=>$admininfo['roleid']));//会员人数
				if($count>=$user['usernum']){
					$data['membernum']=1;
				}
				
				if($user['roleid'] !='1'){
					if(date('Y-m-d',$user['end_time'])<=date('Y-m-d',strtotime("+5 day"))){
						$data['userdatestatus']=1;
						$data['end_time']=date('Y-m-d',$user['end_time']);
					}
				}
			}
			$mune['id']=1;
			$mune['menu']=$list;
			//echo json_encode($mune);exit;
			$data['munelist']=json_encode($mune);
			
			
		}
		
        $this->load->view('home/home_index',$data);
    }


}
<?php
/**
*
*@复盘
*/

class Conquer extends Api_Controller
{


	public function __construct()
	{
		parent::__construct();
		$this->load->model('conquer_mdl','conquer');
		$this->load->model('conquer_reply_mdl','conquer_reply');
		$this->load->model('replay_type_mdl','replay_type');
		$this->load->model('project_mdl','project');
	}

	/*
	*@取得列表
	*@name:conquer
	*@mid int 用户id
	*@offset 数据起点
	*@limit 取几条数据
	*/
	public function index()
	{
		$member = $this->session->userdata('member'); 
		$data = $this->requestData();
		$mid = $member['id'];
		$company_id = $data['data']['company_id']?$data['data']['company_id']:1;//所属管理员 
		 
	    if(empty($member)){
		 redirect('d=api&c=login','','','抱歉,请先登录');
	      exit;
		}
		
		 
		$list = array();
		$limit = !empty($data['data']['limit']) ? $data['data']['limit'] : 10;
		$offset = !empty($data['data']['offset']) ? $data['data']['offset'] : 0;
		$type=$data['data']['type'];
        $wherelist['page'] = true;
        $wherelist['limit'] = $limit;
        $wherelist['offset'] =$offset;
		if($type==2){
			 
			$wherelist['where'] = array('c.uid'=>$mid,'c.company_id'=>$company_id);
			$wherelist['order']=array('key'=>'id','value'=>'desc');
			$list = $this->conquer->getList($wherelist);
			$where['where'] = array('uid'=>$mid);
			$total=$this->conquer->get_count2($where);
		
		}
		if($type==1){
			$wherelist['where'] = array('c.company_id'=>$company_id);
			$wherelist['order']=array('key'=>'id','value'=>'desc');
			$list = $this->conquer->getList($wherelist);
			$total=$this->conquer->get_count2(array());
	 
			 
		}
		if($type==3){
			
			$wherelist['group'] ="r.cid";
			$wherelist['where'] = array('r.mid'=>$mid);
			$wherelist['order']=array('key'=>'id','value'=>'desc');
			$list = $this->conquer->getList2($wherelist);
			$where['where'] =array('r.mid'=>$mid,'c.company_id'=>$company_id);
			$where['group'] ="r.cid";
			$total=$this->conquer->get_count3($where);
		}
		
		if($list){
			foreach($list as $k => $v){
				$cwhere['where']=array('cid'=>$v['id'],'company_id'=>$company_id);
				$cwhere['group']='mid';
				$replycout=$this->conquer_reply->get_count2($cwhere);
				$list[$k]['replytotal']=$replycout;
				$wherereply['where']=array('c.cid'=>$v['id'],'c.isbest'=>1,'c.company_id'=>$company_id);
				$replylist=$this->conquer_reply->getList($wherereply);
				$list[$k]['replylist']=$replylist;
				$list[$k]['icon']= base_url().'uploads/conquer/'.$v['icon'];
				if(!$v['icon']){
					$list[$k]['icon_no']=1;
					}
				if($mid==$list[$k]['uid'] && empty($list[$k]['endtime'])){
					$list[$k]['zjstatus']=1;
				}else{
					$list[$k]['zjstatus']=0;
				}
			}
		}


      if($_POST){
	    $repjson = array(
 			'tag'=>$data['tag'],    	
        	'total'=>$total,//数据总数
        	'data'=>$list, //当前请求的数据列表
        	);
       
        $this->responseData($repjson);
		
	  }else{
       $data =array('list'=>$list,'tag'=>$data['tag'],'total'=>$total);
	
       $this->load->view('api/conquer',$data);
	   }
	}


	/**
	*@dec:详情
	*@paran int id 
	*@paran token
	**/

	public function conquer_detail()
	{
		$member = $this->session->userdata('member'); 
		$data = $this->requestData();
		$mid = $member['id'];
		$company_id = $data['data']['company_id']?$data['data']['company_id']:1;//所属管理员 
		 
		$id = $data['data']['cid'];
	 
		$zjstatus=0;
		if(!empty($id)){
			$conquerinfo=$this->conquer->get_one_by_where(array('c.id'=>$id,'c.company_id'=>$company_id));
			if($conquerinfo){
				//复盘详情
				$config = array('c.id'=>$id);
				$info = $this->conquer->get_one_by_where($config);
				//员工解答
				$cwhere['where']=array('cid'=>$info['id'],'company_id'=>$company_id);
				$cwhere['group']='mid';
				$replytotal=$this->conquer_reply->get_count2($cwhere);
				$wherereply['where']=array('c.cid'=>$id,'c.company_id'=>$company_id);
				$replylist=$this->conquer_reply->getList($wherereply);
				foreach($replylist as $k => $v){
					$replylist[$k]['headerurl'] = base_url().'uploads/member/header/'.$v['headerurl'];
				}
				if($mid==$info['uid']){
					$zjstatus=1;
				}
				if(!$info['icon']){
					$info['icon_no']=1;
					}
				$info['icon']= base_url().'uploads/conquer/'.$info['icon'];
					
				
				
				$info['createtime'] = date("Y-m-d",$info['createtime']);
		 
              $data =array('info'=>$info,//复盘详情
							'total'=>$replytotal,
							'replylist'=>$replylist,
							'zjstatus'=>$zjstatus,//1为可以发布总结，0为不可发布总结
						);

       
	 	
			}else{
				$repjson = array(
				'errcode'=>-1,
				'errmsg'=>'抱歉,不存在此复盘！' , 
				'data'=>array()
				);
			}
		}else{
			$repjson = array(
				'errcode'=>-1,
				'errmsg'=>'抱歉,操作错误！' , 
				'data'=>array()
				);
		}
		 
 
		 $this->load->view('api/conquer_detail',$data);

	}

	/**
	*@创建-复盘
	*/

	public function conquer_create()
	{   $member = $this->session->userdata('member'); 
		$data = $this->requestData();
		$mid = $member['id'];
		$company_id = $data['data']['company_id']?$data['data']['company_id']:1;//所属管理员 
 
	    if($_POST && $mid){
	 
		$mdata['title'] = $data['data']['title'];
		$mdata['uid'] =  $mid;
		$mdata['typeid'] = $data['data']['typeid'];
		$mdata['proid'] = $data['data']['proid'];//项目归属
		$mdata['content'] = $data['data']['content'];
		$mdata['total'] = $data['data']['total'];
 
		$mdata['icon']=$data['data']['icon'];
		//$dir = FCPATH.'/uploads/conquer/';
		/*$filedata = $data['data']['filedata']; //流数据
		$extension = $data['data']['extension'];   //文件类型(jpg,png,.....)
		if(!empty($filedata) && !empty($extension)){
			$filedata = str_replace(' ', '', $filedata);
			$filedata = urldecode($filedata);
			$img = base64_decode($filedata);
			$filename = 'h_'.time().'.'.$extension;
			$filedir = $dir.$filename;
			if(file_put_contents($filedir,$img)){
				$mdata['icon'] = $filename;
			}
		}*/
		
		
		 $mdata['createtime'] = time();
		if(!empty($data['data']['title']) && !empty($data['data']['typeid']) && !empty($mid) && !empty($company_id)){
			if($this->conquer->add($mdata)){
				$repjson = array('errcode'=>0,'errmsg'=>'ok','data'=>array());
			}else{
				$repjson = array('errcode'=>-1,'errmsg'=>'error','data'=>array());
			}
		}else{
			$repjson = array(
				'errcode'=>-1,
				'errmsg'=>'抱歉,操作有误，请重试' , 
				'data'=>array()
				);
		}
		$this->responseData($repjson);
		exit;
		
		}else{
			
		$member = $this->session->userdata('member'); 
		$data = $this->requestData();
		$mid = $member['id'];
		$company_id = $data['data']['company_id']?$data['data']['company_id']:1;//所属管理员 
		 
		$id = $data['data']['cid'];
	 
		
		$config = array('c.id'=>$id);
		$info = $this->conquer->get_one_by_where($config);	
	     $pro = $this->project->get_one_by_id(array('p.id'=>$info['proid']));
		 ;
		$data=array('proinfo'=>$info,'protitle'=>$pro['title']);
	 	
		$this->load->view('api/conquer_create',$data);	
			
			
			}
	}
	


	/**
	*
	*@复盘类型
	*/
	public function conquer_type()
	{	
		
		$data = $this->requestData();
		$token = $data['data']['token'];
		$company_id = $data['data']['company_id'];
		$where['where']=array('company_id'=>$company_id);
		$list=$this->replay_type->getList($where);
		$repjson = array(
			'tag'=>$data['tag'],  
			'errcode'=>0,
			'errmsg'=>'ok' ,
			'data'=>array(
			'list'=>$list, 
			)
		);
		$this->responseData($repjson);
	}

	//归属项目类别
	public function conquer_project(){
		$data = $this->requestData();
		$token = $data['data']['token'];
		$company_id = $data['data']['company_id'];
		$list=$this->project->getList(array('p.status'=>1,'p.company_id'=>$company_id));
		$repjson = array(
			'tag'=>$data['tag'],  
			'errcode'=>0,
			'errmsg'=>'ok' ,
			'data'=>array(
			'list'=>$list, 
			)
		);
		$this->responseData($repjson);
	}

	/**
	*专家总结
	**/

	public function summary()
	{
		
		$member = $this->session->userdata('member'); 
		$data = $this->requestData();
		$uid = $member['id'];
		$company_id = $data['data']['company_id']?$data['data']['company_id']:1;//所属管理员 
		 $id = $data['data']['cid'];
		
		
		$content = $data['data']['content'];
		$mdata['summary'] = $content;
		$mdata['endtime'] = time();
		$mdata['status'] = 3;
		$conquerinfo=$this->conquer->get_one_by_where(array('c.id'=>$id));
		if($conquerinfo){
			//更新
			if(!empty($content)){
				$config = array('id'=>$id);
				$this->conquer->update($config,$mdata);
				
				$result = array('errcode'=>0,'errmsg'=>'ok');
			}else{
				$result = array('errcode'=>-1,'errmsg'=>'总结内容为空');
			}
		}else{
			$result = array('errcode'=>-1,'errmsg'=>'抱歉，不存在此复盘');
		}
		$this->responseData($result);

	}

	/**
	* 员工解答
	*/
	public function reply()
	{
		
		$member = $this->session->userdata('member'); 
		$data = $this->requestData();
		$uid = $member['id'];
		$company_id = $data['data']['company_id']?$data['data']['company_id']:1;//所属管理员 
		
		$mid = $uid;
		$cid = $data['data']['cid'];
		$content = $data['data']['content'];
		 
		/**录入**/
		if(!empty($mid) && !empty($cid) && !empty($content)){
			$conquerinfo=$this->conquer->get_one_by_where(array('c.id'=>$cid));
			if($conquerinfo){
				$mdata['cid'] = $cid;
				$mdata['mid'] = $mid;
				$mdata['content'] = $content;
				$mdata['company_id'] = $company_id;
				$mdata['createtime'] = time();
				if($this->conquer_reply->add($mdata)){
					$result = array('errcode'=>0,'errmsg'=>'ok');
				}else{
					$result = array('errcode'=>-1,'errmsg'=>'操作失败，请重试');
				}
			}else{
				$result = array('errcode'=>-1,'errmsg'=>'抱歉，不存在此复盘');
			}
		}

		$this->responseData($result);
	}

	//设置为最优的回答
	public function conquer_isbest(){
		$data = $this->requestData();
		$token = $data['data']['token'];
		$replyid = $data['data']['replyid'];
		$company_id = $data['data']['company_id']?$data['data']['company_id']:1;//所属管理员 
		if(!empty($replyid)){
			$replayinfo=$this->conquer_reply->get_one_by_where(array('id'=>$replyid,'company_id'=>$company_id));
			$conquer=$this->conquer_reply->get_one_by_where(array('cid'=>$replayinfo['cid'],'isbest'=>1,'company_id'=>$company_id));
			if($conquer){
				$result = array('errcode'=>-1,'errmsg'=>'抱歉，已存在最优！');
			}else{
				if($replayinfo){
					$mdata['isbest'] = 1;
					if($this->conquer_reply->update(array('id'=>$replyid),$mdata)){
						$result = array('errcode'=>0,'errmsg'=>'ok');
					}else{
						$result = array('errcode'=>-1,'errmsg'=>'操作失败，请重试');
					}
			 
				}else{
					$result = array('errcode'=>-1,'errmsg'=>'抱歉，不存在此数据');
				}
			}
		}else{
			$result = array('errcode'=>-1,'errmsg'=>'抱歉，操作有误');
		}
		$this->responseData($result);
	}
	
	//修改复盘
	public function conquer_update()
	{
	
	    $member = $this->session->userdata('member'); 
		$data = $this->requestData();
 
 
		$company_id = $data['data']['company_id']?$data['data']['company_id']:1;//所属管理员 
	    $mid = $member['id'];
	
		$cid = $data['data']['cid'];
		
	    $mdata['title'] = $data['data']['title'];
		$mdata['uid'] =  $mid;
		$mdata['typeid'] = $data['data']['typeid'];
		$mdata['proid'] = $data['data']['proid'];//项目归属
		$mdata['content'] = $data['data']['content'];
		$mdata['total'] = $data['data']['total'];
 
		$mdata['icon']=$data['data']['icon'];
		if(!empty($data['data']['cid']) && !empty($mid)){
			
			$conquerinfo=$this->conquer->get_one_by_id(array('id'=>$cid,'uid'=>$mid));
			if($conquerinfo){
				if($this->conquer->update(array('id'=>$cid),$mdata)){
					$repjson = array('errcode'=>0,'errmsg'=>'ok','data'=>array());
				}else{
					$repjson = array('errcode'=>-1,'errmsg'=>'error','data'=>array());
				}
			}else{
				$repjson = array(
					'errcode'=>-1,
					'errmsg'=>'抱歉,无权修改此复盘' , 
					'data'=>array()
					);
			}
			
		}else{
			$repjson = array(
				'errcode'=>-1,
				'errmsg'=>'抱歉,操作有误，请重试' , 
				'data'=>array()
				);
		}
		$this->responseData($repjson);
	}
	
	public function uploadimg(){
		    
		    if(!empty($_FILES['userfile']['name'])){

                $config['upload_path'] = FCPATH.'/uploads/conquer/';;
                //echo $config[upload_path];
                //exit;
                $config['allowed_types'] = '*';
                $config['file_name']  =date("YmdHis");

                $this->load->library('upload', $config);

                if ( ! $this->upload->do_upload('userfile')){
                    $error = array('error' => $this->upload->display_errors());
                    echo json_encode($error);
                }else{
                    $dataupload = array('upload_data' => $this->upload->data());
                    $picname = $dataupload['upload_data']['orig_name'];
                   echo "<img src='".base_url()."/uploads/conquer/$picname' /><input value='$picname' type='hidden' id='icon' />";
                }
				
            }
		 }
		 
   public function delcon(){
	   
	    $member = $this->session->userdata('member'); 
		$data = $this->requestData();
        $company_id = $data['data']['company_id']?$data['data']['company_id']:1;//所属管理员 
	    $mid = $member['id'];
	   
	   
		$id = $data['data']['cid'];
		
	 	$conquerinfo=$this->conquer->get_one_by_id(array('id'=>$id,'uid'=>$mid));
		
		if(!empty($conquerinfo)){
		 
			
			
			
			$this->conquer->del(array('id'=>$id,'company_id'=>$company_id));
			
			
			
			 
			$repjson = array(
				'errcode'=>0,
				'errmsg'=>'删除成功' , 
				'data'=>array()
				);
			$this->responseData($repjson);
		}else{
			$repjson = array(
				'errcode'=>-1,
				'errmsg'=>'抱歉,操作有误，请重试' , 
				'data'=>array()
				);
			$this->responseData($repjson);
		}
	   
	   
	   }		 
	
	
}
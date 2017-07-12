<?
/**
*@公式设置
*
**/


class Gongshi extends Admin_Controller
{
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model('gongshi_mdl','gongshi');
		$this->load->model('star_mdl','star');
	}


	public function index()
	{
		$admininfo= $this->userinfo;//登陆信息
		$where['where']=array('company_id'=>$admininfo['roleid']);
		$star=$this->star->getList($where);
		$data['list'] = $star;
		//计算公式 g-n-z-t
		$config2 = array('tags'=>'jisuan','company_id'=>$admininfo['roleid']);
		$jisuan = $this->gongshi->get_one_by_id($config2);
		//print_r($jisuan);
		$j = array();
		if(!empty($jisuan)){
			$j[0] =substr($jisuan['info'], 1,1);
			$j[1] =substr($jisuan['info'], 3,1);
			$j[2] =substr($jisuan['info'], 5,1);

		}
		$data['j'] = $j;
		//人气分数
		$config3 = array('tags'=>'renqi','company_id'=>$admininfo['roleid']);
		$renqifen = $this->gongshi->get_one_by_id($config3);
		$data['renqifen'] = $renqifen['info'];
		
		$this->load->view('home/home_gongshi',$data);
	}

	public function update()
	{
		$admininfo= $this->userinfo;//登陆信息
		if(!empty($_POST)){
			$gmstar = $this->input->post('gmstar');
			$ndstar = $this->input->post('ndstar');
			$zlstar = $this->input->post('zlstar');
			$txstar = $this->input->post('txstar');
			
			$data['type']=1;
			$data['star1']=$gmstar[0];
			$data['star2']=$gmstar[1];
			$data['star3']=$gmstar[2];
			$data['star4']=$gmstar[3];
			$data['star5']=$gmstar[4];
			$this->star->update(array('id'=>$this->input->post('gmid')),$data);

			$data1['type']=2;
			$data1['star1']=$ndstar[0];
			$data1['star2']=$ndstar[1];
			$data1['star3']=$ndstar[2];
			$data1['star4']=$ndstar[3];
			$data1['star5']=$ndstar[4];
			$this->star->update(array('id'=>$this->input->post('ndid')),$data1);
			
			$data2['type']=3;
			$data2['star1']=$zlstar[0];
			$data2['star2']=$zlstar[1];
			$data2['star3']=$zlstar[2];
			$data2['star4']=$zlstar[3];
			$data2['star5']=$zlstar[4];
			$this->star->update(array('id'=>$this->input->post('zlid')),$data2);
			
			
			$data3['type']=4;
			$data3['star1']=$txstar[0];
			$data3['star2']=$txstar[1];
			$data3['star3']=$txstar[2];
			$data3['star4']=$txstar[3];
			$data3['star5']=$txstar[4];
			$this->star->update(array('id'=>$this->input->post('txid')),$data3);
				
			$j = $this->input->post('j');

			//计算
			$str = 'g'.$j[0].'n'.$j[1].'z'.$j[2].'t';
			$jupdate['info'] = $str;
			$jupdateconfig = array('tags'=>'jisuan','company_id'=>$admininfo['roleid']);
			$this->gongshi->update($jupdateconfig,$jupdate);
			
			$jupdateconfig1 = array('tags'=>'renqi','company_id'=>$admininfo['roleid']);
			$renqigrade=$this->input->post('renqigrade');
			$this->gongshi->update($jupdateconfig1,array('info'=>$renqigrade));
			
			redirect('d=home&c=gongshi');

		}else{
			$where['where']=array('company_id'=>$admininfo['roleid']);
			$star=$this->star->getList($where);
			$data['list'] = $star;
			//计算公式 g-n-z-t
			$config2 = array('tags'=>'jisuan','company_id'=>$admininfo['roleid']);
			$jisuan = $this->gongshi->get_one_by_id($config2);
			//print_r($jisuan);
			$j = array();
			if(!empty($jisuan)){
				$j[0] =substr($jisuan['info'], 1,1);
				$j[1] =substr($jisuan['info'], 3,1);
				$j[2] =substr($jisuan['info'], 5,1);

			}
			$data['j'] = $j;
			//人气分数
			$config3 = array('tags'=>'renqi','company_id'=>$admininfo['roleid']);
			$renqifen = $this->gongshi->get_one_by_id($config3);
			$data['renqifen'] = $renqifen['info'];
			
			$this->load->view('home/home_gongshi_update',$data);
		}

	}

}
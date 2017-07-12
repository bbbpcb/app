<?php
/**
*@DEC领取任务人员完成任务情况
*
**/

class Execution extends Admin_Controller
{
	

	public function __construct()
	{
		parent::__construct();
		$this->load->model('task_plan_mdl','task_plan');
		$this->load->model('task_wenti_mdl','task_wenti');
		$this->load->model('task_fansi_mdl','task_fansi');
	}

	public function index()
	{
		$id = $this->input->get('id');
		$mid = $this->input->get('mid');
		$taskid = $this->input->get('taskid');
		$tab = isset($_GET['tab']) ? $_GET['tab'] : 'home';
		$data['tab'] = $tab;

		$cehua = array();
		$wenti = array();
		$fansi = array();

		//策划于立项
		$cehuawhere['where'] = array('plan.taskid'=>$taskid,'plan.mid'=>$mid);
		$cehua = $this->task_plan->getList($cehuawhere);
		
		//问题与解决
		$wentiwhere['where'] = array('wenti.taskid'=>$taskid,'wenti.mid'=>$mid);
		$wenti = $this->task_wenti->getList($wentiwhere);

		//结果与反思
		$fansiwhere['where'] = array('fansi.taskid'=>$taskid,'fansi.mid'=>$mid);
		$fansi = $this->task_fansi->getList($fansiwhere);

		//专家回复
		$this->load->model('task_plan_reply_mdl','task_plan_reply');

		//策划于立项
		$task_plan_reply = $this->task_plan_reply->getList();
		$data['task_plan_reply'] = $task_plan_reply;

		//问题与解决
		//$task_plan_reply = $this->task_plan_reply->getList();
		//$data['task_plan_reply'] = $task_plan_reply;

		$data['cehua'] = $cehua;
		$data['wenti'] = $wenti;
		$data['fansi'] = $fansi;

		$this->load->view('home/home_execution',$data);
	}

	public function task_plan_reply()
	{
		$this->load->model('task_plan_reply_mdl','task_plan_reply');
		$id = $this->input->get('id');
		$where['where'] = array('plan.id'=>$id);
		$task_plan_reply = $this->task_plan_reply($where);

		 

	}

}
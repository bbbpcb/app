<?php




class Aboutus extends Admin_Controller
{
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model('article_mdl','article');
	}


	public function index()
	{
		if(!empty($_POST)){
			$content = $this->input->post('content');
			$website = $this->input->post('website');
			$tel = $this->input->post('tel');
			$version = $this->input->post('version');

			$config = array('tag'=>'aboutus');
			$data['content'] = $content;
			$data['website'] = $website;
			$data['tel'] = $tel;
			$data['version'] = $version;
			$this->article->update($config,$data);

			redirect('d=home&c=aboutus');

		}else{

			$config = array('tag'=>'aboutus');
			$info = $this->article->get_one_by_id($config);
			$data['info'] = $info;

			$this->load->view('home/home_aboutus',$data);
		}
	}


}
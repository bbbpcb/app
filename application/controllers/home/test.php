<?php


class Test extends Admin_Controller{

	public function __constrcut(){
		parent::__constrcut();
	}

	public function index(){
		$this->load->view('home/test');
	}
}
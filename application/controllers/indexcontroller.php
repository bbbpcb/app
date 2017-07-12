<?php


class Indexcontroller extends Base_Controller{
	
	public function __construct(){
		parent::__construct();
	}


	public function index(){
		
	header("location:".base_url()."index.php?d=api&c=index");
		
	}
}
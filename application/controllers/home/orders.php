<?php

class Orders extends Admin_Controller
{
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model('orders_mdl','order');
		$this->load->model('orderdetail_mdl','detail');
	}

	public function index()
	{
		$page = isset($_GET['page']) ? $_GET['page'] : 0;
        $page = ($page && is_numeric($page)) ? intval($page) : 1;

        $limit = 20;
        $offset = ($page - 1) * $limit;
        $pagination = '';

        $count = $this->order->get_count();
        $this->load->library('pagination');
        $config['base_url'] = base_url().'index.php?d=home&c=orders';
        $config['total_rows'] = $count;
        //设置url上第几段用于传递分页器的偏移量
        $config ['uri_segment'] = 4;
        $config['per_page'] = $limit;
        $config['use_page_numbers'] = TRUE;
        $config['query_string_segment'] = 'page';
        $this->pagination->initialize($config);
        $data['page'] = $this->pagination->create_links();

        $list = array();
        $where['page'] = true;
        $where['limit'] = $limit;
        $where['offset'] = $offset;
        $list = $this->order->getList($where);
        $data['list'] = $list;

        $detailwhere = array();
        $detail = $this->detail->getList($detailwhere);
        foreach($detail as $k => $v){
        	$tmp[$v['oid']] += $v['num'];
        }
        $data['pronum'] = $tmp;

		$this->load->view('home/home_orders',$data);
	}

	public function detail()
	{
		$id = $this->input->get('id');

		$where = array('o.id'=>$id);
		$orderinfo = $this->order->get_new_by_id($where);
		$data['orderinfo'] = $orderinfo;

		$detailwhere = array('where'=>array('oid'=>$orderinfo['id']));
		$detailinfo = $this->detail->getList($detailwhere);
		$data['list'] = $detailinfo;
	

		$this->load->view('home/home_order_detail',$data);
	}

	public function detailupdate(){
		if(!empty($_POST)){
			$id = $this->input->post('id');
			$where = array('o.id'=>$id);
			$orderinfo = $this->order->get_new_by_id($where);
			if(!empty($orderinfo)){
				if($orderinfo['status'] == '0'){
					$name = $this->input->post('name');
					$xingshi = $this->input->post('xingshi');
					$address1 = $this->input->post('address1');
					$address2 = $this->input->post('address1');
					$phone = $this->input->post('phone');
					$time1 = $this->input->post('time1');
					$status = $this->input->post('status');

					$data['name'] = $name;
					$data['xingshi'] = $xingshi;
					$data['address1'] = $address1;
					$data['address2'] = $address2;
					$data['phone'] = $phone;
					$data['time1'] = $time1;
					$data['status'] = $status;

					$config = array('id'=>$id);
					$this->order->update($config,$data);
					redirect('d=home&c=orders&lang='.$lang);
				}
			}
		}
	}

	public function del(){
		$id = $this->input->get('id');
		$where = array('id'=>$id);
		$this->order->del($where);
		redirect('d=home&c=orders');
	}
}
<?php

class Cart
{

	var $total = 0;

	private $_CI;


	public function __construct()
	{
		$this->CI = & get_instance();
	}

	public function getCart()
	{
		$cookie = $_COOKIE["whit"];
        $arr = array();
        $product = array();
        $data = array();
        $alltotal = 0;
        if(!empty($cookie)){
        	$arr = json_decode($cookie,true);
        	if(!empty($arr)){
        		$ids = implode(',', array_keys($arr));
        		$query = $this->CI->db->query("select * from whit_product where id in($ids)");

				if ($query->num_rows() > 0)
				{

					foreach ($query->result_array() as $row)
					{
						$tmp['id'] = $row['id'];
						$tmp['proname'] = $row['proname'];
						$tmp['pic'] = $row['pic'];
						$tmp['price'] = $row['price'];
						$tmp['num'] = $arr[$row['id']];
						$tmp['total'] = $row['price']*$arr[$row['id']];
						$product[] = $tmp;
						$alltotal+=$tmp['total'];
					}				  
				}       		
        	}
        }

        $data['product'] = $product;
		$data['alltotal'] = $alltotal;
		
		return $data;
	}
}
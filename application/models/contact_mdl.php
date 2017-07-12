<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 14-6-27
 * Time: 下午4:09
 */

class Contact_mdl extends CI_Model
{


    const TABLE_PERSON = 'whit_person_info';
    const TABLE_COMPANY = 'whit_company_info';



    public function __construct()
    {
        parent::__construct();

    }

    //get list
    public function getList($type = 'person',$config)
    {
        if(!empty($config['where'])){
            $this->db->where($config['where']);
        }

        if(!empty($config['page'])){
            $this->db->limit(intval($config['limit']));
            $this->db->offset(intval($config['offset']));
        }

        $list = array();
        if($type == 'person'){
        	$list = $this->db->get(self::TABLE_PERSON)->result_array();
        }elseif($type == 'company'){
        	$list = $this->db->get(self::TABLE_COMPANY)->result_array();;

        }
        

        return $list;
    }

    //删除单条信息
    public function del($type,$where){
        if(!empty($where)){
            $this->db->where($where);
        }
        if($type == 'person'){
            return $this->db->delete(self::TABLE_PERSON);
        }elseif($type == 'company'){
            return $this->db->delete(self::TABLE_COMPANY);
        }else{
            exit('type error');
        }
    }

    public function delall($type = 'person'){

        if($type == 'person'){
            return $this->db->truncate(self::TABLE_PERSON);
        }elseif($type == 'company'){
            return $this->db->truncate(self::TABLE_COMPANY);
        }else{
            exit('type error');
        }
        
    }



    //add data
    public function add_person($data){

        return $this->db->insert(self::TABLE_PERSON,$data);
    }

        //add data
    public function add_company($data){

        return $this->db->insert(self::TABLE_COMPANY,$data);
    }


    //get data count
    public function get_count($type = 'person',$where = array())
    {

        $count = 0;
        if($type == 'person'){
        	$count = $this->db->count_all_results(self::TABLE_PERSON);
        }elseif($type == 'company'){
        	$count = $this->db->count_all_results(self::TABLE_COMPANY);

        }else{
        	exit('type empty');
        }

        return $count;
    }


}
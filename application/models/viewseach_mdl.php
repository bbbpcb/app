<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 14-6-27
 * Time: 下午2:05
 */

class Viewseach_mdl extends  CI_Model
{



    const TABLE ='dw_viewseach';  
  
    public function __construct()
    {
        parent::__construct();
    }

    public function getList($config=array())
    {
        if(!empty($config['where'])){
            $this->db->where($config['where']);
        }

        if(!empty($config['page'])){
            $this->db->limit(intval($config['limit']));
            $this->db->offset(intval($config['offset']));
        }
		if(!empty($config['likeand'])){
            $this->db->like($config['likeand']); 
        }
        $list = $this->db->select('*')
                ->from(self::TABLE)
           
                ->get()->result_array();

        return $list;

    }

    public function add($data){

        return $this->db->insert(self::TABLE,$data);
    }


    public function update($where, $data){
        
        if(!empty($where)){
            $this->db->where($where);
        }

        $this->db->update(self::TABLE, $data);

        return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
    }

    public function del($where=array())
    {
        if(!empty($where)){
            $this->db->where($where);
        }

        return $this->db->delete(self::TABLE);
    }


    public function delall(){

        return $this->db-> truncate(self::TABLE);
    }

    
	
    public function get_count($where = array())
    {

        $count = 0;
        if(!empty($where)){
            $this->db->where($where);
        }
		if(!empty($where['likeand'])){
            $this->db->like($where['likeand']); 
        }
        $count =  $this->db->count_all_results(self::TABLE);

        return $count;
    }
	
	 public function get_count1($where = array())
    {
        $count = 0;
        if(!empty($where)){
            $this->db->where($where);
        }
         $count = $this->db->select('*')
                ->from(self::TABLE)
                ->count_all_results();
        return $count;
    }
	
	public function get_count2($where = array())
    {

        $count = 0;
         if(!empty($where['where'])){
            $this->db->where($where['where']);
        }
		if(!empty($where['likeand'])){
            $this->db->like($where['likeand']); 
        }
        $count =  $this->db->count_all_results(self::TABLE);

        return $count;
    }
	


    //返回添加数据后的ID
    public function insert_id()
    {
        return $this->db->insert_id();
    }
	

}
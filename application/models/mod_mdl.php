<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 14-6-27
 * Time: 下午2:05
 */

class Mod_mdl extends  CI_Model
{



    const TABLE ='dw_mod';  
    const TAABLE_TYPE = 'dw_project';


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
        //$this->db->order_by('id','desc');
        if(!empty($config['order'])){
            $this->db->order_by($config['order']['key'],$config['order']['value']);
        }
        $list = array();
        $list = $this->db->select('m.*')
                        ->from(self::TABLE.' as m')
                      
                        ->get()->result_array();
        //$list = $this->db->get(self::TABLE)->result_array();

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

    public function get_one_by_id($where)
    {
        $news = array();
        if(!empty($where)){
            $this->db->where($where);
        }

        $news = $this->db->get(self::TABLE)->row_array();
        return $news;
    }

    public function get_count($where = array())
    {

        $count = 0;
        if(!empty($where)){
            $this->db->where($where);
        }
        $count =  $this->db->count_all_results(self::TABLE);

        return $count;
    }
	
	public function get_count1($where = array())
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
}
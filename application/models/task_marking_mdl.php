<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 14-6-27
 * Time: 下午2:05
 */

class Task_marking_mdl extends  CI_Model
{



    const TABLE ='dw_task_marking'; 
    const TABLE_MEMBER = 'dw_member'; 


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
        $list = array();
        $list = $this->db->select('mt.*,m.realname')
                        ->from(self::TABLE.' as mt')
                        ->join(self::TABLE_MEMBER.' as m','m.id=mt.mid','left')
                        ->get()->result_array();
        //$list = $this->db->get(self::TABLE)->result_array();

        return $list;

    }
	public function get_membertask_project($config=array()){
		if(!empty($config['where'])){
            $this->db->where($config['where']);
        }
		if(!empty($config['group'])){
            $this->db->group_by($config['group']);
        }
        if(!empty($config['page'])){
            $this->db->limit(intval($config['limit']));
            $this->db->offset(intval($config['offset']));
        }
		 if (!empty($config['wherein'])) { 
            $this->db->where_in('mid',$config['wherein']);  
        }
		
        $list = array();
        $list = $this->db->get(self::TABLE)->result_array();

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

        $news = $this->db->select('*,(select realname from dw_member where id=dw_task_marking.mid) as realname,(select headerurl from dw_member where id=dw_task_marking.mid) as headerurl')->get(self::TABLE)->row_array();
        return $news;
    }
	
	
	public function get_all($where)
    {
        $list = array();
        if(!empty($where)){
            $this->db->where($where);
        }
        $list = $this->db->select('*,(select realname from dw_member where id=dw_task_marking.mid) as realname,(select headerurl from dw_member where id=dw_task_marking.mid) as headerurl')->get(self::TABLE)->result_array();
        return $list;
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
}
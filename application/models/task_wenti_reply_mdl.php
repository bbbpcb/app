<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 14-6-27
 * Time: 下午2:05
 */

class Task_wenti_reply_mdl extends  CI_Model
{



    const TABLE ='dw_task_wenti_reply';  
    const TABLE_Member = 'dw_member';
	const TABLE_WENTI ='dw_task_wenti';  


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

        $this->db->order_by('id','desc');
        $list = array();
        $list = $this->db->select('w.*,(select realname from dw_member where id=w.exid) as realname,(select headerurl from dw_member where id=w.exid) as headerurl')
                        ->from(self::TABLE.' as w')
                        //->join(self::TABLE_EXPERT.' as ex','ex.id=w.exid','left')
                        ->get()->result_array();
        //$list = $this->db->get(self::TABLE)->result_array();

        return $list;

    }

	 public function getList1($config=array())
    {
        if(!empty($config['where'])){
            $this->db->where($config['where']);
        }

        if(!empty($config['page'])){
            $this->db->limit(intval($config['limit']));
            $this->db->offset(intval($config['offset']));
        }

        $this->db->order_by('r.id','desc');
        $list = array();
        $list = $this->db->select('*')
                        ->from(self::TABLE.' as r')
                        ->join(self::TABLE_WENTI.' as w','r.wentiid=w.id','right')
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

    public function get_one_by_id($where)
    {
        $news = array();
        if(!empty($where)){
            $this->db->where($where);
        }
		$this->db->order_by('id','desc');
        $news = $this->db->select('r.*,m.realname,m.headerurl')
		 ->from(self::TABLE.' as r')
         ->join(self::TABLE_Member.' as m','m.id=r.exid','left')
		->get()->row_array();
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
}
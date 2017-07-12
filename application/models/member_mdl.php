<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 14-6-27
 * Time: 下午2:05
 */

class Member_mdl extends  CI_Model
{


    const TABLE_MEMBER = 'dw_member';
    const TABLE_DEPARTMENT ='dw_department';  
	const TABLE_MEMBER_EX ='dw_member_ex';
	const TABLE_JOBS ='dw_jobs';    

    public function __construct()
    {
        parent::__construct();
    }

    public function getList($config=array())
    {
        if(!empty($config['where'])){
            $this->db->where($config['where']);
        }
		if(!empty($config['likeand'])){
            $this->db->like($config['likeand']); 
        }
        if(!empty($config['page'])){
            $this->db->limit(intval($config['limit']));
            $this->db->offset(intval($config['offset']));
        }
        $list = array();
        $list = $this->db->select('m.*,d.dep_name,d.id as did,j.dep_name as jobs_name,j.id as jid')
                ->from(self::TABLE_MEMBER.' as m')
                ->join(self::TABLE_DEPARTMENT.' as d','d.id=m.depid','left')
				 ->join(self::TABLE_JOBS.' as j','j.id=m.zhiwei','left')
                ->get()
                ->result_array();

       
        //$list = $this->db->get(self::TABLE_MEMBER)->result_array();

        return $list;

    }
	
	public function getList3($config=array())
    {
        if(!empty($config['where'])){
            $this->db->where($config['where']);
        }
		if(!empty($config['likeand'])){
            $this->db->like($config['likeand']); 
        }
        if(!empty($config['page'])){
            $this->db->limit(intval($config['limit']));
            $this->db->offset(intval($config['offset']));
        }
        $list = array();
        $list = $this->db->select('m.*,d.dep_name,d.id as did,j.dep_name as jobs_name,j.id as jid')
                ->from(self::TABLE_MEMBER.' as m')
                ->join(self::TABLE_DEPARTMENT.' as d','d.id=m.depid','left')
				 ->join(self::TABLE_JOBS.' as j','j.id=m.zhiwei','left')
                ->get()
                ->result_array();

       
        //$list = $this->db->get(self::TABLE_MEMBER)->result_array();

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
		if(!empty($config['order'])){
            $this->db->order_by($config['order']['key'],$config['order']['value']);
        }
        $list = array();
        $list = $this->db->select('m.*,`mex`.`id` as xid')//
                ->from(self::TABLE_MEMBER.' as m')
				->join(self::TABLE_MEMBER_EX.' as mex','m.id=mex.exid','left')
                //->join(self::TABLE_DEPARTMENT.' as d','d.id=m.depid','left')
                ->get()
                ->result_array();

       
        //$list = $this->db->get(self::TABLE_MEMBER)->result_array();

        return $list;

    }

	public function getList2($config=array())
    {
        if(!empty($config['where'])){
            $this->db->where($config['where']);
        }

        if(!empty($config['page'])){
            $this->db->limit(intval($config['limit']));
            $this->db->offset(intval($config['offset']));
        }
		if(!empty($config['order'])){
            $this->db->order_by($config['order']['key'],$config['order']['value']);
        }
        $list = array();
        $list = $this->db->select('m.*')//
                ->from(self::TABLE_MEMBER.' as m')
                ->get()
                ->result_array();
        return $list;

    }

    public function add($data){

        return $this->db->insert(self::TABLE_MEMBER,$data);
    }

    public function insert_id()
    {
        return $this->db->insert_id();
    }


    public function update($where, $data){
        
        if(!empty($where)){
            $this->db->where($where);
        }

        $this->db->update(self::TABLE_MEMBER, $data);

        return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
    }

    public function del($where=array())
    {
        if(!empty($where)){
            $this->db->where($where);
        }

        return $this->db->delete(self::TABLE_MEMBER);
    }


    public function delall(){

        return $this->db-> truncate(self::TABLE_MEMBER);
    }

    public function get_one_by_id($where)
    {
        $news = array();
        if(!empty($where)){
            $this->db->where($where);
        }
        $news = $this->db->get(self::TABLE_MEMBER)->row_array();
        return $news;
    }

	public function get_all($where)
    {
       $list = array();
       if(!empty($where['where'])){
            $this->db->where($where['where']);
        }
		if(!empty($where['like'])){
            $this->db->or_like($where['like']); 
        }
		 if (!empty($where['mid'])) {
            $this->db->where("id <> ", $where['mid']);   
        }
        $list = $this->db->select()->from(self::TABLE_MEMBER) ->get()
                ->result_array();
        return $list;
    }

    public function get_count($where = array())
    {

        $count = 0;
        if(!empty($where)){
            $this->db->where($where);
        }
        $count =  $this->db->count_all_results(self::TABLE_MEMBER);

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
        $count =  $this->db->count_all_results(self::TABLE_MEMBER);

        return $count;
    }
}
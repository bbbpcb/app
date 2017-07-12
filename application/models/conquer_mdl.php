<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 14-6-27
 * Time: 下午2:05
 */

class Conquer_mdl extends  CI_Model
{


    const TABLE = 'dw_conquer';
    const TABLE_REPLY = 'dw_conquer_reply';
    const TABLE_TYPE = 'dw_replay_type';
    const TABLE_MEMBER = 'dw_member';
    const TABLE_EXPERT = 'dw_expert';


    public function __construct()
    {
        parent::__construct();
    }

    public function getList($config=array())
    {
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
		if(!empty($config['likeand'])){
            $this->db->like($config['likeand']); 
        }
		
		if(!empty($config['order'])){
            $this->db->order_by($config['order']['key'],$config['order']['value']);
        }
        $list = array();
        
        $list = $this->db->select('c.*,pt.id as ptid,pt.type_name,(select realname from dw_member where id=c.uid) as realname,(select title from dw_project where id=c.proid) as proname')
                ->from(self::TABLE.' as c')
				//->join(self::TABLE_REPLY.' as r','c.id=r.cid','left')
                ->join(self::TABLE_TYPE.' as pt','pt.id=c.typeid','left')
//                ->join(self::TABLE_MEMBER.' as m','m.id=c.uid','left')
//                ->join(self::TABLE_EXPERT.' as ex','ex.id=c.uid','left')
                ->get()->result_array();  
        return $list;

    }
	
	public function getList2($config=array())
    {
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
		if(!empty($config['likeand'])){
            $this->db->like($config['likeand']); 
        }
		
		if(!empty($config['order'])){
            $this->db->order_by($config['order']['key'],$config['order']['value']);
        }
        $list = array();
        
        $list = $this->db->select('c.*,pt.id as ptid,pt.type_name,(select realname from dw_member where id=c.uid) as realname,(select title from dw_project where id=c.proid) as proname')
                ->from(self::TABLE.' as c')
				->join(self::TABLE_REPLY.' as r','c.id=r.cid','left')
                ->join(self::TABLE_TYPE.' as pt','pt.id=c.typeid','left')
//                ->join(self::TABLE_MEMBER.' as m','m.id=c.uid','left')
//                ->join(self::TABLE_EXPERT.' as ex','ex.id=c.uid','left')
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

    public function get_one_by_where($where)
    {
        $news = array();
        if(!empty($where)){
            $this->db->where($where);
        }

        $news = $this->db->select('c.*,m.realname as author,t.type_name as typename,(select title from dw_project where id=c.proid) as proname')
                ->from(self::TABLE.' as c')
                ->join(self::TABLE_EXPERT.' as m','m.id=c.uid','left')
                ->join(self::TABLE_TYPE.' as t','t.id=c.typeid','left')
                ->get()->row_array();

        //$news = $this->db->get(self::TABLE)->row_array();
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
	
	public function get_count3($where = array())
    {

        $count = 0;
         if(!empty($where['where'])){
            $this->db->where($where['where']);
        }
		if(!empty($where['group'])){
            $this->db->group_by($where['group']);
        }
		if(!empty($where['likeand'])){
            $this->db->like($where['likeand']); 
        }
        $list = array();
        
        $list = $this->db->select('c.*,pt.id as ptid,pt.type_name,(select realname from dw_member where id=c.uid) as realname,(select title from dw_project where id=c.proid) as proname')
                ->from(self::TABLE.' as c')
				->join(self::TABLE_REPLY.' as r','c.id=r.cid','left')
                ->join(self::TABLE_TYPE.' as pt','pt.id=c.typeid','left')
//                ->join(self::TABLE_MEMBER.' as m','m.id=c.uid','left')
//                ->join(self::TABLE_EXPERT.' as ex','ex.id=c.uid','left')
                ->get()->result_array();  

        return count($list);
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
}
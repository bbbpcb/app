<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 14-6-27
 * Time: 下午2:05
 */

class Review_staff_mdl extends  CI_Model
{



    const TABLE ='dw_review_staff'; 
    const TABLE_REVIEW = 'dw_review'; 



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
		if(!empty($config['group'])){
            $this->db->group_by($config['group']);
        }

        if(!empty($where['where_in'])){
            $this->db->where_in($where['where_in']['key'],$where_in['where_in']['value']);
        }
		if(!empty($config['order'])){
            $this->db->order_by($config['order']['key'],$config['order']['value']);
        }
		
        $list = $this->db->select('staff.*,rev.modid,rev.proid,rev.status,mods.m_name,p.title,p.id,p.typeid,m.realname,m.headerurl')
                        ->from(self::TABLE.' as staff')
                        ->join(self::TABLE_REVIEW.' as rev','rev.id=staff.revid','right')
                        ->join('dw_member as m','m.id=staff.mid','left')
                        ->join('dw_mod as mods','mods.id=rev.modid','left')
                        ->join('dw_project as p','p.id=rev.proid','left')
                        ->get()->result_array();
        return $list;

    }
	public function getList1($config=array()){
		 if(!empty($config['where'])){
            $this->db->where($config['where']);
        }

        if(!empty($config['page'])){
            $this->db->limit(intval($config['limit']));
            $this->db->offset(intval($config['offset']));
        }

        if(!empty($where['where_in'])){
            $this->db->where_in($where['where_in']['key'],$where_in['where_in']['value']);
        }
		if(!empty($config['order'])){
            $this->db->order_by($config['order']['key'],$config['order']['value']);
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
	
	 public function get_count2($config = array())
    {
        if(!empty($config['where'])){
            $this->db->where($config['where']);
        }

        if(!empty($config['page'])){
            $this->db->limit(intval($config['limit']));
            $this->db->offset(intval($config['offset']));
        }
		if(!empty($config['group'])){
            $this->db->group_by($config['group']);
        }

        if(!empty($where['where_in'])){
            $this->db->where_in($where['where_in']['key'],$where_in['where_in']['value']);
        }
		if(!empty($config['order'])){
            $this->db->order_by($config['order']['key'],$config['order']['value']);
        }
		
        $list = $this->db->select('staff.*,rev.modid,rev.proid,rev.status,mods.m_name,p.title,p.id,m.realname,m.headerurl')
                        ->from(self::TABLE.' as staff')
                        ->join(self::TABLE_REVIEW.' as rev','rev.id=staff.revid','right')
                        ->join('dw_member as m','m.id=staff.mid','left')
                        ->join('dw_mod as mods','mods.id=rev.modid','left')
                        ->join('dw_project as p','p.id=rev.proid','left')
                        ->get()->result_array();
        return $list;
    }
	

    public function insert_id()
    {
        return $this->db->insert_id();
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 14-6-27
 * Time: 下午2:05
 */

class Member_group_relation_mdl extends  CI_Model
{

    const TABLE = 'dw_member_group_relation';
   // const TABLE_DEPARTMENT ='dw_department';  
	 const TABLE_MEMBER = 'dw_member';

    public function __construct()
    {
        parent::__construct();
    }

    public function getList($config = array())
    {
        if(!empty($config['where'])){
            $this->db->where($config['where']);
        }
		if(!empty($config['group'])){
            $this->db->group_by($config['group']);
        }
		if(!empty($config['order'])){
            $this->db->order_by($config['order']['key'],$config['order']['value']);
        }
        if(!empty($config['page'])){
            $this->db->limit(intval($config['limit']));
            $this->db->offset(intval($config['offset']));
        }
        $list = array();
//        $list = $this->db->select('*,(select realname from dw_member where id=mid) as realname,(select headerurl from dw_member where id=mid) as headerurl,(select integraltotal from dw_member where id=mid) as integraltotal,(select mobile from dw_member where id=mid) as mobile,(select roleid from dw_member where id=mid) as roleid')
//                ->from(self::TABLE)
//                ->get()
//                ->result_array();
		$list = $this->db->select('g.*,m.realname,m.headerurl,m.integraltotal,m.mobile,m.roleid')
                ->from(self::TABLE.' as g')
				 ->join(self::TABLE_MEMBER.' as m','m.id=g.mid','left')
                ->get()
                ->result_array();
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
		
        $news = $this->db->select('*,(select realname from dw_member where id=mid) as realname,(select headerurl from dw_member where id=mid) as headerurl,(select mobile from dw_member where id=mid) as mobile,(select roleid from dw_member where id=mid) as roleid')->order_by('id','desc')->get(self::TABLE)->row_array();
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
<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 14-6-27
 * Time: 下午2:05
 */

class Member_ex_mdl extends  CI_Model
{


    const TABLE_MEMBER_EX = 'dw_member_ex';
    const TABLE_MEMBER = 'dw_member';
    const TABLE_EXPERT = 'dw_expert';
    const TABLE_DEPARTMENT ='dw_department';  


    public function __construct()
    {
        parent::__construct();
    }

    public function getList($config)
    {
        if(!empty($config['where'])){
            $this->db->where($config['where']);
        }

        if(!empty($config['page'])){
            $this->db->limit(intval($config['limit']));
            $this->db->offset(intval($config['offset']));
        }
        $list = array();
        $list = $this->db->select('mex.*,(select realname from dw_member where id=mex.exid) as realname,(select headerurl from dw_member where id=mex.exid) as headerurl,(select mobile from dw_member where id=mex.exid) as mobile,m.createtime')
                ->from(self::TABLE_MEMBER_EX.' as mex')
                ->join(self::TABLE_MEMBER.' as m','m.id=mex.mid','left')
                ->join(self::TABLE_DEPARTMENT.' as d','d.id=m.depid','left')
                ->get()
                ->result_array();
        return $list;

    }

	public function getList1($config)
    {
        if(!empty($config['where'])){
            $this->db->where($config['where']);
        }

        if(!empty($config['page'])){
            $this->db->limit(intval($config['limit']));
            $this->db->offset(intval($config['offset']));
        }
        $list = array();
        $list = $this->db->select('mex.*,(select realname from dw_member where id=mid) as realname,(select headerurl from dw_member where id=mid) as headerurl,(select mobile from dw_member where id=mid) as mobile,(select realname from dw_member where id=mex.exid) as exrealname,(select headerurl from dw_member where id=mex.exid) as exheaderurl,(select mobile from dw_member where id=mex.exid) as exmobile,m.createtime')
                ->from(self::TABLE_MEMBER_EX.' as mex')
                ->join(self::TABLE_MEMBER.' as m','m.id=mex.mid','left')
                ->join(self::TABLE_DEPARTMENT.' as d','d.id=m.depid','left')
                ->get()
                ->result_array();

       
        //$list = $this->db->get(self::TABLE_MEMBER)->result_array();

        return $list;

    }
	
	public function getList2($config)
    {
        if(!empty($config['where'])){
            $this->db->where($config['where']);
        }

        if(!empty($config['page'])){
            $this->db->limit(intval($config['limit']));
            $this->db->offset(intval($config['offset']));
        }
        $list = array();
        $list = $this->db->select('mex.*')
                ->from(self::TABLE_MEMBER_EX.' as mex')
                ->get()
                ->result_array();
        return $list;

    }

    public function add($data){

        return $this->db->insert(self::TABLE_MEMBER_EX,$data);
    }


    public function update($where, $data){
        
        if(!empty($where)){
            $this->db->where($where);
        }

        $this->db->update(self::TABLE_MEMBER_EX, $data);

        return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
    }

    public function del($where=array())
    {
        if(!empty($where)){
            $this->db->where($where);
        }

        return $this->db->delete(self::TABLE_MEMBER_EX);
    }


    public function delall(){
        return $this->db-> truncate(self::TABLE_MEMBER_EX);
    }

    public function get_one_by_id($where)
    {
        $news = array();
        if(!empty($where)){
            $this->db->where($where);
        }
        $news = $this->db->select('*, (select username from dw_member where id=exid) as username, (select realname from dw_member where id=exid) as realname, (select headerurl from dw_member where id=exid) as headerurl ')->get(self::TABLE_MEMBER_EX)->row_array();
        return $news;
    }
	
	

	
    public function get_count($where = array())
    {

        $count = 0;
        if(!empty($where)){
            $this->db->where($where);
        }
        $count =  $this->db->count_all_results(self::TABLE_MEMBER_EX);

        return $count;
    }
}
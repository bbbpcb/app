<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 14-6-27
 * Time: 下午2:05
 */

class Invite_mdl extends  CI_Model
{



    const TABLE ='dw_invite';  
    const TABLE_PROJECT = 'dw_project';
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

        $this->db->order_by('id','desc');
        $list = array();

        $list = $this->db->get(self::TABLE)->result_array();

        return $list;

    }

    //取得用户收到的请求列表
    public function get_own_project($config = array())
    {
        $list = array();
        if(!empty($config['where'])){
            $this->db->where($config['where']);
        }
        if(!empty($config['page'])){
            $this->db->limit(intval($config['limit']));
            $this->db->offset(intval($config['offset']));
        }
         $this->db->order_by("createtime", "desc"); 
        $list = $this->db->select('i.headid,i.status as invite_status,i.pid,p.*,m.realname')
                        ->from(self::TABLE.' as i')
                        ->join(self::TABLE_PROJECT.' as p','p.id=i.pid','left')
                        ->join(self::TABLE_MEMBER.' as m','m.id=p.mid','left')                     
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
    
    //返回添加数据后的ID
    public function insert_id()
    {
        return $this->db->insert_id();
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 13-12-9
 * Time: 下午4:23
 */

class Feedback_mdl extends CI_Model
{

    const TABLE = 'dw_feedback';
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

        if($config['page']){
            $this->db->limit(intval($config['limit']));
            $this->db->offset(intval($config['offset']));
        }

        $list = array();
        $list = $this->db->select('f.*,m.realname')
                ->from(self::TABLE.' as f')
                ->join(self::TABLE_MEMBER.' as m','m.id=f.mid','left')
                ->get()->result_array();

        return $list;

    }

    public function update($where,$data)
    {
        if(!empty($where)){
            $this->db->where($where);
        }

        return $this->db->update(self::TABLE,$data);
    }

    public function add($data){

        return $this->db->insert(self::TABLE,$data);
    }

    public function del($where)
    {
        if(!empty($where)){
            $this->db->where($where);
        }

        return $this->db->delete(self::TABLE);
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
        $count =  $this->db->count_all_results(self::TABLE);

        return $count;
    }


}
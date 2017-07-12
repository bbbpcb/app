<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 14-6-27
 * Time: 下午4:09
 */

class Article_mdl extends CI_Model
{


    const TABLE = 'dw_article';



    public function __construct()
    {
        parent::__construct();

    }

    //get list
    public function getList($type = 'person',$config)
    {
        if(!empty($config['where'])){
            $this->db->where($config['where']);
        }

        if(!empty($config['page'])){
            $this->db->limit(intval($config['limit']));
            $this->db->offset(intval($config['offset']));
        }

        $list = array();
       
        $list = $this->db->get(self::TABLE)->result_array();;

        

        return $list;
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

    public function update($where, $data){
        
        if(!empty($where)){
            $this->db->where($where);
        }

        $this->db->update(self::TABLE, $data);

        return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
    }

    //删除单条信息
    public function del($where=array()){
        if(!empty($where)){
            $this->db->where($where);
        }
       
        return $this->db->delete(self::TABLE);
        
    }

    public function delall($type = 'person'){

      
        return $this->db->truncate(self::TABLE);
       
        
    }





    //get data count
    public function get_count($where = array())
    {

        $count = 0;
        
        $count = $this->db->count_all_results(self::TABLE);


        return $count;
    }


}
<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 14-6-27
 * Time: 下午2:05
 */

class Task_mdl extends  CI_Model
{



    const TABLE ='dw_task';  
    const TABLE_MOD = 'dw_mod';
    const TAABLE_PROJECT = 'dw_project';
    const TAABLE_TASK_TYPE = 'dw_task_type';


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
		
		if(!empty($config['likeand'])){
            $this->db->like($config['likeand']); 
        }
		if(!empty($config['order'])){
            $this->db->order_by($config['order']['key'],$config['order']['value']);
        }else{
        	$this->db->order_by('id','desc');
		}
        $list = array();
        $list = $this->db->select('t.*,modd.m_name,project.title as ptitle,ttype.type_name,project.typeid')
                        ->from(self::TABLE.' as t')
                        ->join(self::TABLE_MOD.' as modd','t.modid=modd.id','left')
                        ->join(self::TAABLE_PROJECT.' as project','project.id=t.proid','left')
                        ->join(self::TAABLE_TASK_TYPE.' as ttype','ttype.id=t.task_type','left')
                        ->get()->result_array();
        //$list = $this->db->get(self::TABLE)->result_array();

        return $list;

    }

    public function getCountBygroup()
    {
        $sql = "select count(*) as total,modid from dw_task GROUP BY modid";
        $query = $this->db->query($sql);
        $arr = $query->result_array();

        return $arr;
    }

	public function select($where=array()){
		if(!empty($where)){
            $this->db->where($where);
        }
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
        $news = $this->db->select('t.*,modd.m_name,project.title as ptitle,ttype.type_name')
                        ->from(self::TABLE.' as t')
                        ->join(self::TABLE_MOD.' as modd','t.modid=modd.id','left')
                        ->join(self::TAABLE_PROJECT.' as project','project.id=t.proid','left')
						 ->join(self::TAABLE_TASK_TYPE.' as ttype','ttype.id=t.task_type','left')
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

	public function get_count1($where = array())
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

    public function insert_id()
    {
        return $this->db->insert_id();
    }
}
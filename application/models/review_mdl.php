<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 14-6-27
 * Time: 下午2:05
 */

class Review_mdl extends  CI_Model
{



    const TABLE ='dw_review'; 
   



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
        /*
        $this->db->order_by('id','desc');
        $list = array();
        $list = $this->db->select('t.*,modd.m_name,project.title as ptitle')
                        ->from(self::TABLE.' as t')
                        ->join(self::TABLE_MOD.' as modd','t.modid=modd.id','left')
                        ->join(self::TAABLE_PROJECT.' as project','project.id=t.proid','left')
                        ->get()->result_array();
                        */
     
        $list = $this->db->get(self::TABLE)->result_array();

        return $list;

    }
	
	public function getList1($config=array())
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
       
        $this->db->order_by('rev.id','desc');
        $list = array();
        $list = $this->db->select('`rev`.*, `mods`.`m_name`, `p`.`title`, `p`.`id` as proid,p.typeid, `m`.`realname`, `m`.`headerurl`')
                        ->from(self::TABLE.' as rev')
                         ->join('dw_member as m','m.id=rev.mid','left')
                        ->join('dw_mod as mods','mods.id=rev.modid','left')
						->join('dw_project as p','p.id=rev.proid','left')
                        ->get()->result_array();
     
        //$list = $this->db->get(self::TABLE)->result_array();

        return $list;

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
        $news = $this->db->select('rev.*,m.realname,mods.m_name,p.title,p.headid,p.typeid')
                        ->from(self::TABLE.' as rev')
                        ->join('dw_project as p','p.id=rev.proid','left')
                        ->join('dw_member as m','m.id=p.headid','left')                      
                        ->join('dw_mod as mods','rev.modid=mods.id','left')
                        ->get()->row_array();
        //$news = $this->db->get(self::TABLE)->row_array();
        return $news;
    }
	
	
	public function get_one_by_id1($where)
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
		if(!empty($config['group'])){
            $this->db->group_by($config['group']);
        }

        if(!empty($config['page'])){
            $this->db->limit(intval($config['limit']));
            $this->db->offset(intval($config['offset']));
        }
       
        $this->db->order_by('rev.id','desc');
        $list = array();
        $list = $this->db->select('`rev`.*, `mods`.`m_name`, `p`.`title`, `p`.`id` as proid, `m`.`realname`, `m`.`headerurl`')
                        ->from(self::TABLE.' as rev')
                         ->join('dw_member as m','m.id=rev.mid','left')
                        ->join('dw_mod as mods','mods.id=rev.modid','left')
						->join('dw_project as p','p.id=rev.proid','left')
                        ->get()->result_array();
     
        //$list = $this->db->get(self::TABLE)->result_array();

        return $list;
    }
	

    public function insert_id()
    {
        return $this->db->insert_id();
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 14-6-27
 * Time: 下午2:05
 */

class Project_mdl extends  CI_Model
{



    const TABLE ='dw_project';  
    const TABLE_MEMBER ='dw_member';  
    const TAABLE_TYPE = 'dw_project_type';
	const TAABLE_Review = 'dw_review';
	const TAABLE_Invite = 'dw_invite';
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
        	$this->db->order_by('p.id','desc');
		}
        $list = $this->db->select('p.*,m.realname,m2.realname as header,m.roleid,i.status as invitestatus')
                ->from(self::TABLE.' as p')
                ->join(self::TABLE_MEMBER.' as m','m.id=p.mid','left')
                ->join(self::TABLE_MEMBER.' as m2','m2.id=p.headid','left')
				 ->join(self::TAABLE_Invite.' as i','i.pid=p.id','left')
                ->get()->result_array();
       // $this->$list = $this->db->get(self::TABLE)->result_array();

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

        $news = $this->db->select('p.*,m.realname,m.headerurl,m2.realname as header,m.roleid')
                        ->from(self::TABLE.' as p')
                        ->join(self::TABLE_MEMBER.' as m','m.id=p.mid','left')
                        ->join(self::TABLE_MEMBER.' as m2','m2.id=p.headid','left')
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
		if(!empty($where['likeand'])){
            $this->db->like($where['likeand']); 
        }
        $count =  $this->db->count_all_results(self::TABLE);

        return $count;
    }
	
	 public function get_count1($where = array())
    {
        $count = 0;
        if(!empty($where)){
            $this->db->where($where);
        }
         $count = $this->db->select('p.*,m.realname,m2.realname as header,m.roleid,i.status as invitestatus')
                ->from(self::TABLE.' as p')
                ->join(self::TABLE_MEMBER.' as m','m.id=p.mid','left')
                ->join(self::TABLE_MEMBER.' as m2','m2.id=p.headid','left')
				 ->join(self::TAABLE_Invite.' as i','i.pid=p.id','left')
                ->count_all_results();
        //$count =  $this->db->count_all_results(self::TABLE);
		//$count=count($list);
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
	
	
	public function get_sum($where = array())
    {
		if(!empty($where['sum'])){
			$this->db->select_sum($where['sum']);
		}
        
        if(!empty($where['where'])){
            $this->db->where($where['where']);
        }
        $count =  $this->db->from(self::TABLE)->get()->row_array();
		if(empty($count['features'])){
			return 0;
		}
       	return $count['features'];
    }
	
	public function get_sum1($where = array())
    {
		if(!empty($where['sum'])){
			$this->db->select_sum($where['sum']);
		}
        
        if(!empty($where['where'])){
            $this->db->where($where['where']);
        }
		if (!empty($where['wherein'])) { 
            $this->db->where_in('p.id',$where['wherein']);  
        }
        $count =  $this->db
					->from(self::TABLE.' as p')
					->join(self::TABLE_MEMBER.' as m','m.id=p.mid','left')
					->get()->row_array();
		if(empty($count['difficulty'])){
			return 0;
		}
       	return $count['difficulty'];
    }

    //返回添加数据后的ID
    public function insert_id()
    {
        return $this->db->insert_id();
    }
	
	public function get_all($where = array())
    {
		if(!empty($where['sum'])){
			$this->db->select_sum($where['sum']);
		}
        if(!empty($where['where'])){
            $this->db->where($where['where']);
        }
		if (!empty($where['wherein'])) { 
            $this->db->where_in('p.id',$where['wherein']);  
        }
        $list =  $this->db
					->from(self::TABLE.' as p')
					->join(self::TABLE_MEMBER.' as m','m.id=p.mid','left')
					->get()->result_array();
		
       	return $list;
    }
	
}
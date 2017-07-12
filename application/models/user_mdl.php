<?php


/**
 * 会员model
 *
 */

class User_mdl extends CI_Model
{

    //表名
    const TBL_USER = 'dw_user';



    public function __construct()
    {
        parent::__construct();
    }

	public function getList($config=array())
    {
        if(!empty($config['where'])){
            $this->db->where($config['where']);
        }
		if(!empty($config['likeand'])){
            $this->db->like($config['likeand']); 
        }
        if(!empty($config['page'])){
            $this->db->limit(intval($config['limit']));
            $this->db->offset(intval($config['offset']));
        }
        $list = array();
        $list = $this->db->get(self::TBL_USER)->result_array();

        return $list;

    }

    /**
     * 获取单个用户信息
     *
     * @access public
     * @param int $uid 用户id
     * @return array - 用户信息
     */
    public function get_user_by_id($id)
    {
        $data = array();

        $this->db->select('*')->from(self::TBL_USER)->where('id', $id)->limit(1);
        $query = $this->db->get();
        if($query->num_rows() == 1)
        {
            $data = $query->row_array();
        }
        $query->free_result();

        return $data;
    }
	
	
	public function get_one_by_id($where)
    {
        $news = array();
        if(!empty($where)){
            $this->db->where($where);
        }

        $news = $this->db->get(self::TBL_USER)->row_array();
        return $news;
    }

    /**
     * 获取会员信息
     * @access public
     * @param string txnikename
     * @return array - 会员信息
     */

    public function get_user_by_username($username)
    {
        $data = array();
        $this->db->select('id,username,pwd,email,end_time,roleid')->from(self::TBL_USER)->where('username', $username)->limit(1);
        $query = $this->db->get();
        if($query->num_rows() == 1)
        {
            $data = $query->row_array();
        }
        $query->free_result();

        return $data;
    }

    /**
     * 检查用户是否通过验证
     *
     * @access public
     * @param string - $name 用户名
     * @param string - $password 密码
     * @return mixed - FALSE/uid
     */
    public function validate_user($username, $password)
    {
        $data = FALSE;

        $this->db->where('username', $username);
        $query = $this->db->get(self::TBL_USER);

        if($query->num_rows() == 1)
        {
            $data = $query->row_array();
        }

        if(!empty($data))
        {
            $data = (Common::hash_Validate($password, $data['tbpassword'])) ? $data : FALSE;
        }

        $query->free_result();

        return $data;
    }


    /**
     * add user
     */

    public function add_user($user)
    {
        $this->db->insert(self::TBL_USER,$user);
        return ($this->db->affected_rows()==1) ? $this->db->insert_id() : FALSE;
    }




    /**
     * 修改用户信息
     *
     * @access public
     * @param int - $uid 用户ID
     * @param int - $data 用户信息
     * @param int - $cipher_password 密码是否hash
     * @return boolean - success/failure
     */
    public function update_user($where, $data, $hashed = TRUE)
    {
        if(!$hashed)
        {
            $data['pwd'] = Common::do_hash($data['pwd']);
        }

        if(!empty($where)){
            $this->db->where($where);
        }
        //$this->db->where('id', intval($uid));
        $this->db->update(self::TBL_USER, $data);

        return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
    }

	
	 public function add($data){

        return $this->db->insert(self::TBL_USER,$data);
    }



    /**
     * 密码重置,生成token
     * @param aray $user - 用户信息(txnikename,id)
     * @return void
     */

    public function set_reset_password($user)
    {
        $data['token'] = Common::do_hash('reset_'.$user['id'].time());
        $data['uid'] =   $user['id'];
        $data['txemail'] = $user['txemail'];
        $this->db->insert('tb_resetpassword', $data);
        return ($this->db->affected_rows() > 0) ? $data : FALSE;
    }

    public function update($config,$data)
    {

        return $this->db->update(self::TBL_USER, $data, $config);
        
    }

    /**
     *
     * 取得member数 ...
     * @return int num
     */

    public function get_member_count($tp)
    {
        $count = 0;
        if(!empty($tp) ){
            $this->db->where('tbtype',$tp);
        }
        $count =  $this->db->count_all_results(self::TBL_MEMBERS);
        return $count;
    }

    /**
     *
     * 检查用户名是否存在 ...
     */

    function checkusername($tbnikename)
    {
        $query = $this->db->where('username',$tbnikename)->get(self::TBL_USER)->num_rows();

        return $query;


    }

    /*
    * 检查证件号是否存在 ...
    */

    function checkidcard($idcard)
    {
        $query = $this->db->where('jigoudaima',$idcard)->get(self::TBL_MEMBERS)->num_rows();

        return $query;


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
        $count =  $this->db->count_all_results(self::TBL_USER);

        return $count;
    }
	
	 public function del($where=array())
    {
        if(!empty($where)){
            $this->db->where($where);
        }

        return $this->db->delete(self::TBL_USER);
    }


}
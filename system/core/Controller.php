<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP 5.1.6 or newer
 *
 * @package		CodeIgniter
 * @author		ExpressionEngine Dev Team
 * @copyright	Copyright (c) 2008 - 2011, EllisLab, Inc.
 * @license		http://codeigniter.com/user_guide/license.html
 * @link		http://codeigniter.com
 * @since		Version 1.0
 * @filesource
 */

// ------------------------------------------------------------------------

/**
 * CodeIgniter Application Controller Class
 *
 * This class object is the super class that every library in
 * CodeIgniter will be assigned to.
 *
 * @package		CodeIgniter
 * @subpackage	Libraries
 * @category	Libraries
 * @author		ExpressionEngine Dev Team
 * @link		http://codeigniter.com/user_guide/general/controllers.html
 */


class CI_Controller {

	private static $instance;

	/**
	 * Constructor
	 */
	public function __construct()
	{
		self::$instance =& $this;
		
		// Assign all the class objects that were instantiated by the
		// bootstrap file (CodeIgniter.php) to local class variables
		// so that CI can run as one big super object.
		foreach (is_loaded() as $var => $class)
		{
			$this->$var =& load_class($class);
		}

		$this->load =& load_class('Loader', 'core');

		$this->load->initialize();
		
		log_message('debug', "Controller Class Initialized");
	}

	public static function &get_instance()
	{
		return self::$instance;
	}

    /**
     * load widget class if isset $name and called widget() in controller class
     * @param string $name
     */
    protected function widget($name = '')
    {
        if (isset($name) && $name != '')
        {
            require_once APPPATH.'widgets/'.$name.EXT;
        }
    }




}


class Base_Controller extends CI_Controller
{
    var $memberinfo = array();

    public function __construct()
    {
        parent::__construct();
         $this->widget('widget');

    }

    protected function Widget($name = '')
    {


        if (isset($name) && $name != '')
        {
            require_once APPPATH.'widgets/'.$name.EXT;
        }

    }

    public function getMemberinfo(){
        $token = $this->session->userdata('member');
        if(!empty($token)){
            return $token;
        }
    }

    public function checkmember($lang,$url)
    {
        $token = $this->getMemberinfo();
        
        if(empty($token)){
            redirect(base_url().'index.php?c=signin&lang='.$lang.'&redurl='.$url);
        }
    }



}

class Admin_Controller extends CI_Controller
{

    public $userinfo = array();
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->Widget('widget');
        $this->checkLogin();
    }

    public function checkLogin()
    {
        $token = $this->session->userdata('token');
   
        if(empty($token)){
            redirect('d=home&c=login');
        }

        $this->userinfo = $token;
    }

    protected function Widget($name = '')
    {


        if (isset($name) && $name != '')
        {

            require_once APPPATH.'widgets/'.$name.EXT;

        }


    }
}



// END Controller class

/* End of file Controller.php */
/* Location: ./system/core/Controller.php */
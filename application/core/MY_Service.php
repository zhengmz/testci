<?php  if ( ! defined('APPPATH')) exit('No direct script access allowed');

/**
 * My Service Class
 *
 * @package		MY_Service
 * @subpackage		core
 * @category		core
 * @author		zhengmz
 * @link		http://codeigniter.com/user_guide/libraries/config.html
 */
class MY_Service
{
	/**
	 * Constructor
	 *
	 * @access public
	 */
	public function __construct()
	{
		log_message('debug', "MY_Service Class Initialized");
	}

	/**
	 * __get
	 *
	 * Allows models to access CI's loaded classes using the same
	 * syntax as controllers.
	 *
	 * @param	string
	 * @access private
	 */
	function __get($key)
	{
		$CI =& get_instance();
		return $CI->$key;
	}
}
// END MY_Service Class

/* End of file MY_Service.php */
/* Location: ./application/core/MY_Service.php */

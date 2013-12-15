<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * My Loader Class
 *
 * @package		MyCore
 * @subpackage		Libraries
 * @category		Libraries
 * @author		zhengmz
 * @link		http://codeigniter.com/user_guide/libraries/config.html
 */
class MY_Loader extends CI_Loader {

	/**
	 * List of paths to load services from
	 *
	 * @var array
	 * @access protected
	 */
	protected $_ci_service_paths		= array();
	/**
	 * List of loaded services
	 *
	 * @var array
	 * @access protected
	 */
	protected $_ci_services			= array();


	/**
	 * Constructor
	 *
	 * @access public
	 */
	public function __construct()
	{
		$this->_ci_service_paths = array(APPPATH);
		$this->_ci_services = array();
		parent::__construct();

		log_message('debug', "MY_Loader Class Initialized");
	}

/*
	public function initialize()
	{
		$this->_ci_services = array();

		parent::initialize();
		return $this;
	}
*/

	/**
	 * Service Loader
	 *
	 * This function lets users load and instantiate services.
	 *
	 * @param	string	the name of the service
	 * @param	mixed	the optional parameters
	 * @param	string	an optional object name
	 * @return	void
	 */
	public function service($service = '', $object_name = NULL)
	{
		if (is_array($service))
		{
			foreach ($service as $class)
			{
				$this->service($class);
			}

			return;
		}


		if ($service == '')
		{
			return;
		}

		$subpath = '';

		// Is the service in a sub-folder? If so, parse out the filename and path.
		if (($last_slash = strrpos($service, '/')) !== FALSE)
		{
			// The path is in front of the last slash
			$subpath = substr($service, 0, $last_slash + 1);

			// And the service name behind it
			$service = substr($service, $last_slash + 1);
		}

		if ($object_name == '')
		{
			$object_name = $service;
		}

		if (in_array($object_name, $this->_ci_services, TRUE))
		{
			return;
		}

		$CI =& get_instance();
		if (isset($CI->$object_name))
		{
			show_error('The service name you are loading is the name of a resource that is already being used: '.$object_name);
		}

		$service = strtolower($service);
		foreach ($this->_ci_service_paths as $mod_path)
		{
			$service_full_path = $mod_path.'services/'.$subpath.$service.'.php';

			if ( ! file_exists($service_full_path))
			{
				continue;
			}

			if ( ! class_exists('CI_Service'))
			{
				load_class('Service', 'core');
			}

			require_once($service_full_path));

			$service = ucfirst($service);

			$CI->$object_name = new $service();

			$this->_ci_services[] = $object_name;
			return;
		}

		// couldn't find the service
		show_error('Unable to locate the service you have specified: '.$service);
	}
 
}
// END MY_Loader Class

/* End of file MY_Loader.php */
/* Location: ./application/core/MY_Loader.php */

<?php  if ( ! defined('APPPATH')) exit('No direct script access allowed');

/**
 *	负责处理一些与weixin相关的服务
 *
 *	@package	Wx_serv
 *	@subpackage	Services
 *	@category	API
 *	@author		zhengmz
 *	@link		null
 */

class Wx_serv extends MY_Service
{
	public function __construct()
	{
		parent::__construct();
		log_message('debug', "wx_serv Services Initialized");
	}

}

/* End of file wx_serv.php */
/* Location: ./application/services/wx_serv.php */

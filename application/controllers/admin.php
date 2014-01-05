<?php  if ( ! defined('APPPATH')) exit('No direct script access allowed');

/**
 * My application admin
 *
 * @package		My Application
 * @subpackage		Libraries
 * @category		Libraries
 * @author		zhengmz
 * @link		http://mp.weixin.qq.com/wiki/index.php?title=接入指南
 */
class Admin extends CI_Controller {

	/**
	 * 构造函数
	 */
	public function __construct()
	{
		parent::__construct();
		
		log_message('debug', "admin Controller Initialized");
	}

	public function index()
	{
		$output['usage'] = '支持的命令有';
		$data = array(
			'output' = $output,
			'title' = '管理页面',
			);
		$this->load->view('base_view', $data);
	}

	public function display_log($log = '')
	{
		if ($log === '')
		{
			$this->load->helper('date');
			$log = 'log-'.mdate('%Y-%m-%d', time());
		}
		else
		{
			$log = 'log-'.(string) $log;
		}

		$log = APPPATH.'/logs/'.$log.'.php';
		$output['log'] = $log;
		if ( ! file_exists($log))
		{
			$output['ret'] = 'file not exists!';
		}
		else
		{
			$this->load->helper('file');
			$output['log-content'] = read_file($log);
		}
		$data = array(
			'output' = $output,
			'title' = '日志信息',
			);
		$this->load->view('base_view', $data);
	}
}

/* End of file wx_home.php */
/* Location: ./application/controllers/wx_home.php */

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

	public function plog($param = '')
	{
		if ($param === '')
		{
			$this->load->helper('date');
			$param = 'log-'.mdate('%Y-%m-%d', time());
		}
		else
		{
			$param = 'log-'.(string) $param;
		}

		$log_file = APPPATH.'/logs/'.$param.'.php';
		$output['log'] = $log_file;
		if ( ! file_exists($log_file))
		{
			$output['ret'] = 'file not exists!';
		}
		else
		{
			$this->load->helper('file');
			$output['log-content'] = read_file($log_file);
		}
		$data = array(
			'output' = $output,
			'title' = '日志信息',
			);
		$this->load->view('base_view', $data);
	}
}

/* End of file app_admin.php */
/* Location: ./application/controllers/app_admin.php */

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
			'output' => $output,
			'title' => '管理页面',
			);
		$this->load->view('base_view', $data);
	}

	public function cache()
	{
		$cache = APPPATH.'cache/';
		$output['cache'] = $cache;
		$this->load->helper('file');
		$output['cache item'] = get_dir_file_info($cache);

		$data = array(
			'output' => $output,
			'title' => '应用缓存（文件类型）',
			);
		$this->load->view('base_view', $data);
	}

	public function log($date = '')
	{
		if ($date === '')
		{
			$this->load->helper('date');
			$date = 'log-'.mdate('%Y-%m-%d', time());
		}

		$output['date'] = (string) $date;
		$log_file = APPPATH.'logs/log-'.$date.'.php';
		$output['log'] = $log_file;
		if ( ! file_exists($log_file))
		{
			$output['ret'] = 'file not exists!';
		}
		else
		{
			$output['ret'] = 'file exists!';
			//$output['log-content'] = $this->load->file($log_file, TRUE);
			$this->load->helper('file');
			$output['log-content'] = read_file($log_file, TRUE);
		}

		$data = array(
			'output' => $output,
			'title' => '应用日志',
			);
		$this->load->view('base_view', $data);
	}
}

/* End of file admin.php */
/* Location: ./application/controllers/admin.php */

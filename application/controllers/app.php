<?php  if ( ! defined('APPPATH')) exit('No direct script access allowed');

/**
 * 应用控制器
 * 主要作为APP应用的后台入门程序
 *
 * @package		Application
 * @subpackage		Controller
 * @category		App
 * @author		zhengmz
 * @link		
 */
class App extends CI_Controller {

	/**
	 * 构造函数
	 */
	public function __construct()
	{
		parent::__construct();
		
		log_message('debug', "App Controller Initialized");
		$params = array(
			'table_name' => 'users',
			'primary_key' => 'id',
			'db_name' => 'app'
		);
		$this->load->model('base_model', $params, 'users');
		$params = array(
			'table_name' => 'actions',
			'primary_key' => 'to',
			'db_name' => 'app'
		);
		$this->load->model('base_model', $params, 'actions');
	}

	/**
	 * 默认接入函数
         * 使用GET方法，参数如下：
	 * m  : method = c(create) | s(send) | r(receive)
	 * u  : user name
	 * f  : from
         * t  : to
         * tm : datetime
	 */
	public function index()
	{
		$input = $this->input->get();
		
		$err_code = 0;
		$msg = '';
		switch ($input['m'])
		{
		case 'c':
			if (($id = $input['f']) === FALSE || ($name = $input['u']) === FALSE)
			{
				$err_code = -11;
			}
			$msg = 'create user';
			break;
		case 's':
			$ip = $this->input->ip_address();
			$msg = 'send';
			break;
		case 'r':
			$msg = 'receive';
			break;
		default:
			$err_code = -1;
			$msg = 'unknown command!';
			break;
		}

		echo '<pre>';
		print_r($input);

		$ret = array(
			'errno' => $err_code,
			'msg' => $msg
		);
		echo json_encode($ret);
	}

}

/* End of file app.php */
/* Location: ./application/controllers/app.php */

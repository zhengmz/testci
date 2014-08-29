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
	}

	/**
	 * 默认接入函数
         * 使用GET方法，参数如下：
	 * m  : method = c(create) | s(send) | r(receive)
	 * f  : from
         * t  : to
	 * u  : user name
	 * tm : update time, optional
	 * 使用例子：
	 *	创建用户: app?m=c&f=13812345678&u=oscar
	 *	发送动作: app?m=s&f=13812345678&t=13987654321&tm=2014-08-21%2014:20:30
	 *	接收动作: app?m=r&f=13812345678
	 */
	public function index()
	{
		$input = $this->input->get();
		
		$err_code = 0;
		$msg = '';
		$ret_flag = TRUE;

		switch ($input['m'])
		{
		case 'c': //创建用户
			$msg = 'create user OK.';
			if (!isset($input['f']) or !isset($input['u']))
			{
				$err_code = -11;
				$msg = 'Please input user info.';
				log_message('debug', $msg);
				break;
			}

			//加载数据库
			$params = array(
				'table_name' => 'users',
				'primary_key' => 'id',
				'db_name' => 'app'
			);
			$this->load->model('base_model', $params, 'users');

			//查重
			$ret = $this->users->find_by_pk($input['f']);
			if ( ! empty( $ret ) )
			{
				$err_code = -12;
				$msg = 'user have been exist.';
				log_message('debug', $msg);
				break;
			}

			$rec = array(
				'id' => $input['f'],
				'user_name' => $input['u']
			);

			//保存
			if ( $this->users->save($rec) === FALSE )
			{
				$err_code = -13;
				$msg = 'create user ['.$rec['id'].'] failed.';
				log_message('debug', $msg);
				break;
			}
			break;
		case 's':	//发送动作
			$msg = 'send OK.';
			if (!isset($input['f']) or !isset($input['t']))
			{
				$err_code = -21;
				$msg = 'Please input from and to.';
				log_message('debug', $msg);
				break;
			}

			//加载数据库
			$params = array(
				'table_name' => 'actions',
				'primary_key' => 'to',
				'db_name' => 'app'
			);
			$this->load->model('base_model', $params, 'actions');

			$rec = array(
				'id_from' => $input['f'],
				'id_to' => $input['t'],
				'ip_addr' => $this->input->ip_address()
			);

			//如果传时间过来就记录下来
			if ( isset($input['tm']) )
			{
				$rec['update_tm'] = $input['tm'];
			}

			//保存
			if ( $this->actions->save($rec) === FALSE )
			{
				$err_code = -22;
				$msg = 'send from ['.$rec['from'].'] failed.';
				log_message('debug', $msg);
				break;
			}
			break;
		case 'r':	//接收动作
			$msg = 'receive OK.';
			if ( !isset($input['f']) )
			{
				$err_code = -31;
				$msg = 'Please input from.';
				log_message('debug', $msg);
				break;
			}

			//加载数据库: 用户表和动作表
			$params = array(
				'table_name' => 'actions',
				'primary_key' => 'to',
				'db_name' => 'app'
			);
			$this->load->model('base_model', $params, 'actions');
			$params = array(
				'table_name' => 'users',
				'primary_key' => 'id',
				'db_name' => 'app'
			);
			$this->load->model('base_model', $params, 'users');

			$id = $input['f'];
			$curr_tm = date('Y-m-d H:i:s');
			$last_tm = '';

			//先从users中获取上次读取时间, 并更新最新时间
			$ret = $this->users->find_by_pk($id);
			if ( empty( $ret ) )	//如果未登记，先保存
			{
				$rec = array(
					'id' => $input['f'],
					'user_name' => $input['f']
				);

				if ( $this->users->save($rec) === FALSE )
				{
					$err_code = -32;
					$msg = 'create user ['.$rec['id'].'] failed.';
					log_message('debug', $msg);
					break;
				}
			}
			else 
			{
				$last_tm = $ret['last_tm'];
				//更新最新时间
				$attr = array(
					'last_tm' => $curr_tm
				);
				if ( $this->users->update_by_pk($id, $attr) === FALSE )
				{
					$err_code = -33;
					$msg = 'update last_tm failed.';
					log_message('debug', $msg);
					break;
				}
			}

			//根据前后时间获取动作列表
			$where = array(
				'id_to' => $id,
				'update_tm <=' => $curr_tm
			);
			if ( $last_tm != '')
			{
				$where['update_tm >'] = $last_tm;
			}

			$count = 0;
			$data = array('count' => 0);
			$ret = $this->actions->find_all($where, 0, 0,'update_tm ASC');
			foreach ($ret as $row)
			{
				$data[] = array(
					'f' => $row['id_from'],
					'tm' => $row['update_tm']
				);
				$count ++;
			}
			$data['count'] = $count;

			echo json_encode($data);
			$ret_flag = FALSE;

			break;
		case 'a':	//管理端口
			//加载数据库: 用户表和动作表
			$params = array(
				'table_name' => 'actions',
				'primary_key' => 'to',
				'db_name' => 'app'
			);
			$this->load->model('base_model', $params, 'actions');
			$params = array(
				'table_name' => 'users',
				'primary_key' => 'id',
				'db_name' => 'app'
			);
			$this->load->model('base_model', $params, 'users');
			echo '<pre>';
			$count = $this->users->count();
			echo '用户总数是: '.$count;
			if ( $count > 0 )
			{
				$users = $this->users->find_all();
				echo PHP_EOL.'用户信息如下: '.PHP_EOL;
				print_r($users);
			}
			$count = $this->actions->count();
			echo PHP_EOL.'动作总数是: '.$count;
			if ( $count > 0 )
			{
				$actions = $this->actions->find_all();
				echo PHP_EOL.'动作列表如下: '.PHP_EOL;
				print_r($actions);
			}
			$ret_flag = FALSE;
			break;
		default:
			$err_code = -1;
			$msg = 'unknown command!';
			break;
		}

//		echo '<pre>';
//		print_r($input);

		if ( $ret_flag )
		{
			$ret = array(
				'errno' => $err_code,
				'msg' => $msg
			);
			echo json_encode($ret);
		};
	}
}

/* End of file app.php */
/* Location: ./application/controllers/app.php */

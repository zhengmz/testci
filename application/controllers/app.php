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

		//加载数据库
		//用户表
		$params = array(
			'table_name' => 'users',
			'primary_key' => 'id',
			'db_name' => 'app'
		);
		$this->load->model('base_model', $params, 'users');

		//动作表
		$params = array(
			'table_name' => 'actions',
			'primary_key' => 'to',
			'db_name' => 'app'
		);
		$this->load->model('base_model', $params, 'actions');
		
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
	 *	查询用户: app?m=q&f=13812345678
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
			if ( !isset($input['f']) )
			{
				$err_code = -11;
				$msg = 'Please input user info.';
				log_message('debug', $msg);
				break;
			}

			$id = $this->_trim_phone($input['f']);
			//查重
			$ret = $this->users->find_by_pk($id);
			if ( ! empty( $ret ) )
			{
				$err_code = -12;
				$msg = 'user have been exist.';
				log_message('debug', $msg);
				break;
			}

			$rec = array(
				'id' => $id,
				'user_name' => $id
			);

			//传昵称过来就记录下来
			if ( isset($input['u']) )
			{
				$rec['user_name'] = trim($input['u']);
			}

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

			$from_id = $this->_trim_phone($input['f']);
			$to_id = $this->_trim_phone($input['t']);
			$rec = array(
				'id_from' => $from_id,
				'id_to' => $to_id,
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

			$id = $this->_trim_phone($input['f']);
			//$id = $input['f'];
			$curr_tm = date('Y-m-d H:i:s');
			log_message('debug', 'current time is ['.$curr_tm.']');
			$last_tm = '';

			//先从users中获取上次读取时间, 并更新最新时间
			$ret = $this->users->find_by_pk($id);
			if ( empty( $ret ) )	//如果未登记，先保存
			{
				$rec = array(
					'id' => $id,
					'user_name' => $id
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
					'tm' => substr($row['update_tm'], 0, strlen($row['update_tm'])-3)
				);
				$count ++;
			}
			$data['count'] = $count;

			echo json_encode($data);
			$ret_flag = FALSE;

			break;
		case 'q':	//查询功能
			$msg = 'Query user OK.';
			if ( !isset($input['f']) )
			{
				$err_code = -41;
				$msg = 'Please input userid.';
				log_message('debug', $msg);
				break;
			}
			
			//查询
			$id = $this->_trim_phone($input['f']);
			$ret = $this->users->find_by_pk($id);
			if ( ! empty( $ret ) )   //存在
			{
				$err_code = 1;
				$msg = 'User is exist!';
			}
			else	//不存在
			{
				$err_code = 0;
				$msg = 'User is not exist!';
			}
			break;
		case 'a':	//管理端口
			//先处理表格数据清除工作
			$del_t = isset($input['del']) ? $input['del'] : '';
			if ($del_t === 'users' or $del_t === 'actions')
			{
				$sql = 'delete from '.$del_t;
				$this->users->exec($sql);
			}
			$this->load->helper(array('html','url'));
			$this->load->library('table');
			if ( $this->users->count() > 0 )
			{
				$this->table->set_heading(array('id', 'Name', 'Update_tm', 'Last_tm'));
				$tmpl = array('table_open'  => '<table border="1" cellpadding="3" cellspacing="0">');
				$this->table->set_template($tmpl);
				$users = $this->users->find_all();
				$del_str = '<a href="'.base_url('app?m=a&del=users').'">清除数据</a>'.br();
				$output['用户表'] = $del_str.$this->table->generate($users);
			}
			else
			{
				$output['用户表'] = 0;
			}
			if ( $this->actions->count() > 0 )
			{
				$this->table->clear();
				$this->table->set_heading(array('From', 'To', 'Action', 'Update_tm', 'IP'));
				$tmpl = array('table_open'  => '<table border="1" cellpadding="3" cellspacing="0">');
				$this->table->set_template($tmpl);
				$actions = $this->actions->find_all();
				$del_str = '<a href="'.base_url('app?m=a&del=actions').'">清除数据</a>'.br();
				$output['动作表'] = $del_str.$this->table->generate($actions);
			}
			else
			{
				$output['动作表'] = 0;
			}
			$data = array(
				'output' => $output,
				'title' => '数据库信息',
				);
			$this->load->view('base_view', $data);
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

	protected function _trim_phone($phone)
	{
		$phone = trim($phone);
		$phone = str_replace('-', '' ,$phone);
		if ( preg_match('/^86[0-9]*/', $phone) )
		{
			$phone = substr($phone, 2);
		}
		return $phone;
	}
}

/* End of file app.php */
/* Location: ./application/controllers/app.php */

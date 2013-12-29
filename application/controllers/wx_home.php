<?php  if ( ! defined('APPPATH')) exit('No direct script access allowed');

/**
 * 微信控制器
 *
 * @package		Wx_home
 * @subpackage		Libraries
 * @category		Libraries
 * @author		zhengmz
 * @link		http://mp.weixin.qq.com/wiki/index.php?title=接入指南
 */
class Wx_home extends CI_Controller {

	/**
	 * 构造函数
	 */
	public function __construct()
	{
		parent::__construct();
		
		$this->load->library('wx_api');
		log_message('debug', "Wx_home Controller Initialized");
	}

	/**
	 * 默认接入函数
	 */
	public function index()
	{
		$this->load->library('weixin');

		$post_arr = $this->weixin->msg_arr();
		if (empty($post_arr))
		{
			echo "Cannot get post data from wechat!";
			exit;
		}

		if ($post_arr['MsgType'] == 'text')
		{
			$from = $this->wx_api->get_user_info($post_arr['FromUserName'])->nickname;
			$respone_str = $from.', 你好! '.chr(13).chr(10);
			$respone_str .= '你的消息是: ['.$post_arr['Content'].'].';
			$data = array(
				'to' => $post_arr['FromUserName'],
				'from' => $post_arr['ToUserName'],
				'time' => time(),
				'type' => 'text',
				//'type' => '',
				'content' => $respone_str
			);
			$this->load->view('weixin/text', $data);
		}
	}

	public function action($action = '')
	{
		switch (strtoupper($action))
		{
		case 'USER':
			$user_1 = $this->wx_api->get_user_info('oepyJt6gXLGhAniv2Z33xfaYFNUE');
			echo '<p>receive user 1: </p>';
			print_r($user_1);
			echo '<p>user 1: '.$user_1->nickname.'</p>';
			$user_2 = $this->wx_api->get_user_info('abcd');
			echo '<p>receive user 2: </p>';
			print_r($user_2);
			echo '<p>user 2: '.$user_2->nickname.'</p>';
			echo '<p>errormsg: '.$user_2->errcode.'-'.$user_2->errmsg.'</p>';
			break;
		case 'GET_MENU':
			echo '<pre>';
			print_r($this->wx_api->get_menu());
			echo '</pre>';
			break;
		case 'CREATE_MENU':
			$sub_menu = array(
				array(
					'type' => 'click',
					'name' => '注册/登入',
					'key' => 'V301'
					),
				array(
					'type' => 'click',
					'name' => '会员信息',
					'key' => 'V302'
					),
				array(
					'type' => 'click',
					'name' => '订单查询',
					'key' => 'V303'
					),
				array(
					'type' => 'click',
					'name' => '使用手册',
					'key' => 'V304'
					),
				array(
					'type' => 'click',
					'name' => '问题申告',
					'key' => 'V305'
					)
				);
			$menu = array(
				array(
					'type' => 'click',
					'name' => '最新优惠',
					'key' => 'V100'
					),
				array(
					'type' => 'click',
					'name' => '产品购买',
					'key' => 'V200'
					),
				array(
					'name' => '会员服务',
					'sub_button' => $sub_menu
					)
				);
				
			$menu = array('button' => $menu);
			echo '<pre>';
			print_r($menu);
			echo '</pre>';
			echo '<pre>';
			echo 'ret: ';
			$ret = $this->wx_api->create_menu($menu);
			print_r($ret);
			echo '</pre>';
			break;
		default:
			echo "<p>请输入你所需要的操作</p>";
			echo "<p>目前支持的功能有:</p>";
			echo "<p>user -- 获取用户信息</p>";
			echo "<p>menu -- 创建菜单</p>";
			print_r(get_object_vars($this->wx_api));
		}
		
	}
}

/* End of file wx_home.php */
/* Location: ./application/controllers/wx_home.php */

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
		
		log_message('debug', "Wx_home Controller Initialized");
		$this->load->library('wx_api');
	}

	/**
	 * 默认接入函数
	 */
	public function index()
	{
		$this->load->library('weixin');

		$type = $this->weixin->get('MsgType');
		$from = $this->weixin->get('FromUserName');
		$nickname = $this->wx_api->get_user_info($from)->nickname;
		$response = $nickname.', 你好! '.chr(13).chr(10);
		switch (strtoupper($type))
		{
		case 'TEXT':
			$response .= '你的消息是: ['.$this->weixin->get('Content').']';
			break;
		case 'VOICE':
			$response .= '你的语音消息是: ['.$this->weixin->get('Recognition').']';
			break;
		case 'LINK':
			$response .= '你发过来的链接是: ['.$this->weixin->get('Url').']';
			break;
		case 'LOCATION':
			$response .= vsprintf('你的位置在：X[%s], Y[%s], 缩放[%s], 位置信息[%s]', $this->weixin->get(array('Location_X', 'Location_Y', 'Scale', 'Label')));
			break;
		case 'EVENT':
			$event = $this->weixin->get('Event');
			switch (strtoupper($event))
			{
			// 地理位置
			case 'LOCATION':
				$response .= vsprintf('你的位置在：纬度[%s], 经度[%s], 精度[%s]', $this->weixin->get(array('Latitude', 'Longitude', 'Precision')));
				break;
			// 订阅
			case 'SUBSCRIBE':
				$response .= '欢迎光临小店，我们将竭诚为您服务!';
				break;
			// 取消订阅
			case 'UNSUBSCRIBE':
				$response .= '欢迎再次光临!';
				break;
			// 重新扫描进来
			case 'SCAN':
				$response .= '欢迎回来，我们将竭诚为您服务!';
				break;
			// 菜单点击
			case 'CLICK':
				$response .= sprintf('你点中的菜单项是[%s].', $this->weixin->get('EventKey'));
				break;
			default:
				$response = '暂不支持['.$event.']事件，我们将很快就会推出相关功能';
			}
			break;
		default:
			$response = '暂不支持['.$type.']类型，我们将很快就会推出相关功能';
		}

		$data = array(
			'to' => $from,
			'from' => $this->weixin->get('ToUserName'),
			'time' => time(),
			'type' => 'text',
			//'type' => '',
			'content' => $response
		);
		$this->load->view('weixin/text', $data);
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
			$user_2 = $this->wx_api->get_user_info('abc');
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
		case 'DEL_MENU':
			echo '<pre>';
			print_r($this->wx_api->del_menu());
			echo '</pre>';
			break;
		case 'CREATE_MENU':
			$sub_menu = array(
				array(
					'type' => 'click',
					'name' => '注册/登入',
					'key' => 'M301_BIND'
					),
				array(
					'type' => 'click',
					'name' => '会员信息',
					'key' => 'M302_USER'
					),
				array(
					'type' => 'click',
					'name' => '订单查询',
					'key' => 'M303_ORDER'
					),
				array(
					'type' => 'click',
					'name' => '使用手册',
					'key' => 'M304_HELP'
					),
				array(
					'type' => 'click',
					'name' => '问题申告',
					'key' => 'M305_FAQ'
					)
				);
			$menu = array(
				array(
					'type' => 'click',
					'name' => '最新优惠',
					'key' => 'M100_NEWS'
					),
				array(
					'type' => 'click',
					'name' => '产品购买',
					'key' => 'M200_BUY'
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

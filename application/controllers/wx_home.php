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
		$this->load->helper('url');
		$this->load->library('wx_api');
	}

	/**
	 * 默认接入函数
	 * 只能在微信中使用
	 */
	public function index()
	{
		$this->load->library('weixin');

		//$type = $this->weixin->get('MsgType');
		$type = $this->weixin->MsgType;
		$from = $this->weixin->FromUserName;
		log_message('debug', "FromUserName: ".$from);
		$nickname = $this->wx_api->get_user_info($from)->nickname;
		log_message('debug', "Nickname: ".$nickname);
		$response = $nickname.', 你好! '.PHP_EOL;
		switch (strtoupper($type))
		{
		case 'TEXT':
			//$response .= '你的消息是: [ '.$this->weixin->get('Content').' ]';
			$response .= "你的消息是: [ {$this->weixin->get('Content')} ]";
			break;
		case 'VOICE':
			$response .= '你的语音消息是: [ '.$this->weixin->get('Recognition').' ]';
			break;
		case 'LINK':
			$response .= '你发过来的链接是: [ '.$this->weixin->get('Url').' ]';
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
				$this->load->helper('url');
				$menu_key = $this->weixin->EventKey;
				$response .= sprintf('你点中的菜单项是[%s], 暂未绑定.', $menu_key);
				$response .= PHP_EOL.anchor('/wx_home/menu/'.$menu_key, '绑定用户');
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
		$this->load->view('weixin/tpl_text', $data);
	}

	public function menu($menu_key)
	{
		$data = array(
			'action' => '/wx_home/action/user'
			);
		$this->load->view('weixin/login', $data);
	}

	public function action($action = '')
	{
		$data = array();
		switch (strtoupper($action))
		{
		case 'BOOTSTRAP':
			$this->load->view('bootstrap');
			break;
		case 'USER':
			$user_1 = $this->wx_api->get_user_info('oepyJt6gXLGhAniv2Z33xfaYFNUE');
			$user_2 = $this->wx_api->get_user_info('abc');

			$data['user_1'] = $user_1;
			$data['user_2'] = $user_2;
			break;
		case 'GET_MENU':
			$data['get_menu'] = $this->wx_api->get_menu();
			break;
		case 'DEL_MENU':
			$data['del_menu'] = $this->wx_api->del_menu();
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
			$data['menu'] = $menu;
			$data['create_menu'] = $this->wx_api->create_menu($menu);
			break;
		default:
			$data['usage'] = '暂时不支持操作['.$action.']';
			$data['usage'] .=  "<p>请输入你所需要的操作</p>";
			$data['usage'] .=  "<p>目前支持的功能有:</p>";
			$data['usage'] .=  "<p>user -- 获取用户信息</p>";
			$data['usage'] .=  "<p>create_menu -- 创建菜单</p>";
			$data['usage'] .=  "<p>get_menu -- 获取菜单</p>";
			$data['usage'] .=  "<p>del_menu -- 删除菜单</p>";
		}

		$data = array('output' => $data);
		$this->load->view('base_view',$data);
	}
}

/* End of file wx_home.php */
/* Location: ./application/controllers/wx_home.php */

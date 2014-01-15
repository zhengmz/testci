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
class Wx_test extends CI_Controller {

	/**
	 * 构造函数
	 */
	public function __construct()
	{
		parent::__construct();
		
		log_message('debug', "Wx_test Controller Initialized");
		$this->load->helper('url');

		$config['appid'] = 'wxb556d3b80344260f';
		$config['appsecret'] = 'ee44ed6971f60aa587dc88778b508249';
		$this->load->library('wx_api', $config);
	}

	public function index($action = '')
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
					'type' => 'view',
					'name' => '会员信息',
					'url' => site_url('wx_home/menu/M302_USER')
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

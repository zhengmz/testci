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
		
		$this->load->library('weixin');
		log_message('debug', "Wx_home Controller Initialized");
	}

	/**
	 * 默认接入函数
	 */
	public function index()
	{
		// 验证接入消息的真实性, 支持开发者认证
		$this->weixin->valid();

		$post_arr = $this->weixin->msg();
		if (empty($post_arr))
		{
			echo "Cannot get post data from wechat!";
			exit;
		}

		if ($post_arr['MsgType'] == 'text')
		{
			$from = $this->weixin->get_user_info($post_arr['FromUserName'])->nickname;
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
	public function action()
	{
		$user_1 = $this->weixin->get_user_info('oepyJt6gXLGhAniv2Z33xfaYFNUE');
		echo '<p>receive user 1: </p>';
		print_r($user_1);
		echo '<p>user 1: '.$user_1->nickname.'</p>';
		$user_2 = $this->weixin->get_user_info('abcd');
		echo '<p>receive user 2: </p>';
		print_r($user_2);
		echo '<p>user 2: '.$user_2->nickname.'</p>';
	}
}

/* End of file wx_home.php */
/* Location: ./application/controllers/wx_home.php */

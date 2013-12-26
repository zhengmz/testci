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
		$post_arr = $this->weixin->msg();
		if (empty($post_arr))
		{
			echo "Cannot get post data from wechat!";
			exit;
		}

		if ($post_arr['MsgType'] == 'text')
		{
			$respone_str = $post_arr['FromUserName'].', 你好! '.chr(13).chr(10);
			$respone_str .= 'Your msg is : '.$post_arr['Content'];
			$data = array(
				'to' => $post_arr['FromUserName'],
				'from' => $post_arr['ToUserName'],
				'time' => time(),
				//'type' => 'text',
				'type' => '',
				'content' => $respone_str
			);
			$xml = $this->load->view('weixin/text', $data, TRUE);
			$ret_code = $this->weixin->send($xml);
			log_message('debug', "return code is : ".$ret_code);
		}
	}
}

/* End of file wx_home.php */
/* Location: ./application/controllers/wx_home.php */

<?php  if ( ! defined('APPPATH')) exit('No direct script access allowed');

/**
 * 微信控制器
 *
 * @package		Weixin
 * @subpackage		Libraries
 * @category		Libraries
 * @author		zhengmz
 * @link		http://mp.weixin.qq.com/wiki/index.php?title=接入指南
 */
class Weixin extends CI_Controller {

	/**
	 * 构造函数
	 */
	public function __construct()
	{
		parent::__construct();
		$echostr = $this->input->get('echostr');
		log_message('debug', 'echostr = '.$echostr);
		
		$this->load->library('weixin_lib');
		log_message('debug', "Weixin Controller Initialized");
	}

	/**
	 * 默认接入函数
	 */
	public function index()
	{
		$post_arr = $this->_parse_post($this->weixin_lib->msg());
		if (count($post_arr) == 0)
		{
			echo "Cannot get post data from wechat!";
			exit;
		}

		$this->load->library('user_agent');

		$agent = '';
		if ($this->agent->is_browser())
		{
		    $agent .= 'is_browser: '.$this->agent->browser().' '.$this->agent->version().chr(13).chr(10);
		}
		if ($this->agent->is_robot())
		{
		    $agent .= 'is_robot: '.$this->agent->robot().chr(13).chr(10);
		}
		if ($this->agent->is_mobile())
		{
		    $agent .= 'is_mobile: '.$this->agent->mobile().chr(13).chr(10);
		}
		if ($agent == '')
		{
		    $agent = 'Unidentified User Agent';
		}

		if ($post_arr['type'] == 'text')
		{
			$respone_str = $post_arr['from'].', 你好! '.chr(13).chr(10);
			$respone_str .= 'Your msg is : '.$post_arr['content'].chr(13).chr(10);
			$respone_str .= 'You are from : '.$agent;
			$data = array(
				'to' => $post_arr['from'],
				'from' => $post_arr['to'],
				'time' => time(),
				'type' => 'text',
				'content' => $respone_str
			);
			$this->load->view('weixin/text', $data);
		}

	}

	/**
	 * 分解XML格式的HTTP_RAW_POST_DATA数据
	 *
	 * @return array 失败返回空数组
	 */
	private function _parse_post($post_obj)
	{
		$ret_arr = array();
		if (empty($post_obj))
		{
			log_message('debug', "Cannot get HTTP_RAW_POST_DATA");
			return $ret_arr;
		}
		$ret_arr['from'] = $post_obj->FromUserName;
		$ret_arr['to'] = $post_obj->ToUserName;
		$ret_arr['time'] = $post_obj->CreateTime;
		$ret_arr['type'] = $post_obj->MsgType;

		if ($ret_arr['type'] == 'text')
		{
			$ret_arr['content'] = trim($post_obj->Content);
		}
		return $ret_arr;
	}
}

/* End of file weixin.php */
/* Location: ./application/controllers/weixin.php */

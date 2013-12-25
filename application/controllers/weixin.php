<?php  if ( ! defined('APPPATH')) exit('No direct script access allowed');

/**
 * 定义微信接入TOKEN
 */
define("TOKEN", "wx_mifi_token_2013");

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
		
		log_message('debug', "Weixin Class Initialized");
	}

	/**
	 * 默认接入函数
	 */
	public function index()
	{
		//验证真实客户消息
		if ($this->_valid() === FALSE)
		{
			echo "Error!";
			exit;
		}

		$post_arr = $this->_parse_post();
		if (empty($post_arr))
		{
			echo "Error!";
			exit;
		}
		if ($post_arr['type'] == 'text')
		{
			$respone_str = $post_arr['from'].', 你好! '.chr(13).chr(10);
			$respone_str = $respone_str.'Your msg is : '.$post_arr['content'];
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
	private function _parse_post()
	{
		$post_str = isset($GLOBALS['HTTP_RAW_POST_DATA']) ? $GLOBALS['HTTP_RAW_POST_DATA'] : file_get_contents("php://input");

		log_message('debug', "post_str = ".$post_str);
		$ret_arr = array();
		if (empty($post_str))
		{
			log_message('debug', "Cannot get HTTP_RAW_POST_DATA");
			return $ret_arr;
		}
		$post_obj = simplexml_load_string($post_str, 'SimpleXMLElement', LIBXML_NOCDATA);
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

	/**
	 * 验证函数
	 *
	 * @return boolean 成功返回TRUE，失败返回FASLE
	 */
	private function _valid()
	{
		$signature = $this->input->get('signature');
		$timestamp = $this->input->get('timestamp');
		$nonce = $this->input->get('nonce');
		$echostr = $this->input->get('echostr');

		log_message('debug', "signature = ".$signature);
		log_message('debug', "timestamp = ".$timestamp);
		log_message('debug', "nonce = ".$nonce);
		log_message('debug', "echostr = ".$echostr);
		//valid signature , option
		if ($this->_check_signature($signature, $timestamp, $nonce))
		{
			if ($echostr !== FALSE)
			{
				echo $echostr;
				exit;
			}
			return TRUE;
		}
		return FALSE;
	}

	/**
	 * 验证算法
	 *
	 * @return boolean 成功返回TRUE，失败返回FASLE
	 */
	private function _check_signature($signature, $timestamp, $nonce)
	{
		$token = TOKEN;
		$tmpArr = array($token, $timestamp, $nonce);
		sort($tmpArr);
		$tmpStr = implode( $tmpArr );
		$tmpStr = sha1( $tmpStr );
		
		if( $tmpStr == $signature ){
			return TRUE;
		}else{
			return FALSE;
		}
	}
}

/* End of file blog.php */
/* Location: ./application/controllers/blog.php */

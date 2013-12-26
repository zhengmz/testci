<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 *	微信公众平台消息接口
 *
 *	@package	Weixin
 *	@subpackage	Libraries
 *	@category	API
 *	@author		zhengmz
 *	@link
 */
class Weixin
{
	/**
	 * 用来保存TOKEN
	 * @var string
	 * @access protected
	 */
	protected $_weixin_token = 'weixin';
	/**
	 * 用来保存微信加密签名
	 * @var string
	 * @access protected
	 */
	protected $_signature = '';
	/**
	 * 用来保存时间戳
	 * @var string
	 * @access protected
	 */
	protected $_timestamp = '';
	/**
	 * 用来保存随机数
	 * @var string
	 * @access protected
	 */
	protected $_nonce = '';
	/**
	 * 用来保存随机字符串
	 * @var string
	 * @access protected
	 */
	protected $_echostr = '';
	/**
	 * 用来保存传入消息, 对象格式
	 * @var object
	 * @access protected
	 */
	protected $_msg_obj = NULL;
	/**
	 * 用来保存传入消息, 数据格式
	 * @var array
	 * @access protected
	 */
	protected $_msg_arr = array();

	/**
	 * 构造函数
	 * 调用initialize方法进行初始化
	 */
	public function __construct($config = array())
	{
		$this->initialize($config);

		log_message('debug', "Weixin library Initialized");
	}

	/**
	 * 初始化
	 *
	 * @param	array
	 * @return	void
	 */
	public function initialize($config = array())
	{
		$CI = &get_instance();
		// 微信加密签名
		$config['signature'] = $CI->input->get('signature');
		// 时间戳
		$config['timestamp'] = $CI->input->get('timestamp');
		// 随机数
		$config['nonce'] = $CI->input->get('nonce');
		// 随机字符串
		$config['echostr'] = $CI->input->get('echostr');

		foreach ($config as $key => $val)
		{
			if(isset($this->{'_'.$key}))
			{
				$this->{'_'.$key} = $val;
			}
		}

		log_message('debug', "signature = ".$this->_signature);
		log_message('debug', "timestamp = ".$this->_timestamp);
		log_message('debug', "nonce = ".$this->_nonce);
		log_message('debug', 'echostr = '.$this->_echostr);
		log_message('debug', "TOKEN = ".$this->_weixin_token);

		// 验证消息真实性和开发者认证
		$this->_valid();

		// 处理用户消息
		$post = $this->_get_post();

		log_message('debug', 'post = '.$post);
		//extract post data
		if (! empty($post))
		{
			$this->_msg_obj = simplexml_load_string($post, 'SimpleXMLElement', LIBXML_NOCDATA);
			$this->_msg_arr = get_object_vars($this->_msg_obj);
		}
	}

	/**
	 * 接收消息
	 *
	 * @return object 微信接口对象
	 */
	public function msg_obj()
	{
		return $this->_msg_obj;
	}

	/**
	 * 接收消息
	 *
	 * @return array 微信接口数组
	 */
	public function msg()
	{
		return $this->_msg_arr;
	}

	/**
	 *  发送消息
	 * 
	 * @param string $text 消息
	 * @return string 返回码
	 */
	public function send($text = '')
	{
		echo $text;
	}

	/**
	 *  获取返回结果
	 * 
	 * @return string 返回码
	 */
	public function get_ret_code()
	{
		return $this->_get_post();
	}

	/**
	 * 接收用户消息
	 * 
	 * @return string 接收的消息
	 */
	protected function _get_post()
	{
		// 读取用户消息
		return isset($GLOBALS['HTTP_RAW_POST_DATA']) ? $GLOBALS['HTTP_RAW_POST_DATA'] : file_get_contents('php://input');
	}

	/**
	 * 接入是否生效
	 *
	 * @return void
	 */
	protected function _valid()
	{
		if ($this->_check_signature())
		{
			echo $this->_echostr;
		}
		else
		{
			echo 'This must be called by wechat.';
			exit;
		}
	}

	/**
	 * 通过检验signature对网址接入合法性进行校验
	 *
	 * @return bool
	 */
	protected function _check_signature()
	{
		$tmp = array($this->_weixin_token, $this->_timestamp, $this->_nonce);
		sort($tmp);

		$str = sha1(implode($tmp));

		return $str == $this->_signature ? TRUE : FALSE;
	}
}

/* End of file Weixin.php */
/* Location: ./application/libraries/Weixin.php */

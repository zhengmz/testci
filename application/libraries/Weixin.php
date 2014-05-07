<?php  if ( ! defined('APPPATH')) exit('No direct script access allowed');

/**
 *	微信公众平台消息接口
 *
 *	@package	Weixin
 *	@subpackage	Libraries
 *	@category	API
 *	@author		zhengmz
 *	@link		http://mp.weixin.qq.com/wiki/index.php?title=接入指南
 */
class Weixin {

	/**
	 * 用来保存TOKEN
	 * @var string
	 * @access protected
	 */
	protected $_weixin_token = 'weixin';
	/**
	 * 用来保存open_id
	 * @var string
	 * @access protected
	 */
	protected $_open_id = '';
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
	 * 用来访问CodeIgniter资源
	 * @var object
	 * @access protected
	 */
	protected $CI = NULL;

	// ---------------------------------------------------------------

	/**
	 * 构造函数
	 * 调用initialize方法进行初始化
	 *
	 * @param array 默认使用config/weixin.php进行配置，也可以传递进来
	 */
	public function __construct($config = array())
	{
		$this->initialize($config);

		log_message('debug', "Weixin library Initialized");
	}

	/**
	 * 初始化: 将配置参数赋值给成员变量
	 *
	 * @param	array	配置参数
	 * @return	void
	 */
	public function initialize($config = array())
	{
		$this->CI = &get_instance();

		foreach ($config as $key => $val)
		{
			if(isset($this->{'_'.$key}))
			{
				$this->{'_'.$key} = $val;
			}
		}

		// 验证消息真实性，并支持开发者认证
		$this->_valid();

		// 读取用户消息
		$post = isset($GLOBALS['HTTP_RAW_POST_DATA']) ? $GLOBALS['HTTP_RAW_POST_DATA'] : file_get_contents('php://input');

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
	public function msg()
	{
		return $this->_msg_obj;
	}

	/**
	 * 根据key，获取用户传入的相应数据
	 * 通过重载魔术方法（magic methods）来实现的
	 *
	 * @param string 参数名称
	 * @return string 返回参数值
	 */
	public function __get($key)
	{
		return $this->get($key);
	}
	
	/**
	 * 根据key，获取用户传入的相应数据
	 * 这里做了统一的容错处理
	 *
	 * @param mixed 可以是一个字符串，或是一个数组
	 * @return mixed 根据参数，返回字符串或是数组
	 */
	public function get($keys = array())
	{
		// 空，直接返回整个数组
		if (empty($keys))
		{
			return $this->_msg_arr;
		}

		// 单个的处理
		if (! is_array($keys))
		{
			return isset($this->_msg_obj->$keys) ? $this->_msg_obj->$keys : '';
		}

		$ret = array();
		foreach ($keys as $key)
		{
			$ret[$key] = $this->get($key);
		}
		return $ret;
	}
	
	// ---------------------------------------------------------------

	/**
	 * 接入是否生效
	 * 通过微信客户端才需要使用此方法
	 *
	 * @return void
	 */
	protected function _valid()
	{
		// 微信加密签名
		$signature = $this->CI->input->get('signature');
		// 时间戳
		$timestamp = $this->CI->input->get('timestamp');
		// 随机数
		$nonce = $this->CI->input->get('nonce');
		// 随机字符串
		$echostr = $this->CI->input->get('echostr');

		log_message('debug', "signature = ".$signature);
		log_message('debug', "timestamp = ".$timestamp);
		log_message('debug', "nonce = ".$nonce);
		log_message('debug', 'echostr = '.$echostr);
		log_message('debug', "TOKEN = ".$this->_weixin_token);

		if ($this->_check_signature($signature, $timestamp, $nonce))
		{
			// 支持开发者认证
			if (!empty($echostr))
			{
				echo $echostr;
				exit;
			}
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
	 * @param string 微信加密签名
	 * @param string 时间戳
	 * @param string 随机数
	 * @return bool
	 */
	protected function _check_signature($signature, $timestamp, $nonce)
	{
		$tmp = array($this->_weixin_token, $timestamp, $nonce);
		sort($tmp, SORT_STRING);

		$str = sha1(implode($tmp));

		return $str == $signature ? TRUE : FALSE;
	}
}

/* End of file Weixin.php */
/* Location: ./application/libraries/Weixin.php */

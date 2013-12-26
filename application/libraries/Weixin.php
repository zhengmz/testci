<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 *	微信公众平台消息接口
 *
 *
 *	@package	Weixin
 *	@subpackage Libraries
 *	@category	API
 *	@author		Kshan <kshan@qq.com>
 *	@modify		zhengmz
 *	@link
 */
class Weixin
{
	protected $_weixin_token = 'weixin';
	protected $_signature = '';
	protected $_timestamp = '';
	protected $_nonce = '';
	protected $_echostr = '';

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
	}

	/**
	 * 接收消息
	 *
	 * @return object 微信接口对象
	 */
	public function msg()
	{
		$post = isset($GLOBALS['HTTP_RAW_POST_DATA']) ? $GLOBALS['HTTP_RAW_POST_DATA'] : file_get_contents('php://input');
		log_message('debug', 'post = '.$post);

		//extract post data
		if (empty($post))
		{
			return NULL;
		}

		return simplexml_load_string($post, 'SimpleXMLElement', LIBXML_NOCDATA);
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

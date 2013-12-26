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

	protected $CI;

	public function __construct($config = array())
	{
		if (! empty($config))
		{
			foreach ($config as $key => $val)
			{
				if(isset($this->{'_'.$key}))
				{
					$this->{'_'.$key} = $val;
				}
			}
		}
		$this->CI = &get_instance();
		$this->_valid();

		log_message('debug', "Weixin library Initialized");
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
			return;
		}

		return simplexml_load_string($post, 'SimpleXMLElement', LIBXML_NOCDATA);
	}

	/**
	 * 接入是否生效
	 *
	 * @return void
	 */
	private function _valid()
	{
		// 随机字符串
		$echostr = $this->CI->input->get('echostr');

		log_message('debug', 'echostr = '.$echostr);
		if ($this->_check_signature())
		{
			echo $echostr;
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
	private function _check_signature()
	{
		// 微信加密签名
		$signature = $this->CI->input->get('signature');
		// 时间戳
		$timestamp = $this->CI->input->get('timestamp');
		// 随机数
		$nonce = $this->CI->input->get('nonce');

		log_message('debug', "signature = ".$signature);
		log_message('debug', "timestamp = ".$timestamp);
		log_message('debug', "nonce = ".$nonce);
		log_message('debug', "TOKEN = ".$this->_weixin_token);
		$tmp = array($this->_weixin_token, $timestamp, $nonce);
		sort($tmp);

		$str = sha1(implode($tmp));

		return $str == $signature ? TRUE : FALSE;
	}
}

/* End of file Weixin.php */
/* Location: ./application/libraries/Weixin.php */

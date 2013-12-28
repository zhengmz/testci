<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

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
	 * 用来保存appid
	 * @var string
	 * @access protected
	 */
	protected $_appid = '';
	/**
	 * 用来保存appsecret
	 * @var string
	 * @access protected
	 */
	protected $_appsecret = '';
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
	}

	/**
	 * 接入是否生效, 并读取传入消息
	 * 通过微信客户端才需要使用此方法
	 *
	 * @return void
	 */
	public function valid()
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
			echo $echostr;
		}
		else
		{
			echo 'This must be called by wechat.';
			exit;
		}

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
	 * 获取用户信息
	 *
	 * @param string 用户的openid
	 * @return array 微信接口数组
	 */
	public function get_user_info($openid)
	{
		$params = array (
			'access_token' => $this->_get_access_token(),
			'openid' => $openid
			);
		return $this->_wx_url_api('user/info', $params);
	}

	/**
	 * 获取微信接口访问所需的access_token
	 * 先从缓存读取, 如果没有或已过期, 再调用微信接口
	 *
	 * @return string 返回access_token, 错误返回FALSE
	 */
	protected function _get_access_token()
	{
		$this->CI->load->driver('cache');

		$access_token = $this->CI->cache->file->get('access_token');
		if ($access_token !== FALSE)
		{
			return $access_token;
		}

		$params = array (
			'grant_type' => 'client_credential',
			'appid' => $this->_appid,
			'secret' => $this->_appsecret
			);
		$ret = $this->_wx_url_api('token', $params);
		$access_token = $ret['access_token'];
		$expires_in = $ret['expires_in'];
		if (empty($ret['access_token']))
		{
			echo '错误代码: '.$ret['errcode'].'\n';
			echo '错误信息: '.$ret['errmsg'];
			return FALSE;
		}

		log_message('debug', 'access_token = '.$access_token);
		log_message('debug', 'expires_in = '.$expires_in);
		$this->CI->cache->file->save('access_token', $access_token, $expires_in);
		return $access_token;
	}

	/**
	 * 访问weixin接口
	 *
	 * @param string 调用的方法名，如'token', 'menu/create'等
	 * @param array 使用GET调用的参数数组
	 * @param var 使用POST调用的参数, 如果非空, 则自动使用POST方法
	 * @return array 根据返回的json对象转为数组
	 */
	protected function _wx_url_api($method, $get_params = array(), $post_params = NULL)
	{
		$url_base = 'https://api.weixin.qq.com/cgi-bin/';

		$url = $url_base.$method;
		$get_param_str = '';
		foreach ($get_params as $key => $val)
		{
			if ($get_param_str !== '')
			{
				$get_param_str .= '&';
			}
			$get_param_str .= $key.'='.$val;
		}
		if ($get_param_str !== '')
		{
			$url .= '?'.$get_param_str;
		}

		$url_params = array();
		$url_params[CURLOPT_URL] = $url;
		$url_params[CURLOPT_RETURNTRANSFER] = TRUE;
		if ($post_params !== NULL)
		{
			$url_params[CURLOPT_POST] = TRUE;
              		$url_params[CURLOPT_POSTFIELDS] = $post_params;
		}
		
		// 将返回的json数据转为数组
		return json_decode($this->_get_from_url($url_params), TRUE);
	}

	/**
	 * 使用curl方法获取远程url的数据
	 *
	 * @param array curl_setopt所需要的参数
	 * @return string
	 */
	protected function _get_from_url($url_params)
	{
		$ch = curl_init();
		foreach ($url_params as $key => $val)
		{
			curl_setopt($ch, $key, $val);
		}
		$output = curl_exec($ch);
		curl_close($ch);

		return $output;
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
		sort($tmp);

		$str = sha1(implode($tmp));

		return $str == $signature ? TRUE : FALSE;
	}
}

/* End of file Weixin.php */
/* Location: ./application/libraries/Weixin.php */

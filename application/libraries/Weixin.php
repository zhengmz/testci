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
	 * 初始化: 将配置参数保持给成员变量，同时将post数据读出
	 *
	 * @param	array	配置参数
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

		// 验证消息真实性, 并支持开发者认证
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
	 * 获取微信接口访问所需的access_token
	 * 使用的成员变量: _appid, _appsecret
	 *
	 * @return string 返回access_token
	 */
	protected function _get_access_token()
	{
		$params = array (
			'grant_type' => 'client_credential',
			'appid' => $this->_appid,
			'secret' => $this->_appsecret
		);

		$ret_arr = $this->_wx_url_api('token', 'GET', $params);
	}

	/**
	 * 访问weixin接口
	 * @param string 调用的方法名，如'token', 'menu/create'等
	 * @param string 调用类型, 有三种方式: GET, POST, GET_POST
	 * @param array 使用GET调用的参数数组
	 * @param var 使用POST调用的参数
	 *
	 * @return array 根据返回的json对象转为数组
	 */
	protected function _wx_url_api($method, $get_post = 'GET', $get_params = array(), $post_params = NULL)
	{
		$url_base = 'https://api.weixin.qq.com/cgi-bin/';

		$url = $url_base.$method.'?';
		if ($get_post == 'GET')
		{
			$get_str = '';
			foreach ($get_params as $key => $val)
			{
				if ($ == 1)
			}
		}
		$url = sprintf('https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=%s&secret=%s', $this->_appid, $this->_appsecret);
		
		$url = sprintf('http://maps.googleapis.com/maps/api/geocode/json?latlng=%s,%s&sensor=false&language=' . $language, $lat, $lng);

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);  
		$geo = curl_exec($ch);
		curl_close($ch);	
		
		$geo = json_decode($geo, TRUE);	

		// 不存在有效地理信息
		if ( ! isset($geo['results']))
		{
			return;
		}

		$output = array();

		foreach ($geo['results'][0]['address_components'] as $address)
		{
			$output[$address['types'][0]] = $address['long_name'];
		}

		return $output;
	}

	/**
	 * 接入是否生效
	 * 使用到成员变量: _echostr, _signature
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
	 * 使用到成员变量: _weixin_token, _timestamp, _nonce, _signature
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

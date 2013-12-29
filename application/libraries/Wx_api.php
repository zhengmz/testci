<?php  if ( ! defined('APPPATH')) exit('No direct script access allowed');

/**
 *	微信公众平台消息接口
 *	本类主要处理与平台之间的接口
 *
 *	@package	Wx_api
 *	@subpackage	Libraries
 *	@category	API
 *	@author		zhengmz
 *	@link		http://mp.weixin.qq.com/wiki/index.php?title=接入指南
 */
class Wx_api {

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

		log_message('debug', "wx_api library Initialized");
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
	 * 获取用户信息
	 *
	 * @param string 用户的openid
	 * @return array 用户信息数组, 失败返回FALSE
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
	 * 获取菜单
	 *
	 * @return object 
	 */
	public function get_menu()
	{
		return $this->_menu_operator('get');
	}

	/**
	 * 创建菜单
	 *
	 * @param array 要创建的菜单数组
	 * @return object 成功返回错误码0, 失败非0
	 */
	public function create_menu($menu)
	{
		log_message('debug', "menu = ".$menu);
		if (is_array($menu))
		{
			log_message('debug', "enter create if");
			$menu = $this->_url_encode($menu, TRUE);
			log_message('debug', "urlencode menu = ".$menu);
			$menu = json_encode($menu);
			log_message('debug', "json menu = ".$menu);
		}
		return $menu;
		//return $this->_menu_operator('create', $menu);
	}

	/**
	 * 实现对数组的urlencode
	 *
	 * @param array 传入待编码的数组
	 * @param boolean 判断传入的数组是否是菜单数组
	 * @return array 返回编码后的数组
	 */
	protected function _url_encode($data, $is_menu = FALSE)
	{
		log_message('debug', "_url_encode: data = ".$data);
		foreach ($data as $key => $val)
		{
			if (is_array($val))
			{
				$data[$key] = _url_encode($val, $is_menu);
			}
			else
			{
				// 对菜单数组进行特殊处理
				if (! $is_menu or $key !== 'type')
				{
					$data[$key] = urlencode($val);
				}
			}
		}
		return $data;
	}

	/**
	 * 菜单操作
	 *
	 * @param string 菜单接口方法, 有create, get, delete
	 * @param string 要创建的菜单json
	 * @return object 成功返回错误码0, 失败非0
	 */
	protected function _menu_operator($method, $menu = NULL)
	{
		$get_params = array (
			'access_token' => $this->_get_access_token(),
			);
		return $this->_wx_url_api('menu/'.$method, $get_params, $menu);
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
		$access_token = $ret->access_token;
		$expires_in = $ret->expires_in;
		if (empty($access_token))
		{
			echo '错误代码: '.$ret->errcode.'\n';
			echo '错误信息: '.$ret->errmsg;
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
	 * @param string 使用POST调用的参数, 如果非空, 则自动使用POST方法
	 * @return object 根据返回的json字符串转为对象
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
		//return json_decode($this->_get_from_url($url_params), TRUE);
		return json_decode($this->_get_from_url($url_params));
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
}

/* End of file Wx_api.php */
/* Location: ./application/libraries/Wx_api.php */

<?php  if ( ! defined('APPPATH')) exit('No direct script access allowed');

/**
 *	微信公众平台消息接口
 *	本类主要处理与平台之间的接口
 *	依赖MY_url_helper中的一些方法
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
			//'openid' => (string) $openid,
			'openid' => $openid,
			);
		//log_message('debug', __METHOD__."-openid: ".$openid);
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
	 * 删除菜单
	 *
	 * @return object 
	 */
	public function del_menu()
	{
		return $this->_menu_operator('delete');
	}

	/**
	 * 创建菜单
	 *
	 * @param array 要创建的菜单数组
	 * @return object 成功返回错误码0, 失败非0
	 */
	public function create_menu($menu)
	{
		if (is_array($menu))
		{
			// 先对中文进行编码
			//$menu = $this->_url_encode($menu);
			$menu = urlencode_array($menu);
			// 再对中文进行解码
			$menu = urldecode(json_encode($menu, TRUE));
			//log_message('debug', 'json menu = '.$menu);
		}
		return $this->_menu_operator('create', $menu);
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

		//log_message('debug', 'access_token = '.$access_token);
		//log_message('debug', 'expires_in = '.$expires_in);
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
		if (!empty($get_params))
		{
		log_message('debug', __METHOD__."-openid: ".$get_params['openid']);
			$url .= '?' . http_build_query($get_params,'','&');
			//$url = preg_replace('/%5B[0-9]+%5D/simU', '', $url);
		}
		log_message('debug', __METHOD__."-url: ".$url);

		$url_params = array();
		$url_params[CURLOPT_URL] = $url;
		$url_params[CURLOPT_RETURNTRANSFER] = TRUE;
		if ($post_params !== NULL)
		{
			$url_params[CURLOPT_POST] = TRUE;
              		$url_params[CURLOPT_POSTFIELDS] = $post_params;
		}
		
		// 将返回的json数据转为数组
		//return json_decode($this->_get_from_url($url_params));
		return json_decode(get_from_url($url_params));
	}
}

/* End of file Wx_api.php */
/* Location: ./application/libraries/Wx_api.php */

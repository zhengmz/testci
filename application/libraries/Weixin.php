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
class Weixin {

	protected $_weixin_token = 'weixin';

	protected $CI;

	public function __construct($config = array())
	{
		if (count($config) > 0)
		{
			foreach ($config as $key => $val)
			{
				if(isset($this->{'_' . $key}))
				{
					$this->{'_' . $key} = $val;
				}				
			}
		}
		$this->CI = &get_instance();

		$this->_valid();

		log_message('debug', "Weixin Class Initialized");		
	}

	/**
	 * 接收消息
	 *
	 * @return object 微信接口对象
	 */
	public function msg()
	{
		$post = isset($GLOBALS['HTTP_RAW_POST_DATA']) ? $GLOBALS['HTTP_RAW_POST_DATA'] : file_get_contents("php://input");
				
		//extract post data
		if (empty($post))
		{
			return;
		}

		return simplexml_load_string($post, 'SimpleXMLElement', LIBXML_NOCDATA);
	}

	/**
	 *  发送消息
	 * 
	 * @param string $type text|news 消息类型
	 * @param array $msg 消息
	 * @param string $tag 0|1 星标消息
	 */
	public function send($type = 'text', $msg = array(), $tag = 0)
	{
		if ( ! in_array($type, array('text', 'news')))
		{
			return;
		}

		// 文本消息
		if ($type == 'text') 
		{
            		$tpl = "<xml>
				<ToUserName><![CDATA[%s]]></ToUserName>
				<FromUserName><![CDATA[%s]]></FromUserName>
				<CreateTime>%s</CreateTime>
				<MsgType><![CDATA[%s]]></MsgType>
				<Content><![CDATA[%s]]></Content>
				<FuncFlag>%s</FuncFlag>
				</xml>"; 

			echo sprintf($tpl, $msg['to'], $msg['from'], $msg['time'], $type, $msg['content'], $tag);
			exit;							
		}

		// 图文消息
		if ($type = 'news')
		{
            		$tpl = "<xml>
				<ToUserName><![CDATA[%s]]></ToUserName>
				<FromUserName><![CDATA[%s]]></FromUserName>
				<CreateTime>%s</CreateTime>
				<MsgType><![CDATA[%s]]></MsgType>
				<Content><![CDATA[]]></Content>
				<ArticleCount>%s</ArticleCount>
				<Articles>"; 

			$output = sprintf($tpl, $msg['to'], $msg['from'], $msg['time'], $type, count($msg['items']));

			foreach ($msg['items'] as $item)
			{
				$tpl = "<item>
					<Title><![CDATA[%s]]></Title>
					<Discription><![CDATA[%s]]></Discription>
					<PicUrl><![CDATA[%s]]></PicUrl>
					<Url><![CDATA[%s]]></Url>
					</item>";

				$output .= sprintf($tpl, $item['title'], trim($item['description']), $item['picurl'], $item['url']);
			}

			$tpl = "</Articles>
     				<FuncFlag>%s</FuncFlag>
    				</xml>";

    		$output .= sprintf($tpl, $tag);

    		echo $output;
    		exit;    		
    	}
	}

	/**
	 * 根据经纬度反译地理信息
	 *
	 * @param string $lat 纬度
	 * @param string $lng 经度
	 * @return array
	 */
	public function geocode($lat, $lng, $language = 'en')
	{		
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
	 *
	 * @return void
	 */
	private function _valid()
	{
		// 随机字符串
		$echostr = $this->CI->input->get('echostr');
		
		if ($this->_check_signature())
		{
			echo $echostr;
		}
		else
		{
			echo 'This must be called by wechat';
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

		$tmp = array($this->_weixin_token, $timestamp, $nonce);
		sort($tmp);

		$str = sha1(implode($tmp));

		return $str == $signature ? TRUE : FALSE;
	}
}

/* End of file Weixin.php */
/* Location: ./application/libraries/Weixin.php */

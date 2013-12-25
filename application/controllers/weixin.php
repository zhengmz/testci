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
		$signature = $this->input->get('signature');
		$timestamp = $this->input->get('timestamp');
		$nonce = $this->input->get('nonce');

		log_message('debug', "signature = ".$signature);
		log_message('debug', "timestamp = ".$timestamp);
		log_message('debug', "nonce = ".$nonce);
		if($this->_check_signature($signature, $timestamp, $nonce))
		{
			echo "You are welcome.";
		} else {
			echo "You aren't welcome.";
		}
	}

	/**
	 * 验证函数
	 *
	 * @return string 成功返回echostr，失败不返回
	 */
	public function valid()
	{
		$signature = $this->input->get('signature');
		$timestamp = $this->input->get('timestamp');
		$nonce = $this->input->get('nonce');
		$echostr = $this->input->get('echostr');

		log_message('debug', "signature = ".$signature);
		log_message('debug', "timestamp = ".$timestamp);
		log_message('debug', "nonce = ".$nonce);
		//valid signature , option
		if($this->_check_signature($signature, $timestamp, $nonce))
		{
			echo $echostr;
			exit;
		}
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

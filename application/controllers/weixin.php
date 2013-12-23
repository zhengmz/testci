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
		$this->load->helper(array('html','url'));
	}

	/**
	 * 接收函数
	 * @return boolean 插入成功返回ID，插入失败返回FALSE
	 */
	public function index()
	{
		$signature = $this->input->get('signature');
		$timestamp = $this->input->get('timestamp');
		$nonce = $this->input->get('nonce');
		$echoStr = $this->input->get('echoStr');

		//valid signature , option
		if($this->check_signature($signature, $timestamp, $nonce))
		{
			echo $echoStr;
			exit;
		}
	}

	/**
	 * 验证算法
	 * @return boolean 成功返回TRUE，失败返回FASLE
	 */
	private function check_signature($signature, $timestamp, $nonce)
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

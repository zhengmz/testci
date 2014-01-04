<?php  if ( ! defined('APPPATH')) exit('No direct script access allowed');

/**
 * MY URL Helpers
 * Special for Weixin and Amazon Web Service
 * 针对微信和亚马逊虚拟主机上的一些方法
 *
 * @package		MY_Package
 * @subpackage		Helpers
 * @category		Helpers
 * @author		zhengmz
 * @link		http://codeigniter.com/user_guide/helpers/url_helper.html
 */

// ------------------------------------------------------------------------

/**
 * urlencode for array
 * 实现对数组的urlencode
 * urlencode的好处是对非英文内容的支持
 * 因json_encode会自动转为unicode, 使非英文内容有问题
 * 所以先用urlencode进行转义, json_encode后, 再用urldecode就还原
 *
 * @access	public
 * @param	array	传入待编码的数组
 * @return	array	返回编码后的数组
 */
if ( ! function_exists('urlencode_array'))
{
	function urlencode_array($data)
	{
		foreach ($data as $key => $val)
		{
			if (is_array($val))
			{
				$data[$key] = urlencode_array($val);
			}
			else
			{
				$data[$key] = urlencode($val);
			}
		}
		return $data;
	}
}

/**
 * replace file_get_contents
 * file_get_contents在亚马逊主机上无法使用
 * 使用curl方法获取远程url的数据
 *
 * @param mixed curl_setopt所需要的参数
 * @return string
 */
if ( ! function_exists('curl_get_contents'))
{
	function curl_get_contents($url_params)
	{
		$ch = curl_init();
		if (is_array($url_params))
		{
			foreach ($url_params as $key => $val)
			{
				curl_setopt($ch, $key, $val);
			}
		}
		else
		{
                	curl_setopt($ch, CURLOPT_URL, (string) $url_params);
		}
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		$output = curl_exec($ch);
		curl_close($ch);
		//log_message('debug', __METHOD__."-output: ".$output);

		return $output;
	}
}

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
 * replace http_build_query
 * 在微信中使用http_build_query方法既然会出问题
 * 用此方法代替
 *
 * @access	public
 * @param array 所需要的参数
 * @return string
 */
if ( ! function_exists('build_get_query'))
{
	function build_get_query($params)
	{
		$get_query = '';
		foreach ($params as $key => $val)
		{
			if ($get_query === '')
			{
				$get_query .= $key.'='.$val;
			}
			else
			{
				$get_query .= '&'.$key.'='.$val;
			}
		}
		return $get_query;
	}
}

/**
 * replace get_file_contents
 * get_file_contents在亚马逊主机上无法使用
 * 使用curl方法获取远程url的数据
 *
 * @param mixed curl_setopt所需要的参数
 * @return string
 */
if ( ! function_exists('get_from_url'))
{
	function get_from_url($url_params)
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

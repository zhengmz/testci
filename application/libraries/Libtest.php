<?php  if ( ! defined('APPPATH')) exit('No direct script access allowed');

/**
 *	类库测试程序
 *
 *	@package	Application
 *	@subpackage	Libraries
 *	@category	API
 *	@author		zhengmz
 *	@link		
 */

// PHP不区分类名的大小写

class LIbtest {

//	protected $CI = NULL;

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

		log_message('debug', "libtest library Initialized");
	}

	/**
	 * 初始化: 将配置参数赋值给成员变量
	 *
	 * @param	array	配置参数
	 * @return	void
	 */
	public function initialize($config = array())
	{
//		$this->CI = &get_instance();

		foreach ($config as $key => $val)
		{
			if(isset($this->{'_'.$key}))
			{
				$this->{'_'.$key} = $val;
			}
		}
                echo "<pre>Config: \n";
                var_dump($config);

                echo "\n\nClass Info: \n";
                var_dump($this);
	}

}

/* End of file Libtest.php */
/* Location: ./application/libraries/Libtest.php */

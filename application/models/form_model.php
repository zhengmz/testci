<?php  if ( ! defined('APPPATH')) exit('No direct script access allowed');

/**
 * Form Model Class
 * 功能：
 * 1. 支持Form自动生成
 * 2. 实现自动验证
 * 3. 与数据Model直接关联（与_map字段映射表结合使用）
 *
 * @package		MyApplication
 * @subpackage		Model
 * @category		form_model
 * @author		zhengmz
 * @link		
 */
class Form_model extends MY_Model {

	/**
	 * Form config
	 * 	action中，要能支持update和delete两个方法或参数
	 *
	 * @var array
	 * @access protected
	 */
	protected $_form = array();
	/**
	 * form fields list
	 * @var array 各字段的对应属性
	 * @access protected
	 */
	protected $_form_fields = array();

	// ------------------------------------------------------------

	/**
	 * 构造函数
	 * 
	 * @param array 接受参数
	 */
	public function __construct($config = array())
	{
		parent::__construct();

		log_message('debug', "Form Model Initialized");
	}

	/**
	 * 初始化form: 
	 * 支持的参数:
	 *	form array 与form相关的参数
	 *	input array 表单字段，每一字段对应一个数组，包括button
	 *
	 * @param	array	配置参数
	 * @return	void
	 */
	public function set_form($forms = array())
	{
	}

	/**
	 * show form: 
	 * 把form显示出来.
	 *	如果有参数，则将从数据库查询出一条记录，以备修改
	 *	参数空，则新增一条记录
	 *
	 * @param	array	查询条件
	 * @return	string	错误返回FALSE, 成功返回字符串
	 */
	public function show_form($where = array())
	{
	}

	/**
	 * show form by PK 
	 * 根据主键值，则将从数据库查询出一条记录，进行修改
	 *
	 * @param	string	主键
	 * @return	string	错误返回FALSE, 成功返回字符串
	 */
	public function show_form_by_pk($pk = '')
	{
		$pk = (string) $pk;
		$where[$this->_primary_key] = $pk;

		return show_form($where);
	}

	/**
	 * show table
	 * 将数据以表格形式出现，将支持条件查询，和权限控制
	 *
	 * @param	array	查询条件
	 * @param	bool	用来判断是否显示删除和更新
	 * @return	string	错误返回FALSE, 成功返回字符串
	 */
	public function show_table($where = array(), $update = FALSE)
	{
	}
}

/* End of file form_model.php */
/* Location: ./application/models/form_model.php */

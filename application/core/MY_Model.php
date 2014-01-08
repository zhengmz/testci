<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * My Model Class
 * 支持每个Model可以连接不同数据库
 *
 * @package		MyCore
 * @subpackage		Libraries
 * @category		Libraries
 * @author		zhengmz
 * @link		http://codeigniter.com/user_guide/libraries/config.html
 */
class MY_Model extends CI_Model {


	/**
	 * 表名
	 * @var string
	 * @access protected
	 */
	protected $_table_name = '';
	/**
	 * 主键
	 * @var string
	 * @access protected
	 */
	protected $_primary_key = '';
	/**
	 * 表字段映射关系数组
	 * @var array 别名<->字段名 
	 * @access protected
	 */
	protected $_map = array();
	/**
	 * 数据库连接名称
	 * @var string
	 * @access protected
	 */
	protected $_db_name = '';
	/**
	 * 数据库连接句柄
	 * @var object
	 * @access protected
	 */
	protected $_db = NULL;

	// ------------------------------------------------------------

	/**
	 * 构造函数
	 * 
	 * @param array 接受参数
	 */
	public function __construct($config = array())
	{
		parent::__construct();
		if (! empty($config))
		{
			$this->initialize($config);
		}

		log_message('debug', "MY_Model Class Initialized");
	}

	/**
	 * 初始化: 将配置参数赋值给成员变量
	 * 支持的参数:
	 *	table_name string 表名
	 *	primary_key string 主键
	 *	map array 字段映射关系
	 *	db_name string 数据库连接名, 见config/database.php中的group
	 *
	 * @param	array	配置参数
	 * @return	void
	 */
	public function initialize($config = array())
	{
		foreach ($config as $key => $val)
		{
			if(isset($this->{'_'.$key}))
			{
				$this->{'_'.$key} = $val;
			}
		}

		// 连接数据库
		$this->conn_db($this->_db_name);
	}

	/**
	 * 连接数据库
	 * 如果指定连接串, 则可以支持连接到非默认的数据库
	 * 
	 * @param string 数据库连接名
	 * @return void
	 */
	public function conn_db($db_name = '')
	{
		$CI =& get_instance();
		if (empty($db_name))
		{
			if (! class_exists('CI_DB'))
			{
				$CI->load->database('', FALSE, TRUE);
			}
			
			$this->_db = $CI->db;
		}
		else
		{
			$this->_db = $CI->load->database($db_name, TRUE, TRUE);
		}
	}

	// ------------------------------------------------------------
 
	/**
	 * 根据映射表转换
	 * 
	 * @param array 需要转换的数据
	 * @param boolean 反转标志
	 * @return mixed 返回转换后的数据
	 */
	private function _map_field($data = array(), $reversal = FALSE)
	{
		if (empty($this->_map) or empty($data) or ! is_array($data))
		{
			return $data;
		}

		$map = $this->_map;
		if (reversal === TRUE)
		{
			$map = array_flip($map);
		}
		
		foreach ($data as $key => $val)
		{
			if(isset($map[$key]))
			{
				unset($data[$key]);
				$data[$map[$key]] = $val;
			}
		}
		return $data;
	}

	// ------------------------------------------------------------
 
	/**
	 * 保存数据
	 * 
	 * @param array $data 需要插入的表数据
	 * @return boolean 插入成功返回ID，插入失败返回FALSE
	 */
	public function save($data)
	{
		$data = $this->_map_field($data);

		if($this->_db->set($data)->insert($this->_table_name)) {
			return $this->_db->insert_id();
		}
		return FALSE;
	}
 
	/**
	 * Replace数据
	 *
	 * @param array $data
	 */
	public function replace($data)
	{
		$data = $this->_map_field($data);

		return $this->_db->replace($this->_table_name, $data);
	}
 
	/**
	 * 根据主键更新记录
	 * 
	 * @param string $pk 主键值
	 * @param array $attributes 更新字段
	 * @param array $where 附加where条件
	 * @return boolean TRUE更新成功 FALSE更新失败
	 */
	public function update_by_pk($pk, $attributes, $where = array())
	{
		$where[$this->_primary_key] = $pk;

		$where = $this->_map_field($where);
		$attributes = $this->_map_field($attributes);

		return $this->update_all($attributes, $where);
	}
 
	/**
	 * 更新表记录
	 * 
	 * @param array $attributes
	 * @param array $where
	 * @return bollean true更新成功 false更新失败
	 */
	public function update_all($attributes, $where = array())
	{
		$where = $this->_map_field($where);
		$attributes = $this->_map_field($attributes);

		return $this->_db->where($where)->update($this->_table_name, $attributes);
	}
 
	/**
	 * 根据主键删除数据
	 * 
	 * @param string $pk 主键值
	 * @param array $where 附加删除条件
	 * @return boolean true删除成功 false删除失败 
	 */
	public function delete_by_pk($pk, $where = array())
	{
		$where[$this->_primary_key] = $pk;

		$where = $this->_map_field($where);

		return $this->delete_all($where);
	}
 
	/**
	 * 删除记录
	 * 
	 * @param array $where 删除条件
	 * @param int $limit 删除行数
	 * @return boolean TRUE删除成功 FALSE删除失败
	 */
	public function delete_all($where = array(), $limit = NULL)
	{
		$where = $this->_map_field($where);

		return $this->_db->delete($this->_table_name, $where, $limit);
	}
 
	/**
	 * 根据主键检索
	 * 
	 * @param string $pk
	 * @param array $where 附加查询条件
	 * @return array 返回一维数组，未找到记录则返回空数组
	 */
	public function find_by_pk($pk, $where = array())
	{
		$where[$this->_primary_key] = $pk;

		$where = $this->_map_field($where);

		$query = $this->_db->from($this->_table_name)->where($where)->get();
		//return $query->row_array();
		return $this->_map_field($query->row_array(), TRUE);
	}
 
	/**
	 * 根据属性获取一行记录
	 * @param array $where
	 * @return array 返回一维数组，未找到记录则返回空数组
	 */
	public function find_by_attributes($where = array())
	{
		$where = $this->_map_field($where);

		$query = $this->_db->from($this->_table_name)->where($where)->limit(1)->get();
		return $this->_map_field($query->row_array(), TRUE);
	}
 
	/**
	 * 查询记录
	 * 
	 * @param array $where 查询条件，可使用模糊查询，如array('name LIKE' => "pp%") array('stat >' => '1')
	 * @param int $limit 返回记录条数
	 * @param int $offset 偏移量
	 * @param string|array $sort 排序, 当为数组的时候 如：array('id DESC', 'report_date ASC')可以通过第二个参数来控制是否escape
	 * @return array 未找到记录返回空数组
	 */
	public function find_all($where = array(), $limit = 0, $offset = 0, $sort = NULL)
	{
		$where = $this->_map_field($where);

		$this->_db->from($this->_table_name)->where($where);
		if($sort !== NULL) {
			if(is_array($sort)){
				foreach($sort as $value){
					$this->_db->order_by($value, '', false);
				}
			} else {
				$this->_db->order_by($sort);
			}
		}
		if($limit > 0) {
			$this->_db->limit($limit, $offset);
		}
 
		$query = $this->_db->get();
 
		//return $query->result_array();
		return $this->_map_field($query->result_array(), TRUE);
	}
 
	/**
	 * 统计满足条件的总数
	 * 
	 * @param array $where 统计条件
	 * @return int 返回记录条数
	 */
	public function count($where = array())
	{
		$where = $this->_map_field($where);

		return $this->_db->from($this->_table_name)->where($where)->count_all_results();
	}
 
	/**
	 * 根据SQL查询， 参数通过$param绑定
	 * @param string $sql 查询语句，如SELECT * FROM some_table WHERE id = ? AND status = ? AND author = ?
	 * @param array $param array(3, 'live', 'Rick')
	 * @return array 未找到记录返回空数组，找到记录返回二维数组
	 */
	public function query($sql, $param = array())
	{
		$query = $this->_db->query($sql, $param);
		return $this->_map_field($query->result_array(), TRUE);
	}

	/**
	 * 执行SQL语句, 通用型
	 * @return bool 成功返回TRUE, 失败返回FALSE
	 */
	public function exec($sql)
	{
		return $this->_db->query($sql);
	}
}
 
/* End of file MY_Model.php */
/* Location: ./application/core/MY_Model.php */

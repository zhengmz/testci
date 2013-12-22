<?php


class News_model extends MY_Model {

	public function __construct($group_name = '')
	{
		parent::__construct();

		log_message('debug', "News_model Class Initialized");
	}
	/**
	 * 表名
	 */
	public function table_name()
	{
		return "news";
	}

	/**
	 * 主键
	 */
	public function primary_key()
	{
		return "slug";
	}

	public function get_news($slug = FALSE)
	{
		log_message('debug', "enter get_news function");
		$where = array();
		if ($slug !== FALSE)
		{
			$where['slug'] = $slug;
		}
		
		log_message('debug', "prepare calling find_all function");
		return find_all($where);
	}

	public function set_news()
	{
		$this->load->helper('url');
		
		$slug = url_title($this->input->post('title'), '_', TRUE);

		$data = array(
			'title' => $this->input->post('title'),
			'slug' => $slug,
			'text' => $this->input->post('text')
		);

		return save($data);
	}
}

/* End of file news_model.php */
/* Location: ./application/models/news_model.php */

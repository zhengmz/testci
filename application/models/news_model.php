<?php


class News_model extends MY_Model {

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
		$where = array();
		if ($slug !== FALSE)
		{
			$where['slug'] = $slug;
		}
		
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

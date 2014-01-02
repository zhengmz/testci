<?php

class News_model extends MY_Model {

	public function __construct($config = array())
	{
		$config['table_name'] = 'news';
		parent::__construct($config);

		log_message('debug', "MY_Model Class Initialized");
	}

	public function get_news($slug = FALSE)
	{
		$where = array();
		if ($slug !== FALSE)
		{
			$where['slug'] = $slug;
		}
		
		return $this->find_all($where);
	}

	public function set_news()
	{
		$this->load->helper('url');
		
		$slug = url_title($this->input->post('title'), 'dash', TRUE);

		$data = array(
			'title' => $this->input->post('title'),
			'slug' => $slug,
			'text' => $this->input->post('text')
		);

		return $this->save($data);
	}
}

/* End of file news_model.php */
/* Location: ./application/models/news_model.php */

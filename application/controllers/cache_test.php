<?php

class Cache_test extends CI_Controller {
 
	function index()
	{
		$this->load->helper(array('form', 'url', 'html'));
		$this->load->driver('cache', array('adapter' => 'file'));

		if ($this->cache->file->is_supported())
		{
			log_message('debug', 'support file cache');
		}
		$user = $this->input->post('user');
		log_message('debug', 'get user post: '.$user);
		$cache_user = $this->cache->file->get('user');
		log_message('debug', 'get user cache: '.$cache_user);
		if ($cache_user !== '')
		{
			log_message('debug', 'user is: '.$user);
			$user = $cache_user;
		}
		else
		{
			log_message('debug', 'user is: '.$user);
			if ($user !== '')
			{
				log_message('debug', 'save user cache: '.$user);
				$this->cache->file->save('user', $user);
			}
		}

		$data = array(
			'user' => $user,
			'pwd' => $this->input->post('pwd'),
			'email' => $this->input->post('email')
		);

		 
		$this->load->view('cache_form', $data);
	}
}

/* End of file cache_test.php */
/* Location: ./application/controllers/cache_test.php */

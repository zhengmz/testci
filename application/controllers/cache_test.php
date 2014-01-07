<?php

class Cache_test extends CI_Controller {
 
	function index()
	{
		$this->load->helper(array('form', 'url', 'html'));
		//$this->load->driver('cache', array('adapter' => 'file'));
		$this->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));

		$user = $this->input->post('user');
		//$cache_user = $this->cache->file->get('user');
		$cache_user = $this->cache->get('user');
		if ($cache_user !== FALSE)
		{
			$user = $cache_user;
		}
		else
		{
			if ($user !== FALSE)
			{
				//$this->cache->file->save('user', $user);
				$this->cache->save('user', $user);
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

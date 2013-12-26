<?php

class Cache extends CI_Controller {
 
	function index()
	{
		$this->load->helper(array('form', 'url', 'html'));
		$this->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));

		$data = array(
			'user' => '',
			'pwd' => '',
			'email' => ''
		};

		$user = $this->input->post('user');
		if ( $user !== FALSE )
		{
			if ( ! $cache_user = $this->cache->get('user'))
			{
				// cached for ten minutes.
				$this->cache->save('user', $user, 600);
			}
			else
			{
				$user = $cache_user;
			}

			$data = array(
				'user' => $user,
				'pwd' => $this->input->post('pwd'),
				'email' => $this->input->post('email')
			};
		}

		 
		$this->load->view('cache_form', $data);
	}
}

/* End of file cache.php */
/* Location: ./application/controllers/cache.php */

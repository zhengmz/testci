<?php

class Form extends CI_Controller {
 
	function index()
	{
		$this->load->helper(array('form', 'url', 'html'));
		 
		$this->load->library('form_validation');

		$this->form_validation->set_rules('username', 'Username', 'callback_username_check');
		//$this->form_validation->set_rules('username', 'Username', 'trim|required|min_length[5]|max_length[12]|xss_clean');
		$this->form_validation->set_rules('password', 'Password', 'trim|required|matches[passconf]|md5');
		$this->form_validation->set_rules('passconf', 'Password Confirmation', 'trim|required|md5');
		$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
		$this->form_validation->set_rules('mycheck[]', 'Checkbox', 'required');
		$this->form_validation->set_rules('myradio', 'Radio', 'required');
		$this->form_validation->set_rules('myselect');
		 
		$this->load->helper('captcha');
		$vals = array(
			//'word' => 'Random word',
			'img_path' => 'uploads/',
			'img_url' => 'uploads/',
			'img_width' => 120,
			'img_height' => 30,
			'expiration' => 7200
		);

		$cap = create_captcha($vals);
		$data = array('cap' => $cap);
		//echo $cap['image'];
		//echo '<br />Word is: '.$cap['word'].'<br />';

		if ($this->form_validation->run() == FALSE)
		{
			$this->load->view('form_main', $data);
		}
		else
		{
			$this->load->view('form_success');
		}
	}

	public function username_check($str)
	{
		if ($str == 'test')
		{
			$this->form_validation->set_message('username_check', 'The %s field can not be the word "test"');
			return FALSE;
		}
		else
		{
			return TRUE;
		}
	}
}

/* End of file form.php */
/* Location: ./application/controllers/form.php */

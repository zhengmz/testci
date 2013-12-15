<?php

class Upload extends CI_Controller {
 
	function __construct()
	{
		parent::__construct();
		$this->load->helper(array('form', 'url'));
	}
 
	function index()
	{ 
		$this->load->view('upload_form', array('error' => ' ' ));
	}

	function do_upload()
	{
		$this->load->service('upload_serv');
		$this->upload_serv->do_upload();
	} 
}

/* End of file upload.php */
/* Location: ./application/controllers/upload.php */

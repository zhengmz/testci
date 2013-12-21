<?php

class Upload extends CI_Controller {
 
	function __construct()
	{
		parent::__construct();
		$this->load->helper(array('form', 'url', 'download'));
	}
 
	function index()
	{ 
		$this->load->view('upload_form', array('error' => ' ' ));
/*
		$data = file_get_contents("uploads/1387625388.3449.jpg"); // 读文件内容
		$name = 'myphoto.jpg';

		force_download($name, $data);

		$data = 'Here is some text!';
		$name = 'mytext.txt';

		force_download($name, $data);
*/
	}

	function do_upload()
	{
		$this->load->service('upload_serv');
		$this->upload_serv->do_upload();
	} 
}

/* End of file upload.php */
/* Location: ./application/controllers/upload.php */

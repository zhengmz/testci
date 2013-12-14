<?php

class Ftp extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->library('ftp');
	}

	function index()
	{ 
		$config['hostname'] = '192.168.3.61';
		$config['username'] = 'zhengmz';
		$config['password'] = 'cmsz@1330';
		$config['debug'] = TRUE;

		$this->ftp->connect($config);

		$data = array('upload_data' => $this->ftp->list_files('/home/zhengmz/'));
		$this->ftp->mirror('/var/www/php/ci/uploads/', '/home/zhengmz/php/');

		$this->ftp->close();

		$this->load->view('upload_success', $data);
	}
}

/* End of file ftp.php */
/* Location: ./application/controllers/ftp.php */

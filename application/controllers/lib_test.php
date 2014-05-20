<?php

class Lib_test extends CI_Controller {

	function __construct()
	{
		parent::__construct();
	}

	function index()
	{ 
		$this->load->library('libtest');

		$this->_output('test');
	}

	function _output($output)
	{
		echo $output;
	}

	function _remap($method)
	{
		echo 'method: '.$method;
		$this->index();
	}
}

/* End of file ftp.php */
/* Location: ./application/controllers/ftp.php */

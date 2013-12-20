<?php

class Zip extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->library('zip');
	}

	function index()
	{ 
//		$name = 'mydata1.txt';
//		$data = 'A Data String!';

//		$this->zip->add_data($name, $data);
		$data = array(
			'dir1/mydata1.txt' => 'A Data String!',
			'dir2/mydata2.txt' => 'Another Data String!'
		    );

		$this->zip->add_data($data);

		// 在你的服务器的文件夹里写.zip文件。命名为"my_backup.zip"
		$this->zip->archive('uploads/my_backup.zip'); 

		// 下载此文件到桌面，命名为"my_backup.zip"
		$this->zip->download('my_backup.zip');
	}
}

/* End of file ftp.php */
/* Location: ./application/controllers/ftp.php */

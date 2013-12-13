<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pages extends CI_Controller {


	public function __construct()
	{
		parent::__construct();
		$this->load->library('input');
	}

	public function index()
	{
		$this->view('home');
	}

	public function view($page = 'home')
	{
	      
		if ( ! file_exists(APPPATH.'/views/pages/'.$page.'.php'))
		{
	  		// 页面不存在
			show_404();
		}

		$data['title'] = ucfirst($page); // 将title中的第一个字符大写
		$data['ip_address'] = $this->input->ip_address();
		$data['user_agent'] = $this->input->user_agent();
		$data['request_headers'] = $this->input->request_headers();
	  
		$this->load->view('templates/header', $data);
		$this->load->view('pages/'.$page, $data);
		$this->load->view('templates/footer', $data);
	}
}

/* End of file pages.php */
/* Location: ./application/controllers/pages.php */

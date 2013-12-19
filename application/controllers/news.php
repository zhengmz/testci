<?php
class News extends CI_Controller {

  public function __construct()
  {
    parent::__construct();
    $this->load->model('news_model');
  }

public function index(){
  $data['news'] = $this->news_model->get_news();
  $data['title'] = 'News archive';

  $this->load->view('templates/header', $data);
  $this->load->view('news/index', $data);
  $this->load->view('templates/footer', $data);

  $this->output->enable_profiler(TRUE);
}

public function page($page = 1)
{
	echo 'page = '.$page.'<br>';
	$this->load->library('pagination');

	$config['base_url'] = '/news/page/';
	$config['total_rows'] = 200;
	$config['per_page'] = 20; 
	$config['use_page_numbers'] = TRUE;

	$this->pagination->initialize($config); 

	echo $this->pagination->create_links();
}

public function view($slug){
  $data['news_item'] = $this->news_model->get_news($slug);

  if (empty($data['news_item']))
  {
    show_404();
  }

  $data['title'] = $data['news_item']['title'];

  $this->load->view('templates/header', $data);
  $this->load->view('news/view', $data);
  $this->load->view('templates/footer', $data);
}

public function create()
{
  $this->load->helper('form');
  $this->load->library('form_validation');
  
  $data['title'] = 'Create a news item';
  
  $this->form_validation->set_rules('title', 'Title', 'required|is_unique[news.title]');
  $this->form_validation->set_rules('text', 'text', 'required');
  
  if ($this->form_validation->run() === FALSE)
  {
    $this->load->view('templates/header', $data);  
    $this->load->view('news/create');
    $this->load->view('templates/footer');
    
  }
  else
  {
    $ret = $this->news_model->set_news();
    $this->load->view('templates/header', $data);  
    $this->load->view('news/success');
    $this->load->view('templates/footer');
  }
}
}

/* End of file news.php */
/* Location: ./application/controllers/news.php */

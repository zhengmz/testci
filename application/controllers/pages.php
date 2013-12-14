<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pages extends CI_Controller {


	public function __construct()
	{
		parent::__construct();
		$prefs['template'] = '
		   {table_open}<table border="0" cellpadding="2" cellspacing="10">{/table_open}
		   {heading_row_start}<tr>{/heading_row_start}
		   {heading_previous_cell}<th><a href="{previous_url}">&lt;&lt;</a></th>{/heading_previous_cell}
		   {heading_title_cell}<th colspan="{colspan}">{heading}</th>{/heading_title_cell}
		   {heading_next_cell}<th><a href="{next_url}">&gt;&gt;</a></th>{/heading_next_cell}
		   {heading_row_end}</tr>{/heading_row_end}
		   {week_row_start}<tr>{/week_row_start}
		   {week_day_cell}<td>{week_day}</td>{/week_day_cell}
		   {week_row_end}</tr>{/week_row_end}
		   {cal_row_start}<tr>{/cal_row_start}
		   {cal_cell_start}<td>{/cal_cell_start}
		   {cal_cell_content}<a href="{content}">{day}</a>{/cal_cell_content}
		   {cal_cell_content_today}<div class="highlight"><a href="{content}">{day}</a></div>{/cal_cell_content_today}
		   {cal_cell_no_content}{day}{/cal_cell_no_content}
		   {cal_cell_no_content_today}<div class="highlight">{day}</div>{/cal_cell_no_content_today}
		   {cal_cell_blank}&nbsp;{/cal_cell_blank}
		   {cal_cell_end}</td>{/cal_cell_end}
		   {cal_row_end}</tr>{/cal_row_end}
		   {table_close}</table>{/table_close}
		';
		$prefs['show_next_prev'] = TRUE;
		$prefs['next_prev_url'] = 'page';

		$this->load->library('calendar', $prefs);
		//$this->load->library('calendar');

		$this->load->library('table');
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
		$tmpl = array (
			    'table_open'          => '<table border="1" cellpadding="4" cellspacing="1" class="mytable">',

			    'heading_row_start'   => '<tr>',
			    'heading_row_end'     => '</tr>',
			    'heading_cell_start'  => '<th>',
			    'heading_cell_end'    => '</th>',

			    'row_start'           => '<tr>',
			    'row_end'             => '</tr>',
			    'cell_start'          => '<td>',
			    'cell_end'            => '</td>',

			    'row_alt_start'       => '<tr>',
			    'row_alt_end'         => '</tr>',
			    'cell_alt_start'      => '<td>',
			    'cell_alt_end'        => '</td>',

			    'table_close'         => '</table>'
		      );

		$this->table->set_template($tmpl);
		$this->table->set_caption('Colors');
	  	$tbl_data = array(
		     array('Name', 'Color', 'Size'),
		     array('Fred', 'Blue', 'Small'),
		     array('Mary', 'Red', 'Large'),
		     array('John', 'Green', 'Medium') 
		     );

		$data['table'] =  $this->table->generate($tbl_data);
		$data['calendar'] = $this->calendar->generate(2013,12);
		$data['site_url'] = $this->config->site_url();
		$data['base_url'] = $this->config->base_url();
		$data['system_url'] = $this->config->system_url();

		//$data['title'] = ucfirst($page); // 将title中的第一个字符大写
		$data['ip_address'] = $this->input->ip_address();
		$data['user_agent'] = $this->input->user_agent();
		$data['request_headers'] = implode(",", $this->input->request_headers());
		$data = array(
			'data_arr' => $data,
			'title' => ucfirst($page)
		);
	  
		$this->load->view('templates/header', $data);
		$this->load->view('pages/'.$page, $data);
		$this->load->view('templates/footer', $data);
	}
}

/* End of file pages.php */
/* Location: ./application/controllers/pages.php */

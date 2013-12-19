<?php  if ( ! defined('APPPATH')) exit('No direct script access allowed');

class Blog extends CI_Controller {
 
	function index()
	{
		$this->load->library('parser');

		$data = array(
			    'blog_title' => 'My Blog Title',
			    'blog_heading' => 'My Blog Heading',
			    'blog_entries' => array(
				array('title' => 'Title 1', 'body' => 'Body 1'),
				array('title' => 'Title 2', 'body' => 'Body 2'),
				array('title' => 'Title 3', 'body' => 'Body 3'),
				array('title' => 'Title 4', 'body' => 'Body 4'),
				array('title' => 'Title 5', 'body' => 'Body 5')
                                      )
			    );

		$this->parser->parse('blog_template', $data);

$this->load->library('user_agent');

$agent = '';
if ($this->agent->is_browser())
{
    $agent = $agent.'<br />is_browser: '.$this->agent->browser().' '.$this->agent->version();
}
if ($this->agent->is_robot())
{
    $agent = $agent.'<br />is_robot: '.$this->agent->robot();
}
if ($this->agent->is_mobile())
{
    $agent = $agent.'<br />is_mobile: '.$this->agent->mobile();
}
if ($agent == '')
{
    $agent = 'Unidentified User Agent';
}

echo $agent.'<br />';

echo $this->agent->platform().'<br />';
	}

	function news()
	{
    		$this->load->database();
		$query = $this->db->query("SELECT title, text as body FROM news");

		$this->load->library('parser');

		$data = array(
			      'blog_title'   => 'My Blog Title',
			      'blog_heading' => 'My Blog Heading',
			      'blog_entries' => $query->result_array()
			    );

		$this->parser->parse('blog_template', $data);
	}
}

/* End of file blog.php */
/* Location: ./application/controllers/blog.php */

<?php  if ( ! defined('APPPATH')) exit('No direct script access allowed');

class Blog extends CI_Controller {
 
	function index($blog_entries = '')
	{
		$this->load->library('parser');

		if ($blog_entries == '')
		{
			$blog_entries = array(
				array('title' => 'Title 1', 'body' => 'Body 1'),
				array('title' => 'Title 2', 'body' => 'Body 2'),
				array('title' => 'Title 3', 'body' => 'Body 3'),
				array('title' => 'Title 4', 'body' => 'Body 4'),
				array('title' => 'Title 5', 'body' => 'Body 5')
			)
		}
		$data = array(
			    'blog_title' => 'My Blog Title',
			    'blog_heading' => 'My Blog Heading',
			    'blog_entries' => $blog_entries
			    );

		$this->parser->parse('blog_template', $data);

		$this->load->library('user_agent');
		if ($this->agent->is_browser())
		{
		    $agent = $this->agent->browser().' '.$this->agent->version();
		}
		elseif ($this->agent->is_robot())
		{
		    $agent = $this->agent->robot();
		}
		elseif ($this->agent->is_mobile())
		{
		    $agent = $this->agent->mobile();
		}
		else
		{
		    $agent = 'Unidentified User Agent';
		}

		echo $agent;

		echo $this->agent->platform(); // Platform info (Windows, Linux, Mac, etc.)
	}

	function news()
	{
    		$this->load->database();
		$query = $this->db->query("SELECT title, text as body FROM news");
		$this->index($query->result_array());
	}
}

/* End of file blog.php */
/* Location: ./application/controllers/blog.php */

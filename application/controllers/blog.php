<?php  if ( ! defined('APPPATH')) exit('No direct script access allowed');

class Blog extends CI_Controller {
 
	function index($blog_title = '', $blog_heading = '', $blog_entries = '')
	{
		$this->load->library('parser');

		if ($blog_title == '')
		{
			$blog_title = 'My Blog Title';
		}

		if ($blog_heading == '')
		{
			$blog_heading = 'My Blog Heading';
		}

		$blog_body_1 = 'Body 1
			adsfdsfadsf
			asdfadsfdsafdsa
			adsfadsfadsf
			adsfdsafdsafds
			adsfsadfdsaf
			asdfasdf';
		$blog_body_2 = 'Body 2
			adsfdsfadsf
			asdfadsfdsafdsa
			adsfadsfadsf
			adsfdsafdsafds
			adsfsadfdsaf
			asdfasdf';
		$blog_body_3 = 'Body 3
			adsfdsfadsf
			asdfadsfdsafdsa
			adsfadsfadsf
			adsfdsafdsafds
			adsfsadfdsaf
			asdfasdf';
		$blog_body_4 = 'Body 4
			adsfdsfadsf
			asdfadsfdsafdsa
			adsfadsfadsf
			adsfdsafdsafds
			adsfsadfdsaf
			asdfasdf';
		$blog_body_5 = 'Body 5
			adsfdsfadsf
			asdfadsfdsafdsa
			adsfadsfadsf
			adsfdsafdsafds
			adsfsadfdsaf
			asdfasdf';
		if ($blog_entries == '')
		{
			$blog_entries = array(
				array('title' => 'Title 1', 'body' => $blog_body_1),
				array('title' => 'Title 2', 'body' => $blog_body_2),
				array('title' => 'Title 3', 'body' => $blog_body_3),
				array('title' => 'Title 4', 'body' => $blog_body_4),
				array('title' => 'Title 5', 'body' => $blog_body_5)
			);
/*
			$blog_entries = array(
				array('title' => 'Title 1', 'body' => 'Body 1'),
				array('title' => 'Title 2', 'body' => 'Body 2'),
				array('title' => 'Title 3', 'body' => 'Body 3'),
				array('title' => 'Title 4', 'body' => 'Body 4'),
				array('title' => 'Title 5', 'body' => 'Body 5')
			);
*/
		}

		$data = array(
			    'blog_title' => $blog_title,
			    'blog_heading' => $blog_heading,
			    'blog_entries' => $blog_entries
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

if ($this->agent->is_referral())
{
    echo $this->agent->referrer().'<br />';
}
echo $this->agent->agent_string().'<br />';
	}

	function news()
	{
    		$this->load->database();
		$query = $this->db->query("SELECT title, text as body FROM news");

		$this->index('My News Title', 'My News Heading', $query->result_array());

/*
		$this->load->library('parser');

		$data = array(
			      'blog_title'   => 'My Blog Title',
			      'blog_heading' => 'My Blog Heading',
			      'blog_entries' => $query->result_array()
			    );

		$this->parser->parse('blog_template', $data);
*/
	}
}

/* End of file blog.php */
/* Location: ./application/controllers/blog.php */

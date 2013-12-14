<?php

class Form extends CI_Controller {
 
 function index()
 {
  $this->load->helper(array('form', 'url'));
  
  $this->load->library('form_validation');

  $this->form_validation->set_rules('username', 'Username', 'callback_username_check');
//  $this->form_validation->set_rules('username', 'Username', 'trim|required|min_length[5]|max_length[12]|xss_clean');
  $this->form_validation->set_rules('password', 'Password', 'trim|required|matches[passconf]|md5');
  $this->form_validation->set_rules('passconf', 'Password Confirmation', 'trim|required|md5');
  $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
  $this->form_validation->set_rules('mycheck[]', 'Checkbox', 'required');
  $this->form_validation->set_rules('myradio', 'Radio', 'required');
  $this->form_validation->set_rules('myselect');
 
  if ($this->form_validation->run() == FALSE)
  {
   $this->load->view('form_main');
  }
  else
  {
   $this->load->view('form_success');
  }
 }

 public function username_check($str)
 {
  if ($str == 'test')
  {
   $this->form_validation->set_message('username_check', 'The %s field can not be the word "test"');
   return FALSE;
  }
  else
  {
   return TRUE;
  }
 }
}

/* End of file form.php */
/* Location: ./application/controllers/form.php */

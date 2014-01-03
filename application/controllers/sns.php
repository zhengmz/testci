<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Sns extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->library('session');
		$this->load->helper('url');
	}

	public function index()
	{
		$this->config->load('oauth2');
                $data['user'] = $this->session->userdata('user');
		$this->load->view('sns_view', $data);
	}

	public function logout()
	{
		$this->session->sess_destroy();
		$this->session->set_userdata('is_login', FALSE);
		redirect('sns');
	}

	public function session($provider = '')
	{
		$this->config->load('oauth2');
		$allowed_providers = $this->config->item('oauth2');
		if ( ! $provider OR ! isset($allowed_providers[$provider]))
		{
			$this->session->set_flashdata('info', '暂不支持'.$provider.'方式登录.');
			redirect();
			return;
		}
		$this->load->library('oauth2');
		$provider = $this->oauth2->provider($provider, $allowed_providers[$provider]);
		$args = $this->input->get();
		if ($args AND !isset($args['code']))
		{
			$this->session->set_flashdata('info', '授权失败了,可能由于应用设置问题或者用户拒绝授权.<br />具体原因:<br />'.json_encode($args));
		    redirect('sns');
		    return;
		}
		$code = $this->input->get('code', TRUE);
		if ( ! $code)
		{
			try
			{
			         $provider->authorize();
			}
			catch (OAuth2_Exception $e)
			{
                  		$this->session->set_flashdata('info', '操作失败<pre>'.$e.'</pre>');
			}
		}
		else
		{
			try
			{
				$token = $provider->access($code);
				$sns_user = $provider->get_user_info($token);
				if (is_array($sns_user))
				{
					$this->session->set_flashdata('info', '登录成功');
					$this->session->set_userdata('user', $sns_user);
					$this->session->set_userdata('is_login', TRUE);
				}
				else
				{
					$this->session->set_flashdata('info', '获取用户信息失败');
				}
			}
			catch (OAuth2_Exception $e)
			{
				$this->session->set_flashdata('info', '操作失败<pre>'.$e.'</pre>');
			}
		}
		redirect('sns');
	}
}

/* End of file sns.php */
/* Location: ./application/controllers/sns.php */

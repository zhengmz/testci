<?php defined('APPPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller
{
    public function session($provider)
    {
        $this->load->helper('url_helper');

	$this->load->library('OAuth2');

        $provider = $this->oauth2->provider($provider, array(
            'id' => '100577935',
            'secret' => '7d83d74c2a58f6a51c7ca8d47d154fcb',
        ));

        if ( ! $this->input->get('code'))
        {
            // By sending no options it'll come back here
            $provider->authorize();
        }
        else
        {
            // Howzit?
            try
            {
                $token = $provider->access($_GET['code']);

                $user = $provider->get_user_info($token);

                // Here you should use this information to A) look for a user B) help a new user sign up with existing data.
                // If you store it all in a cookie and redirect to a registration page this is crazy-simple.
                echo "<pre>Tokens: ";
                var_dump($token);

                echo "\n\nUser Info: ";
                var_dump($user);
            }

            catch (OAuth2_Exception $e)
            {
                show_error('That didnt work: '.$e);
            }

        }
    }
}

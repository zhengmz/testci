<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

 /**
  * Oauth2 SocialAuth for CodeIgniter
  * 微信 Provider
  * 
  * @author     chekun <234267695@qq.com>
  */

class OAuth2_Provider_Weixin extends OAuth2_Provider
{
	public $name = 'weixin';

	public $human = '微信';

	public $uid_key = 'uid';

	public $method = 'POST';
 
	public function url_authorize()
	{
		return 'https://open.weixin.qq.com/oauth';
	}

	public function url_access_token()
	{
		return 'https://api.weixin.qq.com/token.format';
	}

	public function get_user_info(OAuth2_Token_Access $token)
	{

		$url = 'https://api.weixin.qq.com/cgi-bin/user/info?'.http_build_query(array(
			'access_token' => $token->access_token,
			'openid' => $token->openid
		));
		$user = json_decode(file_get_contents($url));

      	if (array_key_exists("error", $user))
        {
        	throw new OAuth2_Exception((array) $user);
        }

		// Create a response from the request
		return array(
            'via' => 'weibo',
			'uid' => $user->id,
			'screen_name' => $user->screen_name,
			'name' => $user->name,
			'location' => $user->location,
			'description' => $user->description,
			'image' => $user->profile_image_url,
			'access_token' => $token->access_token,
			'expire_at' => $token->expires,
			'refresh_token' => $token->refresh_token
		);
	}
}

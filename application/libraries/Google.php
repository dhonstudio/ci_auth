<?php

use Google\Service\Oauth2;

 defined('BASEPATH') OR exit('No direct script access allowed');

/*
 * Login with Google for Codeigniter
 *
 * Library for Codeigniter to authenticate users through Google OAuth 2.0 and get user profile info
 *
 * @authors     Harsha G, Nick Humphries
 * @license     MIT
 * @link        https://github.com/angel-of-death/Codeigniter-Google-OAuth-Login
 */

class Google {
	public function __construct()
	{
		$this->ci =& get_instance();

        include_once __DIR__ . '/../../vendor/autoload.php';

		/*
        | -------------------------------------------------------------------
        | Don't forget to create google_helper.php on folder helpers
        | -------------------------------------------------------------------
        | Prototype:
        |
        | <?php
        | 
        | $ci = get_instance();
		|
		| $redirectUri = ENVIRONMENT == 'development' ? 'http://local_url' : 'https://redirect_url';
		|
		| $ci->google_config = [
		| 	'applicationName'	=> 'Dhon Studio',
        | 	'clientId'	        => 'number-hash.apps.googleusercontent.com',
        | 	'clientSecret'	    => 'hashSecret',
        | 	'redirectUri'	    => $redirectUri,
        | 	'apiKey'	        => 'hashApiKey-us',
        | 	'scopes'	        => [],
        */
		$this->ci->load->helper('google');

		$this->ci->load->library('session');

		$this->client = new Google_Client();
        $this->client->setApplicationName($this->ci->google_config['applicationName']);

        $this->client->setClientId($this->ci->google_config['clientId']);
        $this->client->setClientSecret($this->ci->google_config['clientSecret']);
        $this->client->setRedirectUri($this->ci->google_config['redirectUri']);
        $this->client->setDeveloperKey($this->ci->google_config['apiKey']);

        $this->client->addScope(array(
			"https://www.googleapis.com/auth/plus.login",
			"https://www.googleapis.com/auth/userinfo.email",
			"https://www.googleapis.com/auth/userinfo.profile",
			"https://www.googleapis.com/auth/plus.me",
		));
        $this->client->setAccessType('online');

		if($this->ci->session->userdata('refreshToken')!=null)
		{
			$this->loggedIn = true;

			if($this->client->isAccessTokenExpired())
			{
				$this->client->refreshToken($this->ci->session->userdata('refreshToken'));
        		
        		$accessToken = $this->client->getAccessToken();

        		$this->client->setAccessToken($accessToken);
			}
		}
		else
		{
			$accessToken = $this->client->getAccessToken();

			if($accessToken!=null)
			{
				$this->client->revokeToken($accessToken);
			}

			$this->loggedIn = false;
		}
	}

	public function listAll()
	{
		$results = $this->service->files->listFiles();

		foreach ($results->getFiles() as $filed) {
			echo $filed->getID().'<br>';
		}
	}

	public function fetchAccessToken($code)
	{
		return $this->client->fetchAccessTokenWithAuthCode($code);
	}

	public function isLoggedIn()
	{
		return $this->loggedIn;
	}

	public function getLoginUrl()
	{
		return $this->client->createAuthUrl();
	}

	public function setAccessToken()
	{
		$this->client->authenticate($_GET['code']);

		$accessToken = $this->client->getAccessToken();

		$this->client->setAccessToken($accessToken);

		if(isset($accessToken['refresh_token']))
		{
			$this->ci->session->set_userdata('refreshToken', $accessToken['refresh_token']);
		}
	}

	public function setToken($token)
	{
		$this->client->setAccessToken($token);
	}

	public function getAccessToken()
	{
		return $this->client->getAccessToken();
	}

	public function getUserInfo()
	{
		$service = new Oauth2($this->client);

		return $service->userinfo->get();
	}

	public function logout()
	{
		$this->ci->session->unset_userdata('refreshToken');

		$accessToken = $this->client->getAccessToken();

		if($accessToken!=null)
		{
			$this->client->revokeToken($accessToken);
		}
	}
}

?>
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {
    


	public function index()
	{
        $data = [
            'lang'          => 'en',
            'title'         => 'SB Admin 2 - Login',
            'css'           => [
				$this->css['sb-admin'],
			],
            'body_class'    => 'bg-primary',
            'js'            => [
                $this->js['fontawesome5'],
                $this->js['bootstrap-bundle5'],
            ],
        ];

		$this->load->view('templates/header', $data);
		$this->load->view('auth');
		$this->load->view('templates/copyright');
		$this->load->view('templates/footer');
	}
}

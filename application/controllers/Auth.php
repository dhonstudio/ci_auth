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

    public function register()
	{
        $this->form_validation->set_rules('firstName', 'First Name', 'required|trim|alpha|min_length[2]|max_length[99]');
        $this->form_validation->set_rules('lastName', 'Last Name', 'required|trim|alpha|min_length[2]|max_length[100]');
        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email|max_length[255]');
        $this->form_validation->set_rules('password', 'Password', 'required|trim|min_length[3]|max_length[20]');
        $this->form_validation->set_rules('repeat_password', 'Repeat Password', 'required|trim|matches[password]');

		if($this->form_validation->run() == false) {
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
            $this->load->view('register');
            $this->load->view('templates/copyright');
            $this->load->view('templates/footer');
        } else {
            
        }
	}
}

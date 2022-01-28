<?php
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Asia/Jakarta');

class Auth extends CI_Controller {
    
    public function __construct()
	{
		parent::__construct();

        require_once __DIR__ . '/../../assets/ci_helpers/style_helper.php';
        require_once __DIR__ . '/../../assets/ci_libraries/DhonAPI.php';
        $this->dhonapi = new DhonAPI;
        $this->dhonapi->api_url['development'] = 'http://localhost/ci_api/api/';
        $this->dhonapi->username = 'admin';
        $this->dhonapi->password = 'admin';
	}

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
        if (!isset($_POST['status'])) {
            $this->form_validation->set_rules('firstName', 'First Name', 'required|trim|alpha|min_length[2]|max_length[99]');
            $this->form_validation->set_rules('lastName', 'Last Name', 'required|trim|alpha|min_length[2]|max_length[100]');
            $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email|max_length[255]');
            $this->form_validation->set_rules('password', 'Password', 'required|trim|min_length[3]|max_length[20]');
            $this->form_validation->set_rules('repeat_password', 'Repeat Password', 'required|trim|matches[password]');
        }

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
                    $this->js['jquery36'],
                ],
            ];

            $this->load->view('templates/header', $data);
            $this->load->view('register');
            $this->load->view('templates/copyright');
            $this->load->view('templates/footer');
            if (isset($_POST['status']) && $_POST['status'] == 'failed') $this->load->view('ci_scripts/toast_show', ['toast_id' => 'email_duplicate']);
            $this->load->view('templates/end');
        } else {
            $users      = $this->dhonapi->get('project', 'user');
            $emails     = array_column($users, 'email');
            if (in_array($this->input->post('email'), $emails)) {
                redirect('auth/redirect_post?action=auth/register&post_name=status&post_value=failed');
            } else {

            }
        }
	}

    public function redirect_post()
    {
        $data = [
            'action'        => $_GET['action'],
            'post_name'     => $_GET['post_name'],
            'post_value'    => $_GET['post_value'],
        ];

        $this->load->view('templates/redirect_post', $data);
    }
}

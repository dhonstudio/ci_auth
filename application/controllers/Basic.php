<?php
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Asia/Jakarta');

class Basic extends CI_Controller {
    
    public function __construct()
	{
		parent::__construct();

        /*
        | -------------------------------------------------------------------
        |  Set up db and table default
        | -------------------------------------------------------------------
        */
        $this->database = ENVIRONMENT == 'testing' ? 'project_dev' : 'project';
        $this->table    = 'user_ci';

        /*
        | -------------------------------------------------------------------
        |  Set up Cookie and Auth Service section
        | -------------------------------------------------------------------
        */
        if (ENVIRONMENT == 'development') {
            $this->cookie_prefix    = 'm';
            $this->auth_redirect    = 'http://localhost/ci_dashboard';
        } else if (ENVIRONMENT == 'testing') {
            $this->cookie_prefix    = 'm';
            $this->auth_redirect    = 'http://dev.dhonstudio.com/ci/dashboard';
        } else {
            $this->cookie_prefix    = '__Secure-';
            $this->auth_redirect    = 'https://dhonstudio.com/ci/dashboard';
        }
        $this->secure_prefix    = 'DSC250222s';
        $this->secure_auth      = "DSA250222k";

        /*
        | -------------------------------------------------------------------
        |  Set up features
        | -------------------------------------------------------------------
        */
        $this->load->helper('basic');

        /*
        | -------------------------------------------------------------------
        |  Set up toasts
        | -------------------------------------------------------------------
        */
        $this->toasts = [
            [
                'id'        => 'email_duplicate',
                'title'     => 'Failed',
                'message'   => 'Email address is already registered'
            ],
            [
                'id'        => 'registration_success',
                'delay'     => 10000,
                'title'     => 'Success',
                'message'   => 'Registration successfully, please verify your account by link sent to your email'
            ],
            [
                'id'        => 'registration_failed',
                'delay'     => 10000,
                'title'     => 'Failed',
                'message'   => 'Registration failed, please repeat your registration'
            ],
            [
                'id'        => 'verify_success',
                'title'     => 'Success',
                'message'   => 'Verification success, please login'
            ],
            [
                'id'        => 'verify_failed',
                'title'     => 'Failed',
                'message'   => 'Verification failed, please contact admin'
            ],
            [
                'id'        => 'forgot_success',
                'delay'     => 10000,
                'title'     => 'Success',
                'message'   => 'Success, please reset password by link sent to your email'
            ],
            [
                'id'        => 'forgot_failed',
                'title'     => 'Failed',
                'message'   => 'Failed, please contact admin'
            ],
            [
                'id'        => 'reset_success',
                'title'     => 'Success',
                'message'   => 'Password successfully changed, please login'
            ],
            [
                'id'        => 'login_failed',
                'title'     => 'Failed',
                'message'   => 'Login Failed'
            ],
        ];

        $this->toast_id = isset($_POST['status']) ? $_POST['status'] : '';

        $this->version  = isset($_GET['version']) ? $_GET['version'] : (isset($_POST['version']) ? $_POST['version'] : '');
    }

    public function register()
	{
        // if (!isset($_POST['status'])) {
        //     $this->form_validation->set_rules('firstName', 'First Name', 'required|trim|alpha|min_length[2]|max_length[99]');
        //     $this->form_validation->set_rules('lastName', 'Last Name', 'required|trim|alpha|min_length[2]|max_length[100]');
        //     $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email|max_length[255]');
        //     $this->form_validation->set_rules('password', 'Password', 'required|trim|min_length[3]|max_length[20]');
        //     $this->form_validation->set_rules('repeat_password', 'Repeat Password', 'required|trim|matches[password]');
        // }

        /*
        | -------------------------------------------------------------------
        |  Set up title and bg color
        | -------------------------------------------------------------------
        */
        $title      = 'SB Admin '.$this->version.' - Register';
        $bg_color   = 'success';

		if($this->form_validation->run() == false) {
            $js = [
                $this->js['jquery36'],
                $this->js['bootstrap-bundle5'],
            ];

            if ($this->version == '') {
                $font       = [];
                $css        = [
                    $this->css['sb-admin'],
                ];
                $body_class = 'bg-'.$bg_color;
            } else if ($this->version == '2') {
                $font       = [
                    $this->font['google-Nunito'],
                ];
                $css        = [
                    $this->css['fontawesome5'],
                    $this->css['bootstrap5'],
                    $this->css['sb-admin-2'],
                ];
                $js         = array_merge($js, [
                    $this->js['jquery-easing'],
                    $this->js['sb-admin-2'],
                ]);
                $body_class = 'bg-gradient-'.$bg_color;
            }

            $data = [
                'title'         => $title,
                'font'          => $font,
                'css'           => $css,
                'js'            => $js,
                'body_class'    => $body_class,                
            ];

            $this->load->view('ci_templates/header', $data);
            $this->load->view('register'.$this->version);
            $this->load->view('copyright');
            $this->load->view('ci_templates/toast', ['toasts' => $this->toasts]);
            $this->load->view('ci_scripts/toast_show', ['toast_id' => $this->toast_id]);
            $this->load->view('ci_templates/end');
        } else {
            $users      = $this->dhonapi->get($this->database, $this->table);
            $emails     = array_column($users, 'email');
            if (in_array($this->input->post('email'), $emails)) {
                redirect('auth/redirect_post?action=auth/register&post_name1=status&post_value1=email_duplicate&post_name2=firstName&post_value2='.$this->input->post('firstName').'&post_name3=lastName&post_value3='.$this->input->post('lastName').'&post_name4=email&post_value4='.$this->input->post('email').'&post_name5=version&post_value5='.$_GET['version']);
            } else {
                $token  = base64_encode(random_bytes(32));

                // $this->_sendEmail($token, 'verify');

                $this->dhonapi->post($this->database, $this->table, [
                    'email'                 => $this->input->post('email'),
                    'fullName'              => $this->input->post('firstName').' '.$this->input->post('lastName'),
                    'auth_key'              => random_string('alnum', 32),
                    'password_hash'         => password_hash($this->input->post('password'), PASSWORD_DEFAULT),
                    'created_at'            => time(),
                    'verification_token'    => $token,
                    'status'                => 9,
                ]);

                redirect('auth/redirect_post?action=auth&post_name1=status&post_value1=registration_success&post_name2=version&post_value2='.$_GET['version']);
            }
        }
	}
}
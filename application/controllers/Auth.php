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
        require_once __DIR__ . '/../../assets/ci_libraries/DhonEmail.php';
        $this->dhonemail = new DhonEmail;

        $this->dhonapi->api_url['development'] = 'http://localhost/ci_api/';
        $this->dhonapi->api_url['production'] = 'https://dhonstudio.com/ci/api/';
        $this->dhonapi->username = 'admin';
        $this->dhonapi->password = 'admin';

        $this->lang = 'en';
	}

	public function index()
	{
        if (!isset($_POST['status'])) {
            $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email');
            $this->form_validation->set_rules('password', 'Password', 'required|trim');
        }

        if($this->form_validation->run() == false) {
            $data = [
                'title'         => 'SB Admin - Login',
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

            $this->load->view('ci_templates/header', $data);
            $this->load->view('auth');
            $this->load->view('ci_templates/toast');
            $this->load->view('copyright');
            $this->load->view('ci_templates/footer');
            if (isset($_POST['status']) && $_POST['status'] == 'registration_success') $this->load->view('ci_scripts/toast_show', ['toast_id' => 'registration_success']);
            if (isset($_POST['status']) && $_POST['status'] == 'registration_failed') $this->load->view('ci_scripts/toast_show', ['toast_id' => 'registration_failed']);
            if (isset($_POST['status']) && $_POST['status'] == 'verify_success') $this->load->view('ci_scripts/toast_show', ['toast_id' => 'verify_success']);
            if (isset($_POST['status']) && $_POST['status'] == 'verify_failed') $this->load->view('ci_scripts/toast_show', ['toast_id' => 'verify_failed']);
            if (isset($_POST['status']) && $_POST['status'] == 'forgot_success') $this->load->view('ci_scripts/toast_show', ['toast_id' => 'forgot_success']);
            if (isset($_POST['status']) && $_POST['status'] == 'forgot_failed') $this->load->view('ci_scripts/toast_show', ['toast_id' => 'forgot_failed']);
            if (isset($_POST['status']) && $_POST['status'] == 'reset_success') $this->load->view('ci_scripts/toast_show', ['toast_id' => 'reset_success']);
            if (isset($_POST['status']) && $_POST['status'] == 'failed') $this->load->view('ci_scripts/toast_show', ['toast_id' => 'login_failed']);
            $this->load->view('ci_templates/end');
        } else {
            $user = $this->dhonapi->get('project', 'user', ['email' => $this->input->post('email')]);
            if ($user && password_verify($this->input->post('password'), $user[0]['password_hash']) && $user[0]['status'] > 9) {
                redirect('https://dhonstudio.com/ci/dashboard');
            } else {
                redirect('auth/redirect_post?action=auth&post_name=status&post_value=failed');
            }
        }
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
                'title'         => 'SB Admin - Register',
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

            $this->load->view('ci_templates/header', $data);
            $this->load->view('register');
            $this->load->view('ci_templates/toast');
            $this->load->view('copyright');
            $this->load->view('ci_templates/footer');
            if (isset($_POST['status']) && $_POST['status'] == 'email_duplicate') $this->load->view('ci_scripts/toast_show', ['toast_id' => 'email_duplicate']);
            $this->load->view('ci_templates/end');
        } else {
            $users      = $this->dhonapi->get('project', 'user');
            $emails     = array_column($users, 'email');
            if (in_array($this->input->post('email'), $emails)) {
                redirect('auth/redirect_post?action=auth/register&post_name=status&post_value=email_duplicate');
            } else {
                $token  = base64_encode(random_bytes(32));

                $this->_sendEmail($token, 'verify');

                $this->dhonapi->post('project', 'user', [
                    'fullName'              => $this->input->post('firstName').' '.$this->input->post('lastName'),
                    'email'                 => $this->input->post('email'),
                    'username'              => $this->input->post('email'),
                    'password_hash'         => password_hash($this->input->post('password'), PASSWORD_DEFAULT),
                    'created_at'            => time(),
                    'updated_at'            => time(),
                    'verification_token'    => $token,
                    'status'                => 9,
                ]);

                redirect('auth/redirect_post?action=auth&post_name=status&post_value=registration_success');
            }
        }
	}

    public function forgot_password()
	{
        if (!isset($_POST['status'])) {
            $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email');
        }

		if($this->form_validation->run() == false) {
            $data = [
                'title'         => 'SB Admin - Forgot Password',
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

            $this->load->view('ci_templates/header', $data);
            $this->load->view('forgot_password');
            $this->load->view('ci_templates/toast');
            $this->load->view('copyright');
            $this->load->view('ci_templates/footer');
            if (isset($_POST['status']) && $_POST['status'] == 'forgot_failed') $this->load->view('ci_scripts/toast_show', ['toast_id' => 'forgot_failed']);
            $this->load->view('ci_templates/end');
        } else {
            $user = $this->dhonapi->get('project', 'user', ['email' => $this->input->post('email')]);
            if ($user && $user[0]['status'] > 9) {
                $token  = base64_encode(random_bytes(32));

                $this->_sendEmail($token, 'forgot');

                $this->dhonapi->post('project', 'user', [
                    'id'                    => $user[0]['id'],
                    'password_reset_token'  => $token,
                    'status'                => 11,
                ]);

                redirect('auth/redirect_post?action=auth&post_name=status&post_value=forgot_success');
            } else {
                redirect('auth/redirect_post?action=auth/forgot_password&post_name=status&post_value=forgot_failed');
            }
        }
	}

    private function _sendEmail(string $token, string $type)
    {
        /*
        | -------------------------------------------------------------------
        | Please create email_config_helper.php on folder helpers
        | -------------------------------------------------------------------
        | Prototype:
        |
        | <?php
        | 
        | $ci = get_instance();
        | 
        | $ci->email_config = [
        |     'protocol'	=> 'smtp',
        |     'smtp_host'	=> 'ssl://srv.hosting.com',
        |     'smtp_user'	=> 'user@domain.com',
        |     'smtp_pass'	=> 'password',
        |     'smtp_port'	=> 465,
        |     'mailtype'	=> 'html',
        |     'charset'	=> 'utf-8',
        |     'newline'	=> "\r\n",
        |     'wordwrap'	=> TRUE,
        | ];
        */
        
        $this->load->helper('email_config');

        $this->email->initialize($this->email_config);
		$this->email->from('no-reply@dhonstudio.com', 'Dhon Studio');
		$this->email->to($this->input->post('email'));
		$this->email->cc('dhonstudio@yahoo.com');

        if ($type == 'verify') {
            $this->email->subject("Account Verification");
            $this->dhonemail->message(
                "Account Verification", 
                'https://dhonstudio.com/assets/img/logo.png', 
                $this->input->post('firstName').' '.$this->input->post('lastName'), 
                "Please verify your account by follow this link.<br>
                Link has expired in 24 hour.",
                [
                    'href' => base_url('auth/verify?email='.$this->input->post('email').'&token='.urlencode($token)),
                    'text' => 'Verify'
                ],
                'Add no-reply@dhonstudio.com to prevent our email mark as SPAM. If our email mark as SPAM, please mark as not SPAM.',
                'Dhon Studio',
                'https://wa.me/6287700889913'
            );

            $fail_redirect = 'auth/redirect_post?action=auth&post_name=status&post_value=registration_failed';
        } else if ($type == 'forgot') {
            $fullName = $this->dhonapi->get('project', 'user', ['email' => $this->input->post('email')])[0]['fullName'];
            $this->email->subject("Reset Password");
            $this->dhonemail->message(
                "Reset Password", 
                'https://dhonstudio.com/assets/img/logo.png', 
                $fullName, 
                "To reset your password, please follow this link.<br>
                Link has expired in 24 hour.",
                [
                    'href' => base_url('auth/reset_password?email='.$this->input->post('email').'&token='.urlencode($token)),
                    'text' => 'Reset Password'
                ],
                'Add no-reply@dhonstudio.com to prevent our email mark as SPAM. If our email mark as SPAM, please mark as not SPAM.',
                'Dhon Studio',
                'https://wa.me/6287700889913'
            );

            $fail_redirect = 'auth/redirect_post?action=auth/forgot_password&post_name=status&post_value=forgot_failed';
        }

        if($this->email->send()) {
			return true;
		} else {
			redirect($fail_redirect);
			die;
		}
    }

    public function verify()
    {
        $expired    = time() - (60*60*24);
        $match      = $this->dhonapi->get('project', 'user', [
            'email'                 => $this->input->get('email'), 
            'verification_token'    => $this->input->get('token'),
            'status'                => 9
        ]);
        if ($match) {
            if ($match[0]['created_at'] > $expired) {
                $this->dhonapi->post('project', 'user', ['status' => 10, 'id' => $match[0]['id']]);
                redirect('auth/redirect_post?action=auth&post_name=status&post_value=verify_success');
            } else {
                $this->dhonapi->delete('project', 'user', $match[0]['id']);
                redirect('auth/redirect_post?action=auth&post_name=status&post_value=verify_failed');
            }
        } else {
            redirect('auth/redirect_post?action=auth&post_name=status&post_value=verify_failed');
        }
    }

    public function reset_password()
    {
        $expired    = time() - (60*60*24);
        $match      = $this->dhonapi->get('project', 'user', [
            'email'                 => $this->input->get('email'), 
            'password_reset_token'  => $this->input->get('token'),
            'status'                => 11,
            'created_at__more'      => $expired,
        ]);
        if ($match) {
            if (!isset($_POST['status'])) {
                $this->form_validation->set_rules('password', 'Password', 'required|trim|min_length[3]|max_length[20]');
                $this->form_validation->set_rules('repeat_password', 'Repeat Password', 'required|trim|matches[password]');
            }

            if($this->form_validation->run() == false) {
                $data = [
                    'title'         => 'SB Admin - Reset Password',
                    'css'           => [
                        $this->css['sb-admin'],
                    ],
                    'body_class'    => 'bg-primary',
                    'js'            => [
                        $this->js['fontawesome5'],
                        $this->js['bootstrap-bundle5'],
                        $this->js['jquery36'],
                    ],

                    'email' => $this->input->get('email'),
                    'token' => $this->input->get('token'),
                ];
    
                $this->load->view('ci_templates/header', $data);
                $this->load->view('reset_password');
                $this->load->view('ci_templates/toast');
                $this->load->view('copyright');
                $this->load->view('ci_templates/footer');
                if (isset($_POST['status']) && $_POST['status'] == 'forgot_failed') $this->load->view('ci_scripts/toast_show', ['toast_id' => 'forgot_failed']);
                $this->load->view('ci_templates/end');
            } else {
                $this->dhonapi->post('project', 'user', ['password_hash' => password_hash($this->input->post('password'), PASSWORD_DEFAULT), 'status' => 10, 'id' => $match[0]['id']]);
                redirect('auth/redirect_post?action=auth&post_name=status&post_value=reset_success');
            }
        } else {
            redirect('auth/redirect_post?action=auth&post_name=status&post_value=forgot_failed');
        }
    }

    public function redirect_post()
    {
        $data = [
            'action'        => $_GET['action'],
            'post_name'     => $_GET['post_name'],
            'post_value'    => $_GET['post_value'],
        ];

        $this->load->view('ci_templates/redirect_post', $data);
    }
}

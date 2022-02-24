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
        $this->load->library('form_validation');

        /*
        | -------------------------------------------------------------------
        |  Set up this API connection section
        | -------------------------------------------------------------------
        */
        $this->dhonapi->api_url['development'] = 'http://localhost/ci_api/';
        $this->dhonapi->api_url['production'] = 'https://dhonstudio.com/ci/api/';
        $this->dhonapi->username = 'admin';
        $this->dhonapi->password = 'admin';

        /*
        | -------------------------------------------------------------------
        |  Set up this API db and email
        | -------------------------------------------------------------------
        */
        $this->database         = 'project';
        $this->table            = 'user_ci';
        $this->email_address    = 'no-reply@dhonstudio.com';
        $this->email_sender     = 'Dhon Studio';
        $this->email_cc         = 'dhonstudio@yahoo.com';
        $this->email_logo       = 'https://dhonstudio.com/assets/img/logo.png';
        $this->email_whatsapp   = 'https://wa.me/6287700889913';

        /*
        | -------------------------------------------------------------------
        |  Set up this Cookie and Auth Service section
        | -------------------------------------------------------------------
        */
        if (ENVIRONMENT == 'development') {
            $this->cookie_prefix    = 'm';
            $this->auth_redirect    = 'http://localhost/ci_dashboard';
        } else {
            $this->cookie_prefix    = '__Secure-';
            $this->auth_redirect    = 'https://dhonstudio.com/ci/dashboard';
        }
        $this->secure_prefix    = 'DSC250222s';
        $this->secure_auth      = "DSA250222k";

        $this->load->helper('cookie');
        if ($this->input->cookie("{$this->cookie_prefix}{$this->secure_auth}") && $this->input->cookie("{$this->cookie_prefix}{$this->secure_prefix}")) redirect($this->auth_redirect);

        $this->language['active'] = 'en';

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

        $this->toast_id = 
            isset($_POST['status']) ? (
            $_POST['status'] == 'email_duplicate' ? 'email_duplicate' :
            ($_POST['status'] == 'registration_success' ? 'registration_success' :
            ($_POST['status'] == 'registration_failed' ? 'registration_failed' :
            ($_POST['status'] == 'verify_success' ? 'verify_success' :
            ($_POST['status'] == 'verify_failed' ? 'verify_failed' :
            ($_POST['status'] == 'forgot_success' ? 'forgot_success' :
            ($_POST['status'] == 'forgot_failed' ? 'forgot_failed' :
            ($_POST['status'] == 'reset_success' ? 'reset_success' :
            ($_POST['status'] == 'login_failed' ? 'login_failed'
            : ''))))))))) : '';
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
                'js'            => [
                    $this->js['bootstrap-bundle5'],
                    $this->js['jquery36'],
                ],
                'body_class'    => 'bg-primary',
            ];

            $this->load->view('ci_templates/header', $data);
            $this->load->view('auth');
            $this->load->view('copyright');
            $this->load->view('ci_templates/toast', ['toasts' => $this->toasts]);
            $this->load->view('ci_scripts/toast_show', ['toast_id' => $this->toast_id]);
            $this->load->view('ci_templates/end');
        } else {
            $user = $this->dhonapi->get($this->database, $this->table, ['email' => $this->input->post('email')]);
            if (!empty($user) && password_verify($this->input->post('password'), $user[0]['password_hash']) && $user[0]['status'] > 9) {
                /*
                | -------------------------------------------------------------------
                |  Don't forget to set up encryption key
                | -------------------------------------------------------------------
                */
                $this->load->library('encryption');

                $auth_cookie = array(
                    'name'   => $this->secure_auth,
                    'value'  => $this->encryption->encrypt($user[0]['auth_key']),
                    'expire' => 365 * 24 * 60 * 60,
                    'prefix' => $this->cookie_prefix,
                );
                $this->encryption->initialize(
                    array(
                        'cipher' => 'aes-256',
                        'mode' => 'ctr',
                        'key' => $user[0]['auth_key']
                    )
                );
                $user_cookie = array(
                    'name'   => $this->secure_prefix,
                    'value'  => $this->encryption->encrypt($user[0]['id']),
                    'expire' => 365 * 24 * 60 * 60,
                    'prefix' => $this->cookie_prefix,
                );
                set_cookie($auth_cookie);
                set_cookie($user_cookie);
                redirect($this->auth_redirect);
            } else {
                redirect('auth/redirect_post?action=auth&post_name1=status&post_value1=login_failed&post_name2=email&post_value2='.$this->input->post('email'));
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
                'js'            => [
                    $this->js['bootstrap-bundle5'],
                    $this->js['jquery36'],
                ],
                'body_class'    => 'bg-success',                
            ];

            $this->load->view('ci_templates/header', $data);
            $this->load->view('register');
            $this->load->view('copyright');
            $this->load->view('ci_templates/toast', ['toasts' => $this->toasts]);
            $this->load->view('ci_scripts/toast_show', ['toast_id' => $this->toast_id]);
            $this->load->view('ci_templates/end');
        } else {
            $users      = $this->dhonapi->get($this->database, $this->table);
            $emails     = array_column($users, 'email');
            if (in_array($this->input->post('email'), $emails)) {
                redirect('auth/redirect_post?action=auth/register&post_name1=status&post_value1=email_duplicate&post_name2=firstName&post_value2='.$this->input->post('firstName').'&post_name3=lastName&post_value3='.$this->input->post('lastName').'&post_name4=email&post_value4='.$this->input->post('email'));
            } else {
                $token  = base64_encode(random_bytes(32));

                $this->_sendEmail($token, 'verify');

                $this->load->helper('string');
                $this->dhonapi->post($this->database, $this->table, [
                    'email'                 => $this->input->post('email'),
                    'fullName'              => $this->input->post('firstName').' '.$this->input->post('lastName'),
                    'auth_key'              => random_string('alnum', 32),
                    'password_hash'         => password_hash($this->input->post('password'), PASSWORD_DEFAULT),
                    'created_at'            => time(),
                    'verification_token'    => $token,
                    'status'                => 9,
                ]);

                redirect('auth/redirect_post?action=auth&post_name1=status&post_value1=registration_success');
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
                'js'            => [
                    $this->js['bootstrap-bundle5'],
                    $this->js['jquery36'],
                ],
                'body_class'    => 'bg-warning',                
            ];

            $this->load->view('ci_templates/header', $data);
            $this->load->view('forgot_password');
            $this->load->view('copyright');
            $this->load->view('ci_templates/toast', ['toasts' => $this->toasts]);            
            $this->load->view('ci_scripts/toast_show', ['toast_id' => $this->toast_id]);
            $this->load->view('ci_templates/end');
        } else {
            $user = $this->dhonapi->get($this->database, $this->table, ['email' => $this->input->post('email')]);
            if (!empty($user) && $user[0]['status'] > 9) {
                $token  = base64_encode(random_bytes(32));

                $this->_sendEmail($token, 'forgot');

                $this->dhonapi->post($this->database, $this->table, [
                    'id'                    => $user[0]['id'],
                    'password_reset_token'  => $token,
                    'status'                => 11,
                    'updated_at'            => time()
                ]);

                redirect('auth/redirect_post?action=auth&post_name1=status&post_value1=forgot_success');
            } else {
                redirect('auth/redirect_post?action=auth/forgot_password&post_name1=status&post_value1=forgot_failed&post_name2=email&post_value2='.$this->input->post('email'));
            }
        }
	}

    private function _sendEmail(string $token, string $type)
    {
        /*
        | -------------------------------------------------------------------
        | Don't forget to create email_config_helper.php on folder helpers
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
        
        $this->load->library('email');
        $this->load->helper('email_config');

        $this->email->initialize($this->email_config);
		$this->email->from($this->email_address, $this->email_sender);
		$this->email->to($this->input->post('email'));
		$this->email->cc($this->email_cc);

        if ($type == 'verify') {
            $this->email->subject("Account Verification");
            $this->dhonemail->message(
                "Account Verification", 
                $this->email_logo, 
                $this->input->post('firstName').' '.$this->input->post('lastName'), 
                "Please verify your account by follow this link.<br>
                Link has expired in 24 hour.",
                [
                    'href' => base_url('auth/verify?email='.$this->input->post('email').'&token='.urlencode($token)),
                    'text' => 'Verify'
                ],
                'Add '.$this->email_address.' to prevent our email mark as SPAM. If our email mark as SPAM, please mark as not SPAM.',
                $this->email_sender,
                $this->email_whatsapp
            );

            $fail_redirect = 'auth/redirect_post?action=auth&post_name1=status&post_value1=registration_failed';
        } else if ($type == 'forgot') {
            $fullName = $this->dhonapi->get($this->database, $this->table, ['email' => $this->input->post('email')])[0]['fullName'];
            $this->email->subject("Reset Password");
            $this->dhonemail->message(
                "Reset Password", 
                $this->email_logo, 
                $fullName, 
                "To reset your password, please follow this link.<br>
                Link has expired in 24 hour.",
                [
                    'href' => base_url('auth/reset_password?email='.$this->input->post('email').'&token='.urlencode($token)),
                    'text' => 'Reset Password'
                ],
                'Add '.$this->email_address.' to prevent our email mark as SPAM. If our email mark as SPAM, please mark as not SPAM.',
                $this->email_sender,
                $this->email_whatsapp
            );

            $fail_redirect = 'auth/redirect_post?action=auth/forgot_password&post_name1=status&post_value1=forgot_failed';
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
        $match      = $this->dhonapi->get($this->database, $this->table, [
            'email'                 => $this->input->get('email'), 
            'verification_token'    => $this->input->get('token'),
            'status'                => 9
        ]);
        if ($match) {
            if ($match[0]['created_at'] > $expired) {
                $this->dhonapi->post($this->database, $this->table, ['status' => 10, 'id' => $match[0]['id']]);
                redirect('auth/redirect_post?action=auth&post_name1=status&post_value1=verify_success');
            } else {
                $this->dhonapi->delete($this->database, $this->table, $match[0]['id']);
                redirect('auth/redirect_post?action=auth&post_name1=status&post_value1=verify_failed');
            }
        } else {
            redirect('auth/redirect_post?action=auth&post_name1=status&post_value1=verify_failed');
        }
    }

    public function reset_password()
    {
        $expired    = time() - (60*60*24);
        $match      = $this->dhonapi->get($this->database, $this->table, [
            'email'                 => $this->input->get('email'), 
            'password_reset_token'  => $this->input->get('token'),
            'status'                => 11,
            'updated_at__more'      => $expired,
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
                    'js'            => [
                        $this->js['bootstrap-bundle5'],
                        $this->js['jquery36'],
                    ],
                    'body_class'    => 'bg-danger',                    

                    'email' => $this->input->get('email'),
                    'token' => $this->input->get('token'),
                ];
    
                $this->load->view('ci_templates/header', $data);
                $this->load->view('reset_password');
                $this->load->view('copyright');
                $this->load->view('ci_templates/toast', $this->toasts);
                $this->load->view('ci_scripts/toast_show', ['toast_id' => $this->toast_id]);
                $this->load->view('ci_templates/end');
            } else {
                $this->dhonapi->post($this->database, $this->table, ['password_hash' => password_hash($this->input->post('password'), PASSWORD_DEFAULT), 'status' => 10, 'id' => $match[0]['id']]);
                redirect('auth/redirect_post?action=auth&post_name1=status&post_value1=reset_success');
            }
        } else {
            redirect('auth/redirect_post?action=auth&post_name1=status&post_value1=forgot_failed');
        }
    }

    public function redirect_post()
    {
        $data = [
            'action'        => $_GET['action'],
        ];

        $posts = [
            [
                'post_name1'    => $_GET['post_name1'],
                'post_value1'   => $_GET['post_value1'],
            ],
        ];
        for ($i=2; $i <= 10; $i++) { 
            if (isset($_GET['post_name'.$i])) $posts[$i-1]['post_name'.$i] = $_GET['post_name'.$i];
            if (isset($_GET['post_value'.$i])) $posts[$i-1]['post_value'.$i] = $_GET['post_value'.$i];
        }
        $data['posts'] = $posts;

        $this->load->view('ci_templates/redirect_post', $data);
    }
}

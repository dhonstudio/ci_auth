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

        $this->dhonapi->api_url['development'] = 'http://localhost/ci_api/api/';
        $this->dhonapi->api_url['production'] = 'https://dhonstudio.com/ci/api/api/';
        $this->dhonapi->username = 'admin';
        $this->dhonapi->password = 'admin';
	}

	public function index()
	{
        if (!isset($_POST['status'])) {
            $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email');
            $this->form_validation->set_rules('password', 'Password', 'required|trim');
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
            $this->load->view('auth');
            $this->load->view('templates/toast');
            $this->load->view('templates/copyright');
            $this->load->view('templates/footer');
            if (isset($_POST['status']) && $_POST['status'] == 'success') $this->load->view('ci_scripts/toast_show', ['toast_id' => 'registration_success']);
            if (isset($_POST['status']) && $_POST['status'] == 'failed') $this->load->view('ci_scripts/toast_show', ['toast_id' => 'login_failed']);
            $this->load->view('templates/end');
        } else {
            $user = $this->dhonapi->get('project', 'user', ['email' => $this->input->post('email')]);
            if ($user && password_verify($this->input->post('password'), $user[0]['password_hash']) && $user[0]['status'] > 9) {
                redirect('auth/dashboard');
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
            $this->load->view('templates/toast');
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
                $token  = base64_encode(random_bytes(32));

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

                // $this->_sendEmail($token, 'verify');
                redirect('auth/redirect_post?action=auth&post_name=status&post_value=success');
            }
        }
	}

    public function _sendEmail(string $token, string $type)
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
                "Please activate your account by follow this link.<br>
                Link has expired in 24 hour.",
                [
                    'href' => base_url('auth/verify?email='.$this->input->post('email').'&token='.urlencode($token)),
                    'text' => 'Activate'
                ],
                'Add no-reply@dhonstudio.com to prevent our email mark as SPAM. If our email mark as SPAM, please mark as not SPAM.',
                'Dhon Studio',
                'https://wa.me/6287700889913'
            );
        }

        if($this->email->send()) {
			return true;
		} else {
			echo $this->email->print_debugger();
			die;
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

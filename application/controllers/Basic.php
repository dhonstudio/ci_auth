<?php
defined('BASEPATH') or exit('No direct script access allowed');

date_default_timezone_set('Asia/Jakarta');

class Basic extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();

        // /*
        // | -------------------------------------------------------------------
        // |  Don't forget to set up encryption key on config!
        // |  Set up features
        // | -------------------------------------------------------------------
        // */

        $this->language['active'] = "en";

        // /*
        // | -------------------------------------------------------------------
        // |  Set up Database and Table default
        // | -------------------------------------------------------------------
        // */
        // $this->database = ENVIRONMENT == 'testing' ? 'project_dev' : 'project';
        // $this->table    = 'user_ci';

        // /*
        // | -------------------------------------------------------------------
        // |  Set up Cookie Version and Redirect
        // | -------------------------------------------------------------------
        // */
        // $this->cookie_version = '20220411';
        // $this->auth_redirect =
        //     ENVIRONMENT == 'development' ?  'http://localhost/ci_dashboard'
        //     : (ENVIRONMENT == 'testing' ?   'http://dev.dhonstudio.com/ci/dashboard'
        //         :                               'https://dhonstudio.com/ci/dashboard'
        //     );

        // 

        // /*
        // | -------------------------------------------------------------------
        // |  Set up toasts
        // | -------------------------------------------------------------------
        // */
        // $this->toasts = [
        //     [
        //         'id'        => 'email_duplicate',
        //         'title'     => 'Failed',
        //         'message'   => 'Email address is already registered'
        //     ],
        //     [
        //         'id'        => 'registration_success',
        //         'delay'     => 10000,
        //         'title'     => 'Success',
        //         'message'   => 'Registration successfully, please verify your account by link sent to your email'
        //     ],
        //     [
        //         'id'        => 'registration_failed',
        //         'delay'     => 10000,
        //         'title'     => 'Failed',
        //         'message'   => 'Registration failed, please repeat your registration'
        //     ],
        //     [
        //         'id'        => 'verify_success',
        //         'title'     => 'Success',
        //         'message'   => 'Verification success, please login'
        //     ],
        //     [
        //         'id'        => 'verify_failed',
        //         'title'     => 'Failed',
        //         'message'   => 'Verification failed, please contact admin'
        //     ],
        //     [
        //         'id'        => 'forgot_success',
        //         'delay'     => 10000,
        //         'title'     => 'Success',
        //         'message'   => 'Success, please reset password by link sent to your email'
        //     ],
        //     [
        //         'id'        => 'forgot_failed',
        //         'title'     => 'Failed',
        //         'message'   => 'Failed, please contact admin'
        //     ],
        //     [
        //         'id'        => 'reset_success',
        //         'title'     => 'Success',
        //         'message'   => 'Password successfully changed, please login'
        //     ],
        //     [
        //         'id'        => 'login_failed',
        //         'title'     => 'Failed',
        //         'message'   => 'Login Failed'
        //     ],
        // ];

        // $this->toast_id = isset($_POST['toast_id']) ? $_POST['toast_id'] : '';


    }

    public function index()
    {
    }

    public function _register_form()
    {
        /*
        | -------------------------------------------------------------------
        |  Set up form
        | -------------------------------------------------------------------
        */
        $form_group = '';
        $input_form = [
            [
                'name'          => 'firstname',
                'label'         => 'First Name',
                'placeholder'   => 'name',
                'type'          => 'text',
                'column'        => 'split1',
                'rules'         => 'required|trim|alpha|min_length[2]|max_length[99]',
            ],
            [
                'name'          => 'lastName',
                'label'         => 'Last Name',
                'placeholder'   => 'name',
                'type'          => 'text',
                'column'        => 'split2',
                'rules'         => 'required|trim|alpha|min_length[2]|max_length[100]',
            ],
            [
                'name'          => 'email',
                'label'         => 'Email',
                'placeholder'   => 'name@example.com',
                'type'          => 'email',
                'column'        => 'single',
                'rules'         => 'required|trim|valid_email|max_length[255]',
            ],
            [
                'name'          => 'password',
                'label'         => 'Password',
                'placeholder'   => 'password',
                'type'          => 'password',
                'column'        => 'split1',
                'rules'         => 'required|trim|min_length[3]|max_length[20]',
            ],
            [
                'name'          => 'repeat_password',
                'label'         => 'Repeat Password',
                'placeholder'   => 'password',
                'type'          => 'password',
                'column'        => 'split2',
                'rules'         => 'required|trim|matches[password]',
            ],
        ];

        $data = [
            'meta'    => [
                'keywords'      => null,
                'author'        => 'Dhon Studio',
                'generator'     => null,
                'ogimage'       => null,
                'description'   => null,
            ],
            'favicon'       => null,
            'title'         => 'Register',
            'header_assets' => [
                $this->css['bootstrap5']
                // '<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">',
                // '<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>',
                // '<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script><script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>'
            ],
            'body_id'       => null,
            'body_class'    => 'bg-primary',
            'body_style'    => null,

            'action'        => base_url(get_class($this) . '/register'),
            'input_form'    => $input_form,
            'submit'        => [
                'label' => 'Submit',
                'bg'    => 'primary',
            ],
            'login'         => base_url(),
        ];

        $this->load->view('ci_templates/header', $data);
        $this->load->view('register');
        $this->load->view('copyright');
        $this->load->view('ci_templates/end');
    }

    public function register()
    {
        /*
        | -------------------------------------------------------------------
        |  Set up input form
        | -------------------------------------------------------------------
        */
        $input_form = [
            [
                'name'          => 'firstname',
                'label'         => 'First Name',
                'placeholder'   => 'name',
                'type'          => 'text',
                'column'        => 'split1',
                'rules'         => 'required|trim|alpha|min_length[2]|max_length[99]',
            ],
            [
                'name'          => 'lastName',
                'label'         => 'Last Name',
                'placeholder'   => 'name',
                'type'          => 'text',
                'column'        => 'split2',
                'rules'         => 'required|trim|alpha|min_length[2]|max_length[100]',
            ],
            [
                'name'          => 'email',
                'label'         => 'Email',
                'placeholder'   => 'name@example.com',
                'type'          => 'email',
                'column'        => 'single',
                'rules'         => 'required|trim|valid_email|max_length[255]',
            ],
            [
                'name'          => 'password',
                'label'         => 'Password',
                'placeholder'   => 'password',
                'type'          => 'password',
                'column'        => 'split1',
                'rules'         => 'required|trim|min_length[3]|max_length[20]',
            ],
            [
                'name'          => 'repeat_password',
                'label'         => 'Repeat Password',
                'placeholder'   => 'password',
                'type'          => 'password',
                'column'        => 'split2',
                'rules'         => 'required|trim|matches[password]',
            ],
        ];

        // if (!isset($_POST['toast_id'])) {
        //     foreach ($input_form as $i) {
        //         $this->form_validation->set_rules($i['name'], $i['label'], $i['rules']);
        //     }
        // }

        if ($this->form_validation->run() == false) {
            $data = [
                'meta'    => [
                    'keywords'      => null,
                    'author'        => 'Dhon Studio',
                    'generator'     => null,
                    'ogimage'       => null,
                    'description'   => null,
                ],
                'favicon'       => null,
                'title'         => 'Register',
                'header_assets' => [
                    '<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">',
                    '<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>',
                    '<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script><script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>'
                ],
                'body_id'       => null,
                'body_class'    => 'bg-primary',
                'body_style'    => null,

                'action'        => base_url(get_class($this) . '/register'),
                'input_form'    => $input_form,
                'submit'        => [
                    'label' => 'Submit',
                    'bg'    => 'primary',
                ],
                'login'         => base_url(),
            ];

            $this->load->view('ci_templates/header', $data);
            $this->load->view('register');
            $this->load->view('copyright');
            // $this->load->view('ci_templates/toast', ['toasts' => $this->toasts]);
            // $this->load->view('ci_scripts/toast_show', ['toast_id' => $this->toast_id]);
            $this->load->view('ci_templates/end');
        } else {
            $users  = $this->dhonapi->get($this->database, $this->table)->result_array();
            $emails = array_column($users, 'email');
            if (in_array($this->input->post('email'), $emails)) {
                redirect('auth/redirect_post?action=auth/register&post_name1=status&post_value1=email_duplicate&post_name2=firstName&post_value2=' . $this->input->post('firstName') . '&post_name3=lastName&post_value3=' . $this->input->post('lastName') . '&post_name4=email&post_value4=' . $this->input->post('email') . '&post_name5=version&post_value5=' . $_GET['version']);
            } else {
                $token  = base64_encode(random_bytes(32));

                // $this->_sendEmail($token, 'verify');

                $this->dhonapi->insert($this->database, $this->table, [
                    'email'                 => $this->input->post('email'),
                    'fullName'              => $this->input->post('firstName') . ' ' . $this->input->post('lastName'),
                    'auth_key'              => random_string('alnum', 32),
                    'password_hash'         => password_hash($this->input->post('password'), PASSWORD_DEFAULT),
                    'created_at'            => time(),
                    'verification_token'    => $token,
                    'status'                => 9,
                ]);

                redirect('auth/redirect_post?action=auth&post_name1=status&post_value1=registration_success&post_name2=version&post_value2=' . $_GET['version']);
            }
        }
    }
}

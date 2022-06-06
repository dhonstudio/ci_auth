<?php
defined('BASEPATH') or exit('No direct script access allowed');

date_default_timezone_set('Asia/Jakarta');

class Basic extends CI_Controller
{
    public $language;
    public $data;

    public function __construct()
    {
        parent::__construct();

        // /*
        // | -------------------------------------------------------------------
        // |  Don't forget to set up encryption key on config!
        // |  Set up features
        // | -------------------------------------------------------------------
        // */

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

        $this->load->helper('routing');
    }

    public function index()
    {
    }

    public function _register_form()
    {
        /*
        | -------------------------------------------------------------------
        |  Set up registerFormGroup on register helper
        | -------------------------------------------------------------------
        */
        $this->load->helper('register');

        /*
        | ------------------------------------------------------------------
        |  Set up function Variable
        | ------------------------------------------------------------------
        */
        $this->data['title']        = 'Register - ' . $this->data['title'];
        $this->data['body_class']   = 'bg-success';

        $this->data['action']       = base_url('register');
        $this->data['formGroup']    = $this->registerFormGroup;

        /*
        | ------------------------------------------------------------------
        |  Set up Submit button
        | ------------------------------------------------------------------
        */
        $this->data['submit'] = [
            'label' => 'Submit',
            'bg'    => 'primary',
        ];

        if ($this->form_validation->run() == false) {
            $this->load->view('ci_templates/header', $this->data);
            $this->load->view('register');
            $this->load->view('copyright');
            // $this->load->view('ci_templates/toast', ['toasts' => $this->toasts]);
            // $this->load->view('ci_scripts/toast_show', ['toast_id' => $this->toast_id]);
            $this->load->view('ci_templates/end');
        }
    }
}

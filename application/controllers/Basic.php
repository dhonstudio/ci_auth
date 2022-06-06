<?php
defined('BASEPATH') or exit('No direct script access allowed');

date_default_timezone_set('Asia/Jakarta');

class Basic extends CI_Controller
{
    public $language;
    public $data;
    public $registerFormGroup;
    public $toasts;
    public $toast_id;

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

        $this->load->helper('routing');
    }

    public function index()
    {
    }

    public function _register_form()
    {
        /*
        | -------------------------------------------------------------------
        |  Set up registerFormGroup and toasts on register helper
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
            $this->load->view('ci_templates/toast', ['toasts' => $this->toasts]);
            if ($this->toast_id) $this->load->view('ci_scripts/toast_show', ['toast_id' => $this->toast_id]);
            $this->load->view('ci_templates/end');
        }
    }
}

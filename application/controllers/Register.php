<?php
defined('BASEPATH') or exit('No direct script access allowed');

date_default_timezone_set('Asia/Jakarta');

class Register extends CI_Controller
{
    public $dhonapi;
    public $dhonglobal;

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $this->load->helper('register');

        if ($this->form_validation->run() == true) {
            $users = $this->dhonapi->getAllUsers();
            $emails = array_column($users, 'email');
            if (in_array($this->input->post('email'), $emails)) {
                echo 'duplicate';
                // redirect('auth/redirect_post?action=auth/register&post_name1=status&post_value1=email_duplicate&post_name2=firstName&post_value2=' . $this->input->post('firstName') . '&post_name3=lastName&post_value3=' . $this->input->post('lastName') . '&post_name4=email&post_value4=' . $this->input->post('email') . '&post_name5=version&post_value5=' . $_GET['version']);
            } else {
                echo 'success';
                // $token  = base64_encode(random_bytes(32));

                // // $this->_sendEmail($token, 'verify');

                // $this->dhonapi->insert($this->database, $this->table, [
                //     'email'                 => $this->input->post('email'),
                //     'fullName'              => $this->input->post('firstName') . ' ' . $this->input->post('lastName'),
                //     'auth_key'              => random_string('alnum', 32),
                //     'password_hash'         => password_hash($this->input->post('password'), PASSWORD_DEFAULT),
                //     'created_at'            => time(),
                //     'verification_token'    => $token,
                //     'status'                => 9,
                // ]);

                // redirect('auth/redirect_post?action=auth&post_name1=status&post_value1=registration_success&post_name2=version&post_value2=' . $_GET['version']);
            }
        } else {
            $this->dhonglobal->redirect_post(['action' => $_SERVER['HTTP_REFERER']]);
        }
    }
}

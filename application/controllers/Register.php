<?php
defined('BASEPATH') or exit('No direct script access allowed');

date_default_timezone_set('Asia/Jakarta');

class Register extends CI_Controller
{
    public $dhonapi;
    public $dhonglobal;
    private $form_validation;

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $this->load->helper('register');

        if ($this->form_validation->run() == true) {
            // $users = $this->dhonapi->getAllUsers();
            // $emails = array_column($users, 'email');
            // if (in_array($this->input->post('email'), $emails)) {
            $posts = [];
            for ($i = 1; $i < count($_POST); $i++) {
                $x = $i - 1;
                $posts['post_name' . $i] = array_keys($_POST)[$x];
                $posts['post_value' . $i] = array_values($_POST)[$x];
            }

            //     $this->dhonglobal->redirect_post(array_merge(['action' => $_SERVER['HTTP_REFERER']], $posts));
            // } else {
            $token  = base64_encode(random_bytes(32));

            // $this->_sendEmail($token, 'verify');

            $response = $this->dhonapi->insert([
                'email'                 => $this->input->post('email'),
                'fullName'              => $this->input->post('firstName') . ' ' . $this->input->post('lastName'),
                'auth_key'              => random_string('alnum', 32),
                'password_hash'         => password_hash($this->input->post('password'), PASSWORD_DEFAULT),
                'created_at'            => time(),
                'verification_token'    => $token,
                'status'                => 9,
            ]);

            // print_r($response['message']);

            if ($response['data'] === false) {
                // array_push($this->toasts, [
                //     'id'        => 'email_duplicate',
                //     'title'     => 'Failed',
                //     'message'   => $response['message']
                // ]);

                // print_r($this->toasts);
                $y = count($_POST) + 1;
                $posts['post_name' . $y] = 'toast_title';
                $posts['post_value' . $y] = 'Failed';
                $z = $y + 1;
                $posts['post_name' . $z] = 'toast_message';
                $posts['post_value' . $z] = $response['message'];

                $this->dhonglobal->redirect_post(array_merge(['action' => $_SERVER['HTTP_REFERER']], $posts));
            }



            // redirect('auth/redirect_post?action=auth&post_name1=status&post_value1=registration_success&post_name2=version&post_value2=' . $_GET['version']);
            // }
        } else {
            $this->dhonglobal->redirect_post(['action' => $_SERVER['HTTP_REFERER']], $_POST);
        }
    }
}

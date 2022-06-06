<?php
$ci = get_instance();

/*
| -------------------------------------------------------------------
|  Set up registerFormGroup
| -------------------------------------------------------------------
*/
$ci->registerFormGroup = [
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

/*
| -------------------------------------------------------------------
|  Set up toasts
| -------------------------------------------------------------------
*/
$ci->toasts = [
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

$ci->toast_id = isset($_POST['toast_id']) ? $_POST['toast_id'] : '';

if (!isset($_POST['toast_id'])) {
    foreach ($ci->registerFormGroup as $i) {
        $ci->form_validation->set_rules($i['name'], $i['label'], $i['rules']);
    }
}

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

// if (!isset($_POST['toast_id'])) {
foreach ($ci->registerFormGroup as $i) {
    $ci->form_validation->set_rules($i['name'], $i['label'], $i['rules']);
}
// }

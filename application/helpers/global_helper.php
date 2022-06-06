<?php
$ci = get_instance();

$ci->load->library('form_validation');
$ci->load->library('DhonAPI');
$ci->dhonapi = new DhonAPI;
// $ci->load->library('encryption');
// $ci->load->helper('cookie');
// $ci->load->helper('string');
// $ci->load->helper('libraries');

// $ci->cookie_prefix  = ENVIRONMENT == 'production' ? '__Secure-' : 'm';

// $ci->secure_prefix  = "DSC{$ci->cookie_version}s";
// $ci->secure_auth    = "DSA{$ci->cookie_version}k";

// $ci->dhonapi        = $ci->load->database($ci->database, TRUE);

if (ENVIRONMENT == 'development') {
    $path = '/../../';
} else if (ENVIRONMENT == 'testing') {
    $path = '../../../../../../';
} else if (ENVIRONMENT == 'production') {
    $path = '../../../../../';
}
require_once __DIR__ . $path . 'assets/ci_helpers/style_helper.php';

/*
| ------------------------------------------------------------------
|  Set up Global Variable
| ------------------------------------------------------------------
*/
$ci->language['active'] = "en";
$ci->data = [
    'meta'    => [
        'keywords'      => null,
        'author'        => 'Dhon Studio',
        'generator'     => null,
        'ogimage'       => null,
        'description'   => null,
    ],
    'favicon'       => null,
    'title'         => 'Dhon Studio Auth',
    'header_assets' => [
        $ci->css['bootstrap513']
        // '<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>',
        // '<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script><script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>'
    ],
    'body_id'       => null,
    'body_class'    => 'bg-primary',
    'body_style'    => null,
];

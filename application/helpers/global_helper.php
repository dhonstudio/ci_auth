<?php
$ci = get_instance();

$ci->load->library('form_validation');
$ci->load->library('DhonGlobal');
$ci->dhonglobal = new DhonGlobal;
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
        $ci->css['bootstrap513min'],
        $ci->js['bootstrapbundle513min'],
        $ci->js['jquery360'],
    ],
    'body_id'       => null,
    'body_class'    => 'bg-primary',
    'body_style'    => null,
];

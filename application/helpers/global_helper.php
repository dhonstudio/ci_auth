<?php
$ci = get_instance();

/*
| ------------------------------------------------------------------
|  Set up your Auto-load
| ------------------------------------------------------------------
*/
$ci->load->library('form_validation');
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

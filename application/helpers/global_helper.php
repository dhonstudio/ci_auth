<?php
$ci = get_instance();

/*
| ------------------------------------------------------------------
|  Set up Global CI_Loader
| ------------------------------------------------------------------
*/
$ci->load->library('form_validation');
$ci->load->helper('url');
$ci->load->helper('string');

/*
| ------------------------------------------------------------------
|  Set up Asset Path and Asset Loader
| ------------------------------------------------------------------
*/
if (ENVIRONMENT == 'development') {
    $path = '/../../';
} else if (ENVIRONMENT == 'testing') {
    $path = '../../../../../../';
} else if (ENVIRONMENT == 'production') {
    $path = '../../../../../';
}

/*
| ------------------------------------------------------------------
|  Set up Global Custom Loader
| ------------------------------------------------------------------
*/
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

/*
| ------------------------------------------------------------------
|  Set up Global Variable
| ------------------------------------------------------------------
*/
$ci->data = [
    'language'  => null,
    'meta'      => [
        'keywords'      => null,
        'author'        => 'Dhon Studio',
        'generator'     => null,
        'ogimage'       => null,
        'description'   => null,
    ],
    'favicon'       => null,
    'title'         => 'Dhon Studio Auth',
    'header_assets' => [
        // $ci->css['bootstrap513min'],
        // $ci->js['bootstrapbundle513min'],
        // $ci->js['jquery360'],
        '
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
        '
    ],
    'body_id'       => null,
    'body_class'    => null,
    'body_style'    => null,
];

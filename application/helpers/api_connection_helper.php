<?php
    $ci = get_instance();

    $ci->dhonapi    = new DhonAPI;
    $ci->dhonemail  = new DhonEmail;

    /*
    | -------------------------------------------------------------------
    |  Set up API connection section
    | -------------------------------------------------------------------
    */
    $ci->dhonapi->api_url['development']    = 'http://localhost/ci_api/';
    $ci->dhonapi->api_url['production']     = 'https://dhonstudio.com/ci/api/';
    $ci->dhonapi->api_url['testing']        = 'https://dhonstudio.com/ci/api/';
    $ci->dhonapi->username  = 'admin';
    $ci->dhonapi->password  = 'admin';
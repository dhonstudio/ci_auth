<?php
    $ci = get_instance();

    /*
    | -------------------------------------------------------------------
    |  Don't forget to set up encryption key on config
    | -------------------------------------------------------------------
    */
    $ci->load->library('encryption');
    $ci->load->library('form_validation');
    $ci->load->helper('cookie');
    $ci->load->helper('string');
    $ci->load->helper('libraries');

    $ci->dhonapi = $ci->load->database($ci->database, TRUE);
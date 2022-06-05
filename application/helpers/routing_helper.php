<?php
$ci = get_instance();

$ci->load->library('DhonGlobal');
$this->dhonglobal = new DhonGlobal;

/*
| ------------------------------------------------------------------
|  Set up your Routing
| ------------------------------------------------------------------
*/
$this->dhonglobal->dhon_routing([
    'register' => 'register_form',
]);

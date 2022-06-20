<?php
$ci = get_instance();

$ci->toast_title    = isset($_POST['toast_title']) ? $_POST['toast_title'] : '';
$ci->toast_message  = isset($_POST['toast_message']) ? $_POST['toast_message'] : '';
$ci->toast = [
    'toast_title' => $ci->toast_title,
    'toast_message' => $ci->toast_message,
];

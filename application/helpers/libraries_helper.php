<?php

if (ENVIRONMENT == 'development') {
    $path = '/../../';
} else if (ENVIRONMENT == 'testing') {
    $path = '../../../../../../';
} else {
    $path = '../../../../../';
}

require_once __DIR__ . $path. 'assets/ci_helpers/style_helper.php';
require_once __DIR__ . $path. 'assets/ci_libraries/DhonAPI.php';
require_once __DIR__ . $path. 'assets/ci_libraries/DhonEmail.php';
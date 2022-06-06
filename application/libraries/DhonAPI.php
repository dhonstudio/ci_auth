<?php

class DhonAPI
{
    protected $api_url = [
        'development' => 'http://localhost/ci_api2/',
        'testing' => 'http://dev.dhonstudio.com/ci/api2/',
        'production' => 'https://dhonstudio.com/ci/api2/',
    ];
    protected $username = 'admin';
    protected $password = 'admin';
    protected $dhonglobal;

    public function __construct()
    {
        $this->dhonapi = &get_instance();

        $this->dhonapi->load->library('DhonGlobal');
        $this->dhonglobal = new DhonGlobal;
    }

    public function getAllUsers()
    {
        return $this->dhonglobal->dhon_curl([
            'username' => $this->username,
            'password' => $this->password,
            'url' => "{$this->api_url[ENVIRONMENT]}userci/getAllUsers",
            'method' => "get",
        ])['data'];
    }
}

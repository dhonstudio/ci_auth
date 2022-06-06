<?php

class DhonGlobal
{

    public function __construct()
    {
        $this->dhonglobal = &get_instance();
    }

    /**
     * Routing
     *
     * @param	array	$params [$path => $function]
     * @return	void
     */
    public function dhon_routing(array $params)
    {
        foreach ($params as $key => $value) {
            $function = '_' . $value;
            isset($_GET['page']) && $_GET['page'] == $key ? $this->dhonglobal->$function() : false;
        }
    }

    /**
     * Curl Request
     *
     * @param	array	$params ['username', 'password', 'url', 'method' => 'get' | 'post']
     * @return	void
     */
    public function dhon_curl(array $params)
    {
        $username   = $params['username'];
        $password   = $params['password'];
        $url        = $params['url'];

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($curl, CURLOPT_USERPWD, "{$username}:{$password}");
        curl_setopt($curl, CURLOPT_URL, "{$url}");
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
        return json_decode(curl_exec($curl), true);
        curl_close($curl);
    }
}

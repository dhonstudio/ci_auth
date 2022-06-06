<?php

class DhonGlobal
{

    public function __construct()
    {
        $this->dhonglobal = &get_instance();

        $this->load = $this->dhonglobal->load;
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
        $method     = $params['method'];

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($curl, CURLOPT_USERPWD, "{$username}:{$password}");
        curl_setopt($curl, CURLOPT_URL, "{$url}");
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
        return json_decode(curl_exec($curl), true);
        curl_close($curl);
    }

    /**
     * Redirecting with POST data
     *
     * @param	array	$params data
     * @return	void
     */
    public function redirect_post(array $params)
    {
        if ($_POST) {
            $posts = [];
            for ($i = 1; $i < count($_POST); $i++) {
                $x = $i - 1;
                $posts['post_name' . $i] = array_keys($_POST)[$x];
                $posts['post_value' . $i] = array_values($_POST)[$x];
            }
            $params = array_merge($params, $posts);
        }

        $data = [
            'action' => $params['action'],
        ];

        $params = [
            [
                'post_name1'    => $params['post_name1'],
                'post_value1'   => $params['post_value1'],
            ],
        ];
        for ($i = 2; $i <= 10; $i++) {
            if (isset($params['post_name' . $i])) $params[$i - 1]['post_name' . $i] = $params['post_name' . $i];
            if (isset($params['post_value' . $i])) $params[$i - 1]['post_value' . $i] = $params['post_value' . $i];
        }
        $data['posts'] = $params;

        $this->load->view('ci_templates/redirect_post', $data);
    }
}

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
}

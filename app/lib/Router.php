<?php

/**
 * Class Router
 */
class Router
{

    /**
     * @var mixed|null
     */
    protected $controller;
    /**
     * @var mixed|null
     */
    protected $action;
    /**
     * @var
     */
    protected $params;

    /**
     * Router constructor.
     * @param $uri
     */
    function __construct($uri)
    {
        // EXPLODE URI
        $uri_parts = explode("?", $uri);
        $path = $uri_parts[0];
        $path_parts = explode("/", $path);

        // TAKE CONTROLLER / ACTION / PARAMS
        if (count($path_parts)) {
            $user = false;
            if (current($path_parts) == 'admin' && isset($_SESSION['id'])) {
                $user = true;
            }
            // TAKE CONTROLLER
            if (current($path_parts)) {
                $this->controller = strtolower(current($path_parts));
                array_shift($path_parts);
            } else {
                $this->controller = Config::get("default_controller");
            }
            // TAKE ACTION
            if (current($path_parts)){
                if ($user == false && $this->controller == 'admin') {
                    $this->action = 'login';
                } else {
                    $this->action = strtolower(current($path_parts));
                    array_shift($path_parts);
                }
            } else {
                $this->action = Config::get("default_action");
            }
            // TAKE PARAMS
            if (isset($uri_parts[1]) && $uri_parts[1] != "") {
                $this->params = $uri_parts[1];
            }
        }
    }

    /**
     * @return mixed
     */
    public function getController()
    {
        return $this->controller;
    }

    /**
     * @return mixed
     */
    public function getAction()
    {
        return $this->action;
    }

    /**
     * @return mixed
     */
    public function getParams()
    {
        return $this->params;
    }

}
<?php

class View
{

    protected $data = [];
    protected $path;

    function __construct($data = [], $path = null)
    {

        if (!$path) {
            $path = self::getDefaultViewPath();
        }

        if (!file_exists($path)) {
            throw new Exception("Le template n'existe pas", 1);
        }

        $this->data = $data;
        $this->path = $path;

    }

    public function render()
    {

        $data = $this->data;
        ob_start();
        require $this->path;
        $content = ob_get_clean();

        return $content;

    }

    public static function getDefaultViewPath()
    {
        $router = App::getRouter();
        if (!$router) {
            return false;
        }
        $controller_dir = $router->getController();
        $template_name = $router->getAction().".php";

        return MVC.DS.'views'.DS.$controller_dir.DS.$template_name;
    }

}
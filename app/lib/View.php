<?php

class View
{

    protected $data = [];
    protected $path;

    function __construct($data = [], $path)
    {
        if (!$path) {
            $path = self::getDefaultViewPath();
        }

        $this->data = $data;
        $this->path = $path;
    }

    public function printView()
    {
        echo $this->render();
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
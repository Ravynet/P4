<?php

/**
 * Class View
 */
class View
{

    /**
     * @var array
     */
    protected $data = [];

    /**
     * @var bool|string
     */
    protected $path;

    /**
     * View constructor.
     * @param array $data
     * @param $path
     */
    function __construct($data = [], $path)
    {
        if (!$path) {
            $path = self::getDefaultViewPath();
        }

        $this->data = $data;
        $this->path = $path;
    }

    /**
     *
     */
    public function printView()
    {
        echo $this->render();
    }

    /**
     * @return string
     */
    public function render()
    {
        $data = $this->data;
        ob_start();
        require $this->path;
        $content = ob_get_clean();

        return $content;
    }

    /**
     *
     */
    public function printViewAjax()
    {
        if (file_exists(substr($this->path,0,-4).'Ajax.php')){
            $this->path = substr($this->path,0,-4).'Ajax.php';
            $data = $this->data[0];
            include $this->path;
        }
    }

    /**
     * @return bool|string
     */
    public static function getDefaultViewPath()
    {
        $router = App::getRouter();

        if (!$router) {
            return false;
        }

        $controller_dir = $router->getController();
        $view_name = $router->getAction().".php";

        return MVC.DS.'views'.DS.$controller_dir.DS.$view_name;
    }

}
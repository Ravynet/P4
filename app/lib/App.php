<?php

class App
{

    protected static $router;

    public static function getRouter()
    {
        return self::$router;
    }

    public static function run($uri)
    {
        // INSTANTIATE $router
        self::$router = new Router($uri);

        $class = str_replace(" ", "", self::$router->getController());
        $controller_class = ucfirst($class.'Controller');
        $controller_method = strtolower(self::$router->getAction());
        $id = intval(self::$router->getParams());

        // INSTANTIATE Controller
        if (class_exists($controller_class)) {
            $controller_object = new $controller_class();
        } else {
            $controller_class = (ucfirst(Config::get("default_controller").'Controller'));
            $controller_object = new $controller_class;
            $controller_method = strtolower(Config::get("default_method"));
        }

        if (method_exists($controller_object, $controller_method)) {

            $view_path = $controller_object->$controller_method($id);

            // INSTANTIATE View
            $view_object = new View($controller_object->getData(), $view_path);

            $content = $view_object->render();
        } else {
            $view_path = APP.DS."template".DS.'404.php';
            $view_object = new View($controller_object->getData(), $view_path);
            $content = $view_object->render();
        }

        $layout = Config::get('default_layout').".php";

        $layout_path = APP.DS."template".DS.$layout;

        $layout_view_obj = new View(compact('content'), $layout_path);

        $layout_view_obj->printView();
    }

}
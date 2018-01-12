<?php

function __autoload($class_name)
{
    $lib_path = LIB.DS.ucfirst($class_name).'.php';
    $controller_path = MVC.DS."controllers".DS.ucfirst(str_replace("Controller","",$class_name)).'Controller.php';
    $modele_path = MVC.DS."modele".DS.$class_name.'.php';

    if (file_exists($lib_path)) {
        require_once ($lib_path);
    } elseif (file_exists($controller_path)){
        require_once ($controller_path);
    } elseif (file_exists($modele_path)){
        require_once ($modele_path);
    } else {
        throw new Exception("La classe ----- $class_name ----- n'existe pas", 1);
    }
}
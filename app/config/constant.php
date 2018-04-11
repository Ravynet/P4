<?php
$home = '/home/';

define("DS", DIRECTORY_SEPARATOR);
define("ROOT", dirname(dirname(dirname(__FILE__))));

$homePath = strpos(ROOT, $home);
if ($homePath === false) {
    define("LOCAL", 'http://localhost/P4%20PHP/Programmez%20en%20oriente%20objet%20en%20PHP/Exercices/www/');
} else {
    define("LOCAL", 'https://jean-forteroche.alwaysdata.net/');
}

define("WEBROOT", ROOT.DS."webroot");
define("APP", ROOT.DS."app");

define("LIB", APP.DS."lib");
define("CONF", APP.DS."config");
define("MVC", APP.DS."mvc");

$css = LOCAL.'webroot/css/style.css';
define("CSS", $css);
$fontAwesome = LOCAL.'webroot/css/font-awesome-4.7.0/css/font-awesome.min.css';
define("FONTAWESOME", $fontAwesome);
$js = LOCAL.'webroot/js/js.js';
define("JS", $js);

$uri = $_SERVER['REQUEST_URI'];
$uri = str_replace('/P4%20PHP/Programmez%20en%20oriente%20objet%20en%20PHP/Exercices/www/',"", $uri);
$uri = urldecode(trim($uri, "/"));


<?php

Config::set("site_name","Billet simple pour l'Alaska - Jean FORTEROCHE");
Config::set("default_controller", "accueil");
Config::set("default_action", "index");
Config::set("default_layout", "default");

Config::set("description", 'Venez découvrir le nouveau roman de Jean Forteroche "Billet simple pour l\' Alaska" Dans ce format Blog, vivez une aventure à vous couper le souffle.');

Config::set("art_per_page_blog", "4");
Config::set("art_per_page_admin", "6");

Config::set("max_size", 2097152); // => 2Mo
Config::set("extension_valid", array('jpg', 'jpeg', 'gif', 'png'));
Config::set("max_width", 850);
Config::set("max_height", 350);
Config::set("quality_jpeg", 80);
Config::set("quality_png", 7);
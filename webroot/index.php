<?php
session_start();

require_once('../app/config/constant.php');
require_once(LIB . DS . 'init.php');
require_once(CONF . DS . 'config.php');

// RUN App
App::run($uri);
<?php

error_reporting(E_ALL);
ini_set('display_errors', 'On');
define('CURRENT_PAGE', basename($_SERVER['REQUEST_URI']));
define('ROOT',dirname(dirname(__FILE__)));
const RESOURCES = ROOT . "/resources/";
const INCLUDES= ROOT."/includes/";

const COMPONENTS= INCLUDES."/components/";

require_once("config.php");

require_once("Utils.php");

spl_autoload_register(function($class){
    if (file_exists(COMPONENTS . $class . '.php')) {
        require_once COMPONENTS . $class . '.php';
    }

    if (file_exists(RESOURCES . $class. '.php')) {
        require_once RESOURCES . $class. '.php' ;
    }

    if (file_exists(INCLUDES. $class. '.php')) {
        require_once INCLUDES. $class. '.php' ;
    }

});

include('Database.php');
include('Router.php');
include('Resource.php');




Resource::migrate();



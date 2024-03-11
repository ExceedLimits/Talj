<?php

error_reporting(E_ALL);
ini_set('display_errors', 'On');
define('CURRENT_PAGE', basename($_SERVER['REQUEST_URI']));
define('ROOT', dirname(__FILE__, 2));
const RESOURCES = ROOT . "/Resources/";
const INCLUDES= ROOT."/includes/";

const COMPONENTS= INCLUDES."/Components/";

const COMPONENTS_TYPES= ['Forms','Tables'];

require_once("config.php");

require_once("Utils.php");

spl_autoload_register(function($class){
    foreach (COMPONENTS_TYPES as $TYPE)
    if (file_exists(COMPONENTS .$TYPE."/". $class . '.php')) {
        require_once COMPONENTS .$TYPE."/" . $class . '.php';
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



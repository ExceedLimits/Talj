<?php
spl_autoload_register(function($class){
    if (file_exists("includes/components/" . $class . '.php')) {
        require_once 'includes/components/' . $class . '.php';
    }

    if (file_exists("resources/" . $class. '.php')) {
        require_once 'resources/' . $class. '.php' ;
    }

    if (file_exists("includes/" . $class. '.php')) {
        require_once 'includes/' . $class. '.php' ;
    }

});
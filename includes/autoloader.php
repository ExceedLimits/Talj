<?php
spl_autoload_register(function($class){
    if (file_exists(ROOT.'/includes/components/' . $class . '.php')) {
        require_once ROOT.'/includes/components/' . $class . '.php';
    }

    if (file_exists(ROOT.'/resources/' . $class. '.php')) {
        require_once ROOT.'/resources/' . $class. '.php' ;
    }

    if (file_exists(ROOT.'/includes/' . $class. '.php')) {
        require_once ROOT.'/includes/' . $class. '.php' ;
    }

});
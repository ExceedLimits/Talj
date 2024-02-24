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

function getAsset($path):void
{
    echo ASSET_URL.$path;
}

function getCSSAsset($lib):void
{
    echo '<link href="'.ASSET_URL.'css/'.$lib.'" rel="stylesheet">';
}

function getFontAsset($lib):void
{
    echo '<link href="'.ASSET_URL.'fonts/'.$lib.'" rel="stylesheet">';
}

function getJSAsset($lib):void
{
    echo '<link href="'.ASSET_URL.'js/'.$lib.'" rel="stylesheet">';
}

function route($url)
{
    return APP_URL.$url;
}

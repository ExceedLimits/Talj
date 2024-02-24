<?php


require_once("includes\autoloader.php");
require_once("includes\Router.php");

error_reporting(E_ALL);
ini_set('display_errors', 'On');
define('BASE_PATH', (dirname(__FILE__)));
define('CURRENT_PAGE', basename($_SERVER['REQUEST_URI']));


const APP_NAME = 'Dashboard';
const APP_URL= 'http://localhost/framework';
const ASSET_URL= APP_URL.'/assets/';


<?php
require_once("includes\autoloader.php");
require_once("includes\Router.php");

error_reporting(E_ALL);
ini_set('display_errors', 'On');
define('BASE_PATH', (dirname(__FILE__)));
define('CURRENT_PAGE', basename($_SERVER['REQUEST_URI']));

const APP_NAME = 'Talj';
const APP_URL= 'http://localhost/Talj';
const ASSET_URL= APP_URL.'/assets/';

const DB_HOST='localhost';
const DB_NAME=APP_NAME;
const DB_USER="root";
const DB_PASSWORD="";



<?php
error_reporting(E_ALL);
ini_set('display_errors', 'On');
define('BASE_PATH', (dirname(__FILE__)));
define('CURRENT_PAGE', basename($_SERVER['REQUEST_URI']));
define('ROOT',dirname(__FILE__));

const APP_NAME = 'PMS';
const APP_URL= 'http://localhost/Talj';
const ASSET_URL= APP_URL.'/assets/';

const DB_HOST='localhost';
const DB_NAME=APP_NAME;
const DB_USER="root";
const DB_PASSWORD="";


include(ROOT.'/includes/autoloader.php');

include(ROOT.'/includes/Database.php');
include(ROOT.'/includes/Router.php');


function DB(){
    return new Database(DB_HOST,DB_NAME,DB_USER,DB_PASSWORD);
}







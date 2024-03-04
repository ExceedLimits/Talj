<?php
session_start();
$router=Router::fromURI($_SERVER['REQUEST_URI'] ?? '/');
//die(var_dump($_SESSION));
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){

    include "layout/header.php";

    echo '<div class="ui grid" style="padding: 0.5rem">';
    echo '<div class="column four wide">';
    include "layout/sidebar.php";
    echo '</div>';
    echo '<div class="column twelve wide">';
    if ($router->getResource()=="dashboard"){
        include "layout/dashboard.php";
    }
    else{
        Resource::render($router);
    }
    echo '</div>';
    echo '</div>';
}else{
    include "layout/login.php";
}


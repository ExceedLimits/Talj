<?php
session_start();
$router=Router::fromURI($_SERVER['REQUEST_URI'] ?? '/');
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    if ($router->getResource()=="logout"){
        $_SESSION = array();
        session_destroy();
        Router::resource("logout")->operation("")->arg("")->goto();
    }else{
        include "layout/header.php";

        echo '<div class="ui grid" style="">';
        echo '<div class="two wide tablet only two wide computer only column">';
        include "layout/sidebar.php";
        echo '</div>';
        echo '<div class="sixteen wide mobile fourteen wide tablet fourteen wide computer right floated column">';
            if ($router->getResource()=="dashboard"){
                include "layout/dashboard.php";
            } else{
                Resource::render($router);
            }
        echo '</div>';
        echo '</div>';
    }

}else{
    include "layout/login.php";
}


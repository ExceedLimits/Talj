<?php
session_start();
$router=Router::fromURI($_SERVER['REQUEST_URI'] ?? '/');
//die(var_dump($_SESSION));
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    if ($router->getResource()=="logout"){
        //session_start();
        $_SESSION = array();
        session_destroy();
        Router::resource("logout")->operation("")->arg("")->goto();
        //include "layout/login.php";
    }else{
        include "layout/header.php";

        echo '<div class="ui grid" style="">';
        echo '<div class="two wide tablet only two wide computer only column">';
        include "layout/sidebar.php";
        echo '</div>';
        echo '<div class="sixteen wide mobile fourteen wide tablet fourteen wide computer right floated column">';
        if ($router->getResource()=="dashboard"){
            include "layout/dashboard.php";
        }
        else{
            //try{
                Resource::render($router);
            //}catch (Exception $exception){
               //include "404.php";
            //}

        }
        echo '</div>';
        echo '</div>';
    }

}else{
    include "layout/login.php";
}


<?php


class Router
{
    public static function contentToRender() : void
    {
        $path_info = $_SERVER['REQUEST_URI'] ?? '/';
        $uri= explode('/', $path_info);

/*

        $resource= ucfirst($uri[2])??'';
        $operation= $uri[3]??'';
        $arg= $uri[4]??'';*/


        /*if ($resource=="Actions"){
            var_dump(CURRENT_PAGE);
        }*/

        //if ($resource=="Login")
        if (false)
            include "layout\login.php";
        else
            call_user_func(array("Resource","render"),$uri);
    }

    /*private static function getURI() : array
    {
        $path_info = $_SERVER['PATH_INFO'] ?? '/';
        return explode('/', $path_info);
    }

    private static function processURI() : array
    {
        $controllerPart = self::getURI()[0] ?? '';
        $methodPart = self::getURI()[1] ?? '';
        $numParts = count(self::getURI());
        $argsPart = [];
        for ($i = 2; $i < $numParts; $i++) {
            $argsPart[] = self::getURI()[$i] ?? '';
        }

        //Let's create some defaults if the parts are not set
        $controller = !empty($controllerPart) ?
            '\Controllers\\'.$controllerPart.'Controller' :
            '\Controllers\HomeController';

        $method = !empty($methodPart) ?
            $methodPart :
            'index';

        $args = !empty($argsPart) ?
            $argsPart :
            [];

        return [
            'controller' => $controller,
            'method' => $method,
            'args' => $args
        ];
    }*/
}
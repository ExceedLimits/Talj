<?php


class Router
{
    protected string $resource = "Resource";
    protected string $operation = "show";
    protected string $arg = "1";
    protected array $params=[];

    public static function resource($sender): self
    {
        return new self($sender);
    }

    public static function fromURI($uri): self
    {
        $uriBits = explode('/', $uri);
        $router= new self($uriBits[2]??'');

        $router->operation= $uriBits[3]??'';
        $router->arg= $uriBits[4]??'';
        if (strpos($router->arg,"?")>-1){
            $lastBits=explode("?",$router->arg);
            $router->arg=$lastBits[0];
            foreach (explode("&",$lastBits[1]) as $ps){
                $router->params[explode("=",$ps)[0]]=explode("=",$ps)[1];
            }

        }

        return $router;
    }

    public function getResource(){return $this->resource;}
    public function getOperation(){return $this->operation;}
    public function getArg(){return $this->arg;}
    public function getparams(){return $this->params;}

    public function __construct($sender)
    {
        $this->resource = $sender;
        return $this;
    }

    public function operation($operation="show"): self
    {
        $this->operation = $operation;
        return $this;
    }

    public function arg($arg="1"): self
    {
        $this->arg = $arg;
        return $this;
    }

    public function params($params=[]): self
    {
        $this->params = $params;
        return $this;
    }

    public function goto(){
        while (ob_get_status()) {ob_end_clean();}
        header("Location: ".$this->url());
        exit();
    }

    public function url(): string
    {
        $p="";
        if ($this->params!=[]) $p="?".implode("&",$this->params);
        return trim(APP_URL . "/" . $this->resource . "/" . $this->operation . "/" . $this->arg . $p,"/");
    }

    public function addNew(): string
    {
        return APP_URL . "/" . $this->resource . "/add/new";
    }


    /*public static function contentToRender(): void
    {

        $path_info = $_SERVER['REQUEST_URI'] ?? '/';
        $query = $_SERVER['REDIRECT_QUERY_STRING'] ?? '';
        $path_info = trim(str_replace($query, '', $path_info), "?");
        $uri = explode('/', $path_info);





        //if ($resource=="Login")
        if (false)
            include "layout\login.php";
        else
            call_user_func(array("Resource", "render"), $uri);
    }*/

    public static function getAsset($path): void
    {
        echo ASSET_URL . $path;
    }

    public static function getCSSAsset($lib): void
    {
        echo '<link href="' . ASSET_URL . 'css/' . $lib . '" rel="stylesheet">';
    }

    public static function getFontAsset($lib): void
    {
        echo '<link href="' . ASSET_URL . 'fonts/' . $lib . '" rel="stylesheet">';
    }

    public static function getJSAsset($lib): void
    {
        echo '<script src="' . ASSET_URL . 'js/' . $lib . '"></script>';
    }
}
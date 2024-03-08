<?php

function DB(){
    return new Database(DB_HOST,DB_NAME,DB_USER,DB_PASSWORD);
}

function pretty($var):void
{
    $bt = debug_backtrace();
    $caller = array_shift($bt);

    echo "<pre style='border:2px gray dotted;padding:0.5rem;white-space: pre-wrap; /* Since CSS 2.1 */white-space: -moz-pre-wrap;/* Opera 4-6 */white-space: -o-pre-wrap; /* Opera 7 */word-wrap: break-word; /* Internet Explorer 5.5+ */'>";
    echo "<h4><strong>".$caller['file']." : ".$caller['line']."</strong></h4>";
    echo "<hr>";
    if (is_array($var)){
        print_r($var);
    }else{
        echo($var);
    }

    echo "<hr>";
    debug_print_backtrace();

    echo "</pre>";
}

function getAllClasses($dir):array
{
    $res = array();
    $iterator = new DirectoryIterator($dir);
    foreach ($iterator as $file) {
        if ($file->isFile()) {
            $res[] = (pathinfo($file->getPathname(), PATHINFO_FILENAME));
        }
    }
    return $res;
}

function currentUser():array{
    return DB()->table("User")->where("id",$_SESSION["id"])->first();
}
<?php
ob_start();
require_once("config.php");

$iterator = new DirectoryIterator("resources");
foreach ($iterator as $fileinfo) {
    if ($fileinfo->isFile()) {
        $class = (pathinfo( $fileinfo->getPathname() , PATHINFO_FILENAME));
        //($class::migrateDn());

        $class::migrate();
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title><?php echo APP_NAME; ?></title>

    <title><?php echo APP_NAME; ?></title>

    <?php
        //getCSSAsset("cutestrap.css");
        Router::getCSSAsset("app.css");
        Router::getCSSAsset("semantic.min.css");

        //getFontAsset("font-awesome/css/font-awesome.min.css");


    ?>

</head>

<body style="padding: 1rem">
<div class="ui " >
    <?php include "layout/content.php"?>
</div>
<?php
Router::getJSAsset("jquery.min.js");
Router::getJSAsset("semantic.min.js");
Router::getJSAsset("app.js");
?>

</body>
</html>
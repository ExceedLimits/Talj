<?php
ob_start();
require_once("config.php");

$iterator = new DirectoryIterator("resources");
foreach ($iterator as $fileinfo) {
    if ($fileinfo->isFile()) {
        $class = strtolower(pathinfo( $fileinfo->getPathname() , PATHINFO_FILENAME));
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
        getCSSAsset("app.css");
        getCSSAsset("semantic.min.css");

        //getFontAsset("font-awesome/css/font-awesome.min.css");


    ?>

</head>

<body style="padding: 1rem">
<div class="ui container" >
    <?php require_once("layout/header.php");?>
    <div class="ui grid" style="padding: 0.5rem">
        <div class="column four wide">
            <?php
            if (true){//if (isset($_SESSION['user_logged_in']) && $_SESSION['user_logged_in'] == true){
                require_once("layout/sidebar.php");
            }
            ?>
        </div>
        <div class="column twelve wide">
            <?php Router::contentToRender();?>
        </div>
    </div>
</div>
<?php
getJSAsset("jquery.min.js");
getJSAsset("semantic.min.js");
getJSAsset("app.js");
?>

</body>
</html>
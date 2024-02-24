
<?php

require_once("config.php")

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
        getCSSAsset("cutestrap.css");
        getCSSAsset("app.css");
        getFontAsset("font-awesome/css/font-awesome.min.css");
        getJSAsset("jquery.min.js");
    ?>

</head>

<body>

<?php
    require_once("layout/header.php");

    if (isset($_SESSION['user_logged_in']) && $_SESSION['user_logged_in'] == true){
        require_once("layout/sidebar.php");
    }

    Router::contentToRender();

    require_once("layout/footer.php");
?>

</body>
</html>
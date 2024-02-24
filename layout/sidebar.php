<ul class="sidebar">

    <li class="sidebar"><a class="active" href="#home"><i class="fa fa-dashboard"></i> Home</a></li>
    <?php
    $iterator = new DirectoryIterator("resources");
    foreach ($iterator as $fileinfo) {
        if ($fileinfo->isFile()) {
            $class = strtolower(pathinfo( $fileinfo->getPathname() , PATHINFO_FILENAME));
            echo '<li class="sidebar"><a href="'.route("/".$class."/show").'"><i class="'.$class::$icon.'"></i> '.$class::$pluralLabel.'</a></li>';
        }
    }
    ?>
</ul>
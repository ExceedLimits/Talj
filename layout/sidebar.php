<div class="ui sticky large inverted vertical visible pointing menu" style="height: 90vh;width: 100%">
    <?php
        echo '<a class="item '.(("dashboard"==$router->getResource())?"active":"").'" href="'.Router::resource("dashboard")->operation('')->arg('')->url().'"><div><i class="icon tachometer alternate"></i> Dashboard</div></a>';

    $resources=[];
    $iterator = new DirectoryIterator("resources");
    foreach ($iterator as $fileinfo) {
        if ($fileinfo->isFile()) {
            $sender = (pathinfo( $fileinfo->getPathname() , PATHINFO_FILENAME));

            $resources[$sender::getOrder()]='<a class="item '.(($sender==$router->getResource())?"active":"").'" href="'.Router::resource($sender)->url().'"><div><i class="'.$sender::getIcon().' icon"></i> '.$sender::getPluralLabel().'</div></a>';
        }
    }
    ksort($resources);
    foreach ($resources as $r){echo $r;}
    ?>
</div>
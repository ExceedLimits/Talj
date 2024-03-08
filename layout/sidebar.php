<div class="ui large inverted vertical visible pointing menu" style="height: 100%;width: 100%">
    <?php
        echo '<a class="item '.(("dashboard"==$router->getResource())?"active":"").'" href="'.Router::resource("dashboard")->operation('')->arg('')->url().'"><div><i class="icon tachometer alternate"></i> Dashboard</div></a>';

        $resources=[];
        $iterator = new DirectoryIterator("resources");
        foreach (getAllClasses(RESOURCES) as $sender) {
            if ($sender::canList())
            $resources[$sender::getOrder()]='<a class="item '.(($sender==$router->getResource())?"active":"").'" href="'.Router::resource($sender)->url().'"><div><i class="'.$sender::getIcon().' icon"></i> '.$sender::getPluralLabel().'</div></a>';
        }
        ksort($resources);
        foreach ($resources as $r){echo $r;}
    ?>
</div>
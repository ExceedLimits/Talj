<h1>Dashboard</h1>
<div class="ui four cards">
    <?php
    $resources=[];
    $iterator = new DirectoryIterator("resources");
    foreach ($iterator as $fileinfo) {
        if ($fileinfo->isFile()) {
            $sender = (pathinfo( $fileinfo->getPathname() , PATHINFO_FILENAME));
            if ($sender::getDashboarded()){
                $resources[$sender::getOrder()]='
                <div class=" card">
                 <div class="content">
                   <i class="right floated icon red huge '.$sender::getIcon().'"></i>
                  <div class=" header huge" style="font-size: xx-large">
                    '.DB()->count(strtolower($sender)).'
                  </div>
                  <div class="meta red header" style="font-size: large;color: #E2013D">
                    '.$sender::getPluralLabel().'
                  </div>
                  
                </div>
                    
                    <a href="'.Router::resource($sender)->addNew().'" class="ui bottom attached button gray">
                        <i class="add icon"></i>
                        Add '.$sender::getSingleLabel().'
                    </a>
                </div>
                ';
            }

        }
    }
    ksort($resources);
    foreach ($resources as $r){echo $r;}
    ?>


</div>
<div class="ui large inverted vertical visible pointing menu">

    <div class="item ">
        <div class="header">General</div>
        <div class="menu">
            <a class="large item">
                <div>
                    <i class="icon tachometer alternate"></i>
                    Dashboard
                </div>
            </a>
        </div>
    </div>
    <div class="item ">

        <div class="menu">
            <?php
            $iterator = new DirectoryIterator("resources");
            foreach ($iterator as $fileinfo) {
                if ($fileinfo->isFile()) {
                    $class = strtolower(pathinfo( $fileinfo->getPathname() , PATHINFO_FILENAME));
                    echo '<a class="item" href="'.route("/".$class."/show").'"><div><i class="'.$class::$icon.' icon"></i> '.$class::$pluralLabel.'</div></a>';
                }
            }
            ?>
            <a class="active item">
                <div><i class="cogs icon"></i>Settings</div>
            </a>
            <a class="item">
                <div><i class="users icon"></i>Team</div>
            </a>
        </div>
    </div>


    <a href="#" class="item">
        <div>
            <i class="icon chart line"></i>
            Charts
        </div>
    </a>

    <a class="item">
        <div>
            <i class="icon lightbulb"></i>
            Apps
        </div>
    </a>
    <div class="item">
        <div class="header">Other</div>
        <div class="menu">
            <a href="#" class="item">
                <div>
                    <i class="icon envelope"></i>
                    Messages
                </div>
            </a>

            <a href="#" class="item">
                <div>
                    <i class="icon calendar alternate"></i>
                    Calendar
                </div>
            </a>
        </div>
    </div>

    <div class="item">
        <form action="#">
            <div class="ui mini action input">
                <input type="text" placeholder="Search..." />
                <button class="ui mini icon button">
                    <i class=" search icon"></i>
                </button>
            </div>
        </form>
    </div>
    <div class="ui segment inverted">
        <div class="ui tiny olive inverted progress">
            <div class="bar" style="width: 54%"></div>
            <div class="label">Monthly Bandwidth</div>
        </div>

        <div class="ui tiny teal inverted progress">
            <div class="bar" style="width:78%"></div>
            <div class="label">Disk Usage</div>
        </div>
    </div>
</div>
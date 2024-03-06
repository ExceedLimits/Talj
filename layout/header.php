


    <nav class="ui menu inverted borderless" >
        <div class="header item">
            <img src="<?php Router::getAsset("images/logo.png")?>" class="ui middle aligned tiny image" alt="img"> <h2 style="margin: 0"><?php echo APP_NAME?></h2>
        </div>

        <div class="right item">
            <div class="ui compact menu inverted">
                <div class="ui simple dropdown item">
                    <i class="user large circle icon"></i>
                    <div class="left menu">
                        <div class="item" style="background: #E2013D!important;"><a href="<?= Router::resource("logout")->operation("")->arg("")->url() ?>"><i class="sign-out icon"></i> Logout</a></div>
                    </div>
                </div>
            </div>
        </div>
    </nav>







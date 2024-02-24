    <ul class="nav">
        <li class="nav active" style="width: 20%!important;">
            <img src="<?php getAsset("images/logo.png")?>" width="32px" style="padding: 1rem" alt="img"> <strong><?php echo APP_NAME?></strong>
        </li>
    <?php if (isset($_SESSION['user_logged_in']) && $_SESSION['user_logged_in'] == true): ?>
        <li class="nav user" style="flex-flow: column;">
            <a href="#" style="align-content: center;align-items: center;padding: 0.1rem;color: #E2013D">
                <h5 style="margin: 0;padding: 0.2rem;font-size: medium"><i class="fa fa-user"></i> Ammar </h5>
            </a>

            <a href="#" style="align-content: center;align-items: center;">
                <h5 style="margin: 0;padding: 0.2rem;font-size: small"><i class="fa fa-arrow-circle-left"></i> Logout?</h5>
            </a>

        </li>
    <?php endif;?>
    </ul>



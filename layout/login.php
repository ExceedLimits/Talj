<?php
//session_start();

// Check if the user is already logged in, if yes then redirect him to welcome page
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    Router::resource("dashboard")->operation("")->arg("")->goto();
}

// Define variables and initialize with empty values
$username = $password = "";
$username_err = $password_err = $login_err = "";

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST") {

    $username = trim($_POST["username"]);

    $password = trim($_POST["password"]);

    $user = DB()->query("select * from user where username='" . $username . "'")->fetchArray();


    if ($user == []) {
        $login_err = "username not found.";
    } else {
        if (password_verify($password, $user['password'])) {
            session_start();

// Store data in session variables
            $_SESSION["loggedin"] = true;
            $_SESSION["id"] = $user['id'];
            $_SESSION["username"] = $username;

            Router::resource("dashboard")->operation("")->arg("")->goto();
        } else {
            $login_err = "Invalid username or password.";
        }
    }

}
?>
<div style="height: 100vh;width: 100%" class="ui grid middle aligned container">
    <div class="row">
        <div class="column">
            <div class="ui text container segment card" style="padding: 1.5rem">
                <div class="center aligned content">
                    <img src="<?php Router::getAsset("images/logo.png")?>" class="ui tiny image" alt="img">
                    <h1 class="ui header"><?php echo APP_NAME?></h1>
                    <h3 class="ui header">Login</h3>
                </div>
                <form method="post" class="ui form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                    <div class="ui error message">
                    </div>
                    <?php
                    if(!empty($login_err)){
                        echo '<div class="ui negative message">
                              <i class="close icon"></i>                              
                              <div class="header">'.$login_err.'</div>
                            </div>';
                    }
                    ?>
                    <div class="required field">
                        <label>Username</label>
                        <input type="text" name="username" id="username" placeholder="Username">
                    </div>
                    <div class="required field">
                        <label>Password</label>
                        <input type="password" name="password" id="password" placeholder="Password">
                    </div>
                    <div class="field">
                        <div class="ui checkbox">
                            <input type="checkbox" name="remember">
                            <label>Remember Me</label>
                        </div>
                    </div>
                    <button class="ui red button" type="submit">Login</button>
                </form>
            </div>
        </div>
    </div>
</div>

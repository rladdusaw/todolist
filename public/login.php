<?php require_once("../resources/functions.php"); ?>
<?php require_once("../resources/database_setup.php"); ?>
<?php session_start(); ?>
<?php require_once("../resources/form_validation.php");?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Login</title>
    <link href="/todolist/resources/static/bootstrap/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <?php require_once("../resources/navbar.php") ?>
    <?php
        $errors = array();
        if (isset($_POST['submit'])) {
            $username = mysqli_real_escape_string($db, $_POST['username']);
            $password = mysqli_real_escape_string($db, $_POST['password']);
            
            $required_fields = array("username", "password");
            field_value_exists($required_fields);
        
            if (empty($errors)) {
                $found_account = attempt_login($username, $password);
                if ($found_account) {
                    $_SESSION["user_id"] = $found_account["id"];
                    $_SESSION["username"] = $found_account["username"];
                    mysqli_free_result($found_account);
                    redirect_to("./profile.php");
                } else {
                    $errors["username"] = "Username/password not found.";
                }
            }
        }
    ?>
    <div class="container col-md-6 col-md-offset-3">
        <form class="form-horizontal" role="form" action="login.php" method="POST">
            <div class="form-group">
                <label for="username" class="col-sm-2 control-label">Username</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="id_username" name="username">
                    <?php
                        if (isset($errors['username'])) {
                            echo "<p class='text-danger'>" . $errors['username'] . "</p>";
                        }
                    ?>
                </div>
            </div>
            <div class="form-group">
                <label for="password" class="col-sm-2 control-label">Password</label>
                <div class="col-sm-10">
                    <input type="password" class="form-control" id="id_password" name="password">
                    <?php
                        if (isset($errors['password'])) {
                            echo "<p class='text-danger'>" . $errors['password'] . "</p>";
                        }
                    ?>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-10 col-sm-offset-2">
                    <input id="id_submit" name="submit" type="submit" value="Login" class="btn btn-primary">
                </div>
            </div>
        </form>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="/todolist/resources/static/bootstrap/js/bootstrap.min.js"></script>
</body>
</html>

<?php
    mysqli_close($db);
?>
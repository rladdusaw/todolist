<?php require_once("../resources/functions.php"); ?>
<?php require_once("../resources/database_setup.php"); ?>
<?php require_once("../resources/form_validation.php"); ?>
<?php session_start(); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Register</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
</head>
<body>
    <?php require_once("../resources/navbar.php") ?>
    <?php $errors = array(); ?>
    <?php
        if (isset($_POST['submit'])) {
            $username = mysqli_real_escape_string($db, $_POST['username']);
            $password1 = mysqli_real_escape_string($db, $_POST['password1']);
            $password2 = mysqli_real_escape_string($db, $_POST['password2']);
            
            // Field validation
            $required_fields = array("username", "password1", "password2");
            field_value_exists($required_fields);
           
            username_is_unique($username);
            
            $password_fields = array("password1", "password2");
            passwords_match($password_fields);
            
            // Make sure username isn't taken and create user.
            if (empty($errors)) {
                $hashed_pass = password_hash($password1, PASSWORD_BCRYPT);
                $query  = "INSERT INTO users ( ";
                $query .= "username, password";
                $query .= ") VALUES ( ";
                $query .= "'{$username}', '{$hashed_pass}'";
                $query .= ");";
                $insert_result = mysqli_query($db, $query);
                
                $found_account = attempt_login($username, $password1);
                if ($found_account) {
                    $_SESSION["user_id"] = $found_account["id"];
                    $_SESSION["username"] = $found_account["username"];
                    redirect_to("./profile.php");
                } else {
                    $_SESSION["message"] = "Username/password not found.";
                }
                mysqli_free_result($found_account);
            }
        }
    ?>
    <div class="container col-md-6 col-md-offset-3">
        <form class="form-horizontal" role="form" action="register.php" method="POST">
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
                <label for="password1" class="col-sm-2 control-label">Password</label>
                <div class="col-sm-10">
                    <input type="password" class="form-control" id="id_password1" name="password1">
                    <?php 
                        if (isset($errors['password1'])) {
                            echo "<p class='text-danger'>" . $errors['password1'] . "</p>";
                        }
                    ?>
                </div>
            </div>
            <div class="form-group">
                <label for="password2" class="col-sm-2 control-label">Repeat Password</label>
                <div class="col-sm-10">
                    <input type="password" class="form-control" id="id_password2" name="password2">
                    <?php 
                        if (isset($errors['password2'])) {
                            echo "<p class='text-danger'>" . $errors['password2'] . "</p>";
                        }
                    ?>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-10 col-sm-offset-2">
                    <input id="id_submit" name="submit" type="submit" value="Create Account" class="btn btn-primary">
                </div>
            </div>
        </form>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
</body>
</html>

<?php
    mysqli_close($db);
?>
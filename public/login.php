<?php require_once("../resources/functions.php"); ?>
<?php require_once("../resources/database_setup.php"); ?>
<?php session_start(); ?>

<!DOCTYPE html>

<head>
    <title>Login</title>
    <link href="/todolist/resources/static/bootstrap/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <?php require_once("../resources/navbar.php") ?>
    <form action="login.php" method="POST">
        Username:<br>
        <input type="text" name="username"><br>
        Password:<br>
        <input type="password" name="password"><br><br>
        <input type="submit" name="submit" value="Submit">
    </form>
    <?php
        if (isset($_POST['submit'])) {
            $username = mysqli_real_escape_string($db, $_POST['username']);
            $password = mysqli_real_escape_string($db, $_POST['password']);
            if (empty($errors)) {
                $found_account = attempt_login($username, $password);
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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="/todolist/resources/static/bootstrap/js/bootstrap.min.js"></script>
</body>

<?php
    mysqli_close($db);
?>
<?php
    require_once("../resources/functions.php");
    require_once("../resources/database_setup.php");
    session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Register</title>
</head>
<body>
    <form action="./register.php" method="POST">
        Username:<br>
        <input type="text" name="username"><br>
        Password:<br>
        <input type="password" name="password1"><br>
        Repeat Password:<br>
        <input type="password" name="password2"><br><br>
        <input type="submit" name="submit" value="Create Account">
    </form>
    <?php
        if (isset($_POST['submit'])) {
            $username = mysqli_real_escape_string($db, $_POST['username']);
            $password1 = mysqli_real_escape_string($db, $_POST['password1']);
            $password2 = mysqli_real_escape_string($db, $_POST['password2']);
            if ($password1 === $password2) {
                $query  = "SELECT * ";
                $query .= "FROM users ";
                $query .= "WHERE username = '$username';";
                $result = mysqli_query($db, $query);
                if ($result->num_rows === 0) {
                    $hashed_pass = password_hash($password1, PASSWORD_BCRYPT);
                    $query  = "INSERT INTO users ( ";
                    $query .= "username, password";
                    $query .= ") VALUES ( ";
                    $query .= "'{$username}', '{$hashed_pass}'";
                    $query .= ")";
                    $insert_result = mysqli_query($db, $query);
                } else {
                    die("database query failed");
                }
                mysqli_free_result($result);
            }
            if (empty($errors)) {
                $found_account = attempt_login($username, $password1);
                if ($found_account) {
                    $_SESSION["user_id"] = $found_account["id"];
                    $_SESSION["username"] = $found_account["username"];
                    redirect_to("./profile.php");
                } else {
                    $_SESSION["message"] = "Username/password not found.";
                }
            }
        }
    ?>
</body>
</html>

<?php
    mysqli_close($db);
?>
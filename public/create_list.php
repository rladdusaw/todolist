<?php session_start(); ?>
<?php require_once("../resources/functions.php"); ?>
<?php confirm_logged_in(); ?>
<?php require_once("../resources/database_setup.php"); ?>

<!DOCTYPE html>

<html lang="en">
<head>
    <title>Profile</title>
    <link href="/todolist/resources/static/bootstrap/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <?php require_once("../resources/navbar.php") ?>
    <div class="contianer col-md-4 col-md-offset-4">
        <form action="create_list.php" method="POST">
            List Name:<br>
            <input type="text" name="name"><br>
            <input type="submit" name="submit" value="Create List">
        </form>
    </div>
    
    <?php
        $safe_user_id = mysqli_real_escape_string($db, $_SESSION['user_id']);
        if (isset($_POST['submit'])) {
            $name = mysqli_real_escape_string($db, $_POST['name']);
            $new_item = create_new_list($name, $safe_user_id);
            mysqli_free_result($new_item);
            redirect_to("profile.php");
        }
    ?>
    <a href="profile.php">Profile</a>
    <br>
    <a href="logout.php">Logout</a>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="/todolist/resources/static/bootstrap/js/bootstrap.min.js"></script>
</body>
</html>

<?php
    mysqli_close($db);
?>
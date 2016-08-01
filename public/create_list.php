<?php session_start(); ?>
<?php require_once("../resources/functions.php"); ?>
<?php require_once("../resources/database_setup.php"); ?>

<!DOCTYPE html>

<html>
<head>
    <title>Profile</title>
</head>
<body>
    <form action="create_list.php" method="POST">
        List Name:<br>
        <input type="text" name="name"><br>
        <input type="submit" name="submit" value="Create List">
    </form>
    
    <?php
        $safe_user_id = mysqli_real_escape_string($db, $_SESSION['user_id']);
        if (isset($_POST['submit'])) {
            $name = mysqli_real_escape_string($db, $_POST['name']);
            $new_item = create_new_list($name, $safe_user_id);
            redirect_to("profile.php");
        }
    ?>
    <a href="profile.php">Profile</a>
    <br>
    <a href="logout.php">Logout</a>
</body>
</html>

<?php
    mysqli_close($db);
?>
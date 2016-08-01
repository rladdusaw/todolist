<?php session_start(); ?>
<?php require_once("../resources/functions.php"); ?>
<?php confirm_logged_in(); ?>
<?php require_once("../resources/database_setup.php"); ?>

<!DOCTYPE html>

<html>
<head>
    <title>Profile</title>
    <link href="/todolist/resources/static/bootstrap/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <?php require_once("../resources/navbar.php") ?>
    <?php
        $user_id = mysqli_real_escape_string($db, $_SESSION["user_id"]);
        $lists = find_all_user_lists($user_id);
        if ($lists) {
            while ($list = $lists->fetch_assoc()) {
                echo '<a href="update_list.php/?id=' . $list["id"] . '">' .
                    $list["name"] .'</a><br>';
            }
        }
    ?>
    <a href="create_list.php">Create a new list.</a>
    <br>
    <a href="logout.php">Logout</a>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="/todolist/resources/static/bootstrap/js/bootstrap.min.js"></script>
</body>
</html>

<?php
    mysqli_close($db);
?>
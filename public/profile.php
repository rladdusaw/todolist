<?php session_start(); ?>
<?php require_once("../resources/functions.php"); ?>
<?php require_once("../resources/database_setup.php"); ?>

<!DOCTYPE html>

<html>
<head>
    <title>Profile</title>
</head>
<body>
    <?php 
        $lists = find_all_user_lists($_SESSION["user_id"]);
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
</body>
</html>

<?php
    mysqli_close($db);
?>
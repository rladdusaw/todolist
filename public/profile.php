<?php session_start(); ?>
<?php require_once("../resources/functions.php"); ?>
<?php confirm_logged_in(); ?>
<?php require_once("../resources/database_setup.php"); ?>

<!DOCTYPE html>

<html lang="en">
<head>
    <title>Profile</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
</head>
<body>
    
    <?php require_once("../resources/navbar.php") ?>
    <div class="container col-md-6 col-md-offset-3">
        <div class="jumbotron">
            <h1>Your To-Do Lists</h1>
        </div>
    </div>
    <div class="container col-md-6 col-md-offset-3">
        <div class="row">
            <?php
                $user_id = mysqli_real_escape_string($db, $_SESSION["user_id"]);
                $lists = find_all_user_lists($user_id);
                if ($lists) {
                    while ($list = $lists->fetch_assoc()) {
                        echo '<div class="col-sm-8"><pre>' . $list['name'] . '</pre></div>';
                        echo '<div class="col-sm-2"><a href="update_list.php/?id=' . $list['id'] .
                            '" class="btn btn-primary btn-block">Edit</a></div>';
                        echo '<div class="col-sm-2"><a href="delete_list.php/?list_id=' . $list["id"] . 
                            '" class="btn btn-danger btn-block">Delete</a></div>';
                    }
                }
            ?>
        </div>
        <div class="row">
            <a href="create_list.php" class="btn btn-primary btn-block">Create a new list.</a>
        </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
</body>
</html>

<?php
    mysqli_close($db);
?>
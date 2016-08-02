<?php session_start(); ?>
<?php require_once("../resources/functions.php"); ?>
<?php confirm_logged_in(); ?>
<?php require_once("../resources/database_setup.php"); ?>
<?php require_once("../resources/form_validation.php");?>

<!DOCTYPE html>

<html lang="en">
<head>
    <title>Profile</title>
    <link href="/todolist/resources/static/bootstrap/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <?php require_once("../resources/navbar.php") ?>
    <?php $errors = array(); ?>
    <?php
        $safe_user_id = mysqli_real_escape_string($db, $_SESSION['user_id']);
        if (isset($_POST['submit'])) {
            $name = mysqli_real_escape_string($db, $_POST['name']);
            
            // Field validation
            $required_fields = array("name");
            field_value_exists($required_fields);
            
            if (empty($errors)) {
                $new_item = create_new_list($name, $safe_user_id);
                mysqli_free_result($new_item);
                redirect_to("profile.php");
            }
        }
    ?>
    <div class="contianer col-md-4 col-md-offset-4">
        <form class="form-horizontal" role="form" action="create_list.php" method="POST">
            <div class="form-group">
                <label for="name" class="col-sm-2 control-label">Name</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="id_name" name="name">
                    <?php
                        if (isset($errors['name'])) {
                            echo "<p class='text-danger'>" . $errors['name'] . "</p>";
                        }
                    ?>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-10 col-sm-offset-2">
                    <div class="row">
                        <div class="col-sm-6">
                            <input id="submit" type="submit" name="submit" value="Create List" class="btn btn-primary btn-block">
                        </div>
                        <div class="col-sm-6">
                            <a href="profile.php" class="btn btn-default btn-block" role="button">Cancel</a>
                        </div>
                    </div>
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
<?php session_start(); ?>
<?php require_once("../resources/functions.php"); ?>
<?php require_once("../resources/database_setup.php"); ?>
<?php require_once("../resources/form_validation.php");?>
<?php
    if (!isset($_SESSION['user_id'])) {
            redirect_to("../login.php");
        }
 ?>
<?php require_once("../resources/database_setup.php"); ?>

<!DOCTYPE html>

<html lang="en">
<head>
    <title>List Detail</title>
    <link href="/todolist/resources/static/bootstrap/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <?php require_once("../resources/navbar.php") ?>
    <?php $list_id = mysqli_real_escape_string($db, $_GET['id']); ?>
    <div class="container col-md-6 col-md-offset-3">
        <div class="jumbotron">
            <h1><?php echo mysqli_fetch_assoc(get_list_name($list_id))['name']; ?></h1>
        </div>
    </div>
    <div class="container col-md-6 col-md-offset-4">
        <?php
            if (isset($_POST['submit'])) {
                $note = mysqli_real_escape_string($db, $_POST['note']);
                
                // Field validation
                $required_fields = array("note");
                field_value_exists($required_fields);
                
                if (empty($errors)) {
                    create_new_list_item($note, $list_id);
                }
            }
            $list_items = find_all_list_items($list_id);
        ?>
        
        <div class="row">
            <?php
                while ($item = mysqli_fetch_assoc($list_items)) {
                    echo '<div class="col-sm-8"><pre>' . $item['note'] . '</pre></div>';
                    echo '<div class="col-sm-2"><a href="../edit_item.php/?list_id=' . 
                        $item['list_id'] .'&item_id=' . $item['id'] . 
                        '" class="btn btn-warning btn-block">Edit</a></div>';
                    echo '<div class="col-sm-2"><a href="../delete_item.php/?list_id=' .
                        $item['list_id'] . '&item_id=' . $item['id'] . 
                        '" class="btn btn-danger btn-block">Delete</a></div>';
                }
            ?>
        </div>
    
        <?php mysqli_free_result($list_items); ?>
        <form class="form-horizontal" role="form" action=<?php echo "../update_list.php/?id=" . $list_id ?> method="POST">
            <div class="row">
                <div class="col-sm-8">
                    <div class="form-group">
                        <input type="text" class="form-control" id="id_note" name="note">
                        <?php
                            if (isset($errors['note'])) {
                                echo "<p class='text-danger'>" . $errors['note'] . "</p>";
                            }
                        ?>
                    </div>
                </div>
                <div class="col-sm-2">
                    <input id="submit" type="submit" name="submit" value="Add Item" class="btn btn-primary btn-block">
                </div>
                <div class="col-sm-2">
                    <a href="../profile.php" class="btn btn-default btn-block">Cancel</a>
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
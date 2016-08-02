<?php session_start(); ?>
<?php require_once("../resources/functions.php"); ?>
<?php confirm_logged_in(); ?>
<?php require_once("../resources/database_setup.php"); ?>
<?php require_once("../resources/form_validation.php");?>

<!DOCTYPE html>

<html lang="en">
<head>
    <title>List Detail</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
</head>
<body>
    <?php require_once("../resources/navbar2.php") ?>
    <?php 
        $list_id = mysqli_real_escape_string($db, $_GET['list_id']);
        $item_id = mysqli_real_escape_string($db, $_GET['item_id']);
        $old_note_query = get_item_note($list_id, $item_id);
        $old_note = mysqli_fetch_assoc($old_note_query)['note'];
        $safe_old_note = mysqli_real_escape_string($db, $old_note);
        
        if (isset($_POST['submit'])) {
                $note = mysqli_real_escape_string($db, $_POST['note']);
                
                // Field validation
                $required_fields = array("note");
                field_value_exists($required_fields);
                
                if (empty($errors)) {
                    update_list_item($list_id, $item_id, $note);
                    redirect_to("../update_list.php/?id=" . $list_id);
                }
            }
    ?>
    
    <div class="contianer col-md-4 col-md-offset-4">
        <form class="form-horizontal" role="form" action="../edit_item.php/?list_id=<?php echo $list_id ?>&item_id=<?php echo $item_id ?>" method="POST">
            <div class="form-group">
                <label for="note" class="col-sm-3 control-label">New Note</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="id_note" name="note" placeholder="<?php echo $old_note ?>">
                    <?php
                        if (isset($errors['note'])) {
                            echo "<p class='text-danger'>" . $errors['note'] . "</p>";
                        }
                    ?>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-10 col-sm-offset-3">
                    <div class="row">
                        <div class="col-sm-5">
                            <input id="submit" type="submit" name="submit" value="Update Note" class="btn btn-primary btn-block">
                        </div>
                        <div class="col-sm-5">
                            <a href="../update_list.php/?id=<?php echo $list_id ?>" class="btn btn-default btn-block" role="button">Cancel</a>
                        </div>
                    </div>
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
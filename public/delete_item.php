<?php session_start(); ?>
<?php require_once("../resources/functions.php"); ?>
<?php confirm_logged_in(); ?>
<?php require_once("../resources/database_setup.php"); ?>
<?php require_once("../resources/form_validation.php");?>
    
<?php 
    $list_id = mysqli_real_escape_string($db, $_GET['list_id']);
    $item_id = mysqli_real_escape_string($db, $_GET['item_id']);
    $user_id = mysqli_real_escape_string($db, $_SESSION['user_id']);
    if ($item_id !== '') {
        delete_list_item($user_id, $list_id, $item_id);
        redirect_to("../update_list.php/?id=" . $list_id);
    }
    mysqli_close($db);
?>
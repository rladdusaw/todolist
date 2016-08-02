<?php session_start(); ?>
<?php require_once("../resources/functions.php"); ?>
<?php confirm_logged_in(); ?>
<?php require_once("../resources/database_setup.php"); ?>
<?php require_once("../resources/form_validation.php");?>
    
<?php 
    $list_id = mysqli_real_escape_string($db, $_GET['list_id']);
    $user_id = mysqli_real_escape_string($db, $_SESSION['user_id']);
    if ($list_id !== '') {
        delete_list($user_id, $list_id);
        redirect_to("../profile.php");
    }
    mysqli_close($db);
?>
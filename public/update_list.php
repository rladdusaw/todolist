<?php session_start(); ?>
<?php require_once("../resources/functions.php"); ?>
<?php
    if (!isset($_SESSION['user_id'])) {
            redirect_to("../login.php");
        }
 ?>
<?php require_once("../resources/database_setup.php"); ?>

<!DOCTYPE html>

<html>
<head>
    <title>List Detail</title>
</head>
<body>
    <?php
        $list_id = mysqli_real_escape_string($db, $_GET['id']);
        
        if (isset($_POST['submit'])) {
            $note = mysqli_real_escape_string($db, $_POST['note']);
            create_new_list_item($note, $list_id);
        }
        $list_items = find_all_list_items($list_id);
        while ($item = mysqli_fetch_assoc($list_items)) {
            echo '<p>' . $item['note'] . '</p>';
        }
        mysqli_free_result($list_items);
    ?>
    <form action=<?php echo "../update_list.php/?id=" . $list_id ?> method="POST">
        List Name: 
        <?php echo mysqli_fetch_assoc(get_list_name($list_id))['name']; ?>
        <br>
        <input type="text" name="note"><br>
        <input type="submit" name="submit" value="Add Item">
    </form>
    
    
    <a href="../profile.php">Profile</a>
    <br>
    <a href=<?php echo "../update_list.php/?" . $list_id ?>>Logout</a>
</body>
</html>

<?php
    mysqli_close($db);
?>
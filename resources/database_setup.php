<?php
    include("configuration.php");
    $db = mysqli_connect(
        'localhost', $db_user,
        $db_pass, 'to_do_list'
    );
    
    if (mysqli_connect_errno()) {
        die(
            "Database connection failed: " . mysqli_connect_error() .
            " (" . mysqli_connect_errno() .")"
        );
    }
?>
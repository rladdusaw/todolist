<?php session_start() ?>

<!DOCTYPE html>

<html lang="en">
<head>
    <title>To-Do List</title>
    <link href="/todolist/resources/static/bootstrap/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <?php require_once("../resources/navbar.php") ?>
    <div class="container col-md-6 col-md-offset-3">
        <a class="btn btn-large btn-default" role="button" href="login.php">Login</a>
        <a class="btn btn-large btn-default" role="button" href="register.php">Register</a>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="/todolist/resources/static/bootstrap/js/bootstrap.min.js"></script>
</body>
</html>
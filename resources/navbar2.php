<?php require_once("functions.php"); ?>

<nav class="navbar navbar-inverse navbar-static-top">
    <div class="container">
        <div class="navbar-header">
            <button class="navbar-toggle collapsed" aria-controls="navbar" aria-expanded="false" data-target="#navbar" data-togle="collapse" type="button">
                <span class="sr-only"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="index.php">To-Do List</a>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
            <ul class="nav navbar-nav">
                <?php
                    if (!logged_in()) { 
                        echo '<li id="id_login_navbar">
                            <a href="../login.php">Login</a>
                        </li>';
                    } else {
                        echo '<li id="id_profile_navbar">
                            <a href="../profile.php">Profile</a>
                        </li>
                        <li id="id_logout_navbar">
                            <a href="../logout.php">Logout</a>
                        </li>';
                    }
                ?>
            </ul>
        </div>
    </div>
</nav>
<br>
    
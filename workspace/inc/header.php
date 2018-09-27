<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="stylesheet" href="css/boostrap.css">
    <title>WorkSpace</title>


</head>

<body>

<nav class="navbar navbar-inverse">
    <div class="container">
        <div class="navbar-header">

            <a class="navbar-brand" href="#">WorkSpace</a>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
            <ul class="nav navbar-nav">
                <?php if(isset($_SESSION['auth'])){ ?>
                    <li ><a href="logout.php">Log Out</a></li>
                <?php }
                else{ ?>
                    <li><a href="register.php">Register</a></li>
                    <li><a href="login.php">Log In </a></li>
                <?php } ?>
            </ul>
        </div><!--/.nav-collapse -->
    </div>
</nav>

<div class="container">

    <?php
    if (isset($_SESSION['flash'])):
        foreach ($_SESSION['flash'] as $type => $message):?>
            <div class="alert alert-<?= $type; ?>" class>
                <?=$message ?>
            </div>
        <?php endforeach; ?>
    <?php unset($_SESSION["flash"]);?>
    <?php endif; ?>
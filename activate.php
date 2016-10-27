<?php
/**
 * Created by PhpStorm.
 * User: bendz
 * Date: 19. 10. 2016
 * Time: 01:30
 */
session_start();
include "connection.php";


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible"
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <link href="styling.css"  rel="stylesheet">
    <title>Account activation</title>
    <link href="css/bootstrap.min.css"
          rel="stylesheet">
    <style>
h1{
    color:blue;
}
        .contactform{
    border: 1px solid #7c73f6;
            margin-top: 50px;
            border-radius: 15px;
        }
    </style>
</head>
<body>
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-offset-1 col-sm-10 contactform">
            <h1>Account activation</h1>
            <?php

            //if mail and key missing
            if(!isset($_GET["email"]) || !isset($_GET["key"]) ) {
                echo "<div class='alert alert-danger'>There was an error. Please click on the activation you recived by email</div>";
                exit;
            }

            $email = $_GET["email"];
            $key = $_GET["key"];

            $email = mysqli_real_escape_string($link,$email);
            $key = mysqli_real_escape_string($link,$key);

            $sql = "UPDATE user SET activation = 'activated' WHERE (email = '$email' AND activation = '$key') LIMIT 1";
            $result = mysqli_query($link,$sql);

            if(mysqli_affected_rows($link) == 1) {
                echo "<div class='alert alert-success'>Your account has been activated</div>";
                echo '<strong><a href="index.php" type="button" class="btn blue">Log in</a></strong>';

            }else {
                echo "<div class='alert alert-danger'>Your account could not be activated. Please try again later !</div>";
                exit;
            }
            ?>


</div>
</div>


</div>
<script
    src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/j
	query.min.js"></script>
<script src="js/bootstrap.min.js"></script>
</body>
</html>

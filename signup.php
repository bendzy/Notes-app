<?php
/**
 * Created by PhpStorm.
 * User: bendz
 * Date: 19. 10. 2016
 * Time: 01:30
 */
//START session
//Connect to the database

session_start();
include ("connection.php");

// Error messages
$missingUsername ="<p><strong>Please enter your username !</strong></p>";
$missingEmail ="<p><strong>Please enter your email address !</strong></p>";
$invalidEmail ="<p><strong>Please enter a valid Email !</strong></p>";
$missingPassword ="<p><stro><strong>Please enter a Password</strong></stro></p>";
$invalidPassword="<p><strong>Your password should be at least 6 characters long and include one capital letter and one number !</strong></p>";
$diffrentPassword ="<p><strong>Passwords don't match !</strong></p>";
$missingPassword2 = "<p><strong>Please confirm password !</strong></p>";
$errors = " ";


    // User inputs
    //username
if(isset($_POST)) {


    if (empty($_POST["username"])) {
        $errors .= $missingUsername;
    } else {
        $username = filter_var($_POST["username"], FILTER_SANITIZE_STRING);
    }

    //email
    if (empty($_POST["email"]) ) {
        $errors .= $missingEmail;
    } else {
        $email = filter_var($_POST["email"], FILTER_SANITIZE_EMAIL);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors .= $invalidEmail;
        }
    }

    //password
    if (empty($_POST["password"])) {
        $errors .= $missingPassword;
    } elseif (!(strlen($_POST["password"]) > 6 && preg_match("/[A-Z]/", $_POST["password"])
        && preg_match("/[0-9]/", $_POST["password"]))
    ) {
        $errors .= $invalidPassword;
    } else {
        $password = filter_var($_POST["password"], FILTER_SANITIZE_STRING);
        if (empty($_POST["password2"])) {
            $errors .= $missingPassword2;
        } else {
            $password2 = filter_var($_POST["password2"], FILTER_SANITIZE_STRING);
            if ($password !== $password2) {
                $errors .= $diffrentPassword;
            }
        }
    }

    //check fi any errors

    if ($errors) {
        $resultMessage = "<div class='alert alert-danger'>$errors</div>";
        echo $resultMessage;
    }
    //No errors
    $username = @mysqli_real_escape_string($link, $username);
    $email = @mysqli_real_escape_string($link, $email);
    $password = @mysqli_real_escape_string($link, $password);
   // $password = md5($password);  // 2 razniclna passworda lahko prikazeta isti md5 hash
    $password = hash('sha256',$password);

    //Check if user is already registered in DB
    $sql = "SELECT * FROM user WHERE username ='$username'";
    $result = mysqli_query($link, $sql);

    if (!$result) {
        echo "<div class='alert alert-danger'>Error running the query</div>";
        echo "<div class='alert alert-danger'>".mysqli_error($link)."</div>";
        exit;
    }
    $results = mysqli_num_rows($result);
    if ($results) {
        echo "<div class='alert alert-danger'>That username is already registered. Do you want logi in ?</div>";
        echo "<div class='alert alert-danger'>".mysqli_error($link)."</div>";
        exit;
    }

    //Check if email is already registered
    $sql = "SELECT * FROM user WHERE email ='$email'";
    $result = mysqli_query($link, $sql);

    if (!$result) {
        echo "<div class='alert alert-danger'>Error running the query</div>";
        exit;
    }
    $results = mysqli_num_rows($result);
    if ($results) {
        echo "<div class='alert alert-danger'>That Email is already registered. Do you want logi in ?</div>";
        exit;
    }


    //Create uniqe activation code
    //byte unit of data 8 binary  8 bits 0 or 1
    //16bytes = 16*8 = 128 bits
    // 32 character in users table ctivation row
    $activationKey = bin2hex( openssl_random_pseudo_bytes(16));

    $sql="INSERT INTO `user` ( `username`, `email`, `password`, `activation`) VALUES ('$username','$email','$password','$activationKey')";

    $result = mysqli_query($link,$sql);

    if(!$result) {
        echo "<div class='alert alert-danger'>There was error inserting user details in the database</div>";
        echo "<div class='alert alert-danger'>".mysqli_error($link)."</div>";
        exit;
    }

    //Send email to the user
    $message = "Please click on this link to activate your account : \n\n";
    //allways use urlencoce for email
    $message .= "http://http://localhost/notesapp/activate.php?email=".urlencode($email)."&key=".$activationKey;

        if( mail($email,'Confirm your Registration',$message,'From : '.'developmentiland@gmail.com') ) {
            echo "<div class='alert alert-success'>Thank you for your registration. A confirm email has been sent to your
            email address</div>";
        }

}


?>
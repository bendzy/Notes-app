<?php

include ("connection.php");
require ("PHPMailer/PHPMailerAutoload.php");

session_start(); //sesion for storing data




// Error messages
$missingUsername ="<p><strong>Please enter your username!</strong></p>";
$missingEmail ="<p><strong>Please enter your email address!</strong></p>";
$invalidEmail ="<p><strong>Please enter a valid Email!</strong></p>";
$missingPassword ="<p><stro><strong>Please enter a Password!</strong></stro></p>";
$invalidPassword="<p><strong>Your password should be at least 6 characters long and include one capital letter and one number !</strong></p>";
$diffrentPassword ="<p><strong>Passwords don't match!</strong></p>";
$missingPassword2 = "<p><strong>Please confirm password!</strong></p>";
$errors = "";

//Check if inputs are missing, if not clean them and store them

    if(empty($_POST["username"])){
        $errors .= $missingUsername;
    }
    else {
        $username = filter_var($_POST["username"], FILTER_SANITIZE_STRING );
    }

    if(empty($_POST["email"])){
        $errors .= $missingEmail;
    }
    else {
        $email = filter_var($_POST["email"], FILTER_SANITIZE_EMAIL );
            if( !filter_var($email, FILTER_VALIDATE_EMAIL )) {
                    $errors .= $invalidEmail;
            }
    }

    if(empty($_POST["password"])){
        $errors .= $missingPassword;
    }
    elseif ( !(strlen($_POST["password"]) > 6 && preg_match('/[A-Z]/',$_POST["password"]) && preg_match('/[0-9]/'
        , $_POST["password"]))) {
        $errors .= $invalidPassword;
    }
    else {
        $password = filter_var($_POST["password"], FILTER_SANITIZE_STRING);

        //password2
            if(empty($_POST["password2"])) {
                $errors .= $missingPassword2;
            }
            else {
                $password2 = filter_var($_POST["password2"],FILTER_SANITIZE_STRING);
                    //check password
                if($password !== $password2) {
                    $errors .= $diffrentPassword;
                }
            }
    }

   

   //If there are any errors print error
    if($errors){
  
        $resultMessage = '<div class="alert alert-danger">' . $errors .'</div>';
        echo $resultMessage;
        exit;
    }
    //No errors
    //Prepra variables for queries
    $username = mysqli_real_escape_string($link, $username);
    $email = mysqli_real_escape_string($link, $email);
    $password = mysqli_real_escape_string($link,$password);
    //hash password
    $password = hash('sha256',$password);

    //check if username exists in datababse
    $sql = "SELECT * FROM users WHERE username = '$username'";
    $result = mysqli_query($link, $sql);

    //Check if query is succesffull
    if(!$result) {
        echo '<div class="alert alert-danger"> Error running the query</div>';
        exit;
    }

    //getting number of rows
    $results = mysqli_num_rows($result);
        if($results) {
           echo '<div class="alert alert-danger"> That username is already registered. Do you want login ?</div>';
            exit;  
        }

    //Check if username exists in datababse

    $sql = "SELECT * FROM users WHERE email = '$email'";
    $result = mysqli_query($link, $sql);

    //check if query is succesffull
    if(!$result) {
        echo '<div class="alert alert-danger"> Error running the query</div>';
        exit;
    }

    //getting number of rows
    $results = mysqli_num_rows($result);
        if($results) {
           echo '<div class="alert alert-danger"> That email is already registered. Do you want login ?</div>';
            exit;  
        }   

     //Create unique activition code for confirmation email 
        $activationKey = bin2hex(openssl_random_pseudo_bytes(16));
      //Insert user detais and activation code to table  

       $sql = "INSERT INTO users (`username`, `email`, `password`, `activation`) VALUES ('$username', '$email', '$password', '$activationKey')";


        $result = mysqli_query($link,$sql);

        if(!$result) {
            echo '<div class="alert alert-danger"> There was an error inserting the user details in the database</div>';
            echo mysqli_error($link);
            exit;   
        }

        //Send email to the user

        $message = "Please click on this link to activate your account : \n\n";
        //concatenate message with GET parameters, user url encode for email 
        $message .= "http://http://localhost/notesapp/activate.php?email=".urlencode($email)."&key=".$activationKey;


        $mail = new PHPMailer;
        $mail->IsSMTP();                           // Set mailer to use SMTP
        $mail->Host = 'smtp.gmail.com';  // Specify main and backup server
        $mail->SMTPAuth = true;                // Enable SMTP authentication
        $mail->Username = 'bendzy.ex@gmail.com';         // SMTP username
        $mail->Password = 'mada20faka15';              // SMTP password
        $mail->SMTPSecure = 'tls';            // Enable encryption, 'ssl' also accepted


        $mail->From = "bendzy.ex@gmail.com";
        $mail->FromName = "Benjamin";
        $mail->AddAddress($email);
        $mail->Body ="Please click on this link to activate your account : \n\n"."http://localhost/notesapp/activate.php?email=".urlencode($email)."&key=".$activationKey;
        $mail->Subject = 'Confirm your email address';

        //$mail->IsHTML(true);



            if($mail->Send()) {
                echo "<div class='alert alert-success'>Thank you for your registration. A confirm email has been sent to your email address</div>";

            }
            else {
                echo "<div class='alert alert-danger'>There was an error sending an activation email </div>";
                echo  "Email error: ". $mail->ErrorInfo;
            }



    


?>
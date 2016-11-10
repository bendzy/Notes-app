<?php
session_start();
include "connection.php";
require ("PHPMailer/PHPMailerAutoload.php");

//Check user inputs
//define error messages
$invalidEmail ="<p><strong>Please enter a valid Email!</strong></p>";
$missingPassword ="<p><stro><strong>Please enter a Password!</strong></stro></p>";
$errors = "";


//email check
 if(empty($_POST["forgotemail"])){
        $errors .= $missingEmail;
    }
    else {
        $email = filter_var($_POST["forgotemail"], FILTER_SANITIZE_EMAIL );
            if( !filter_var($email, FILTER_VALIDATE_EMAIL )) {
                    $errors .= $invalidEmail;
            }
    }


//check if there are any errors
   if($errors) {
        $resultMessage = "<div class='alert alert-danger'>$errors</div>";
        echo $resultMessage;
        exit;
    }
     //prepare  variables for queries
    $email = mysqli_real_escape_string($link, $email);
   

    //check if email extists in datababse
    $sql = "SELECT * FROM users WHERE email = '$email'";
    $result = mysqli_query($link, $sql);
    
         //get user_id and create activate key
     $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
     //getting user id
     $user_id = $row['user_id'];
    
    //check if query is succesffull

    if(!$result) {
        echo '<div class="alert alert-danger"> Error running the query</div>';
        exit;
    }

    
    //getting number of rows
    $count = mysqli_num_rows($result);
    
        if(!$count) {
           echo '<div class="alert alert-danger"> That email does not exists in our database</div>';
            exit;  
        }

     //Create unique activition code for confirmation email 
        $key = bin2hex(openssl_random_pseudo_bytes(16));
        $time = time();
        $status = "pending";

        $sql = "INSERT INTO forgotpassword (`user_id`, `rkey`, `time`, `status`) VALUES ('$user_id', '$key', '$time', '$status')";

        $result = mysqli_query($link,$sql);

         if(!$result) {
            echo '<div class="alert alert-danger"> There was an error inserting the user details in the database</div>';
            echo mysqli_error($link);
            exit;   
        }

         //Send email to the user

        $message = "Please click on this link to reset your account : \n\n";
        //concatenate message with GET parameters, user url encode for email 
        $message .= "http://localhost/notesapp/resetpassword.php?user_id=$user_id&key=$key";

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
        $mail->Body =$message;

        $mail->Subject = 'Reset your password';
        //$mail->IsHTML(true);



            if($mail->Send()) {
                echo "<div class='alert alert-success'>An email was sent to $email. Please click on the link to reset your password  </div>";

            }
            else {
                echo "<div class='alert alert-danger'>There was an error sending an activation email </div>";
                echo  "Email error: ". $mail->ErrorInfo;
            }



?>
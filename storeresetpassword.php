<?php
session_start();
include 'connection.php';


//check vars from POST method in reset password file
if( !isset($_POST['user_id']) && !isset($_POST['key']) ){
	echo "<div class='alert alert-danger'>There was an error. Please click on your  link you recived by email</div>";
	exit;
}

//if dont missing store them
$user_id = $_POST['user_id'];
$rkey = $_POST['key'];
$time = time() - 86400; // time for key, its valid only 24hours

//prepare for query
$user_id = mysqli_real_escape_string($link, $user_id);
$rkey = mysqli_real_escape_string($link, $rkey);


//check if we have combination of same address and key
//if we have set activation key activated
//run the query check for status = pending 
$sql = "SELECT user_id FROM forgotpassword WHERE rkey='$rkey' AND user_id='$user_id' AND time > '$time' AND status='pending' AND status='pending'";

$result = mysqli_query($link,$sql);
$row = mysqli_fetch_array($result,MYSQLI_ASSOC);

  if(!$result) {
      echo '<div class="alert alert-danger"> Error running the query</div>';
     echo mysqli_error($link);
     exit;   
   }
   //If combination does not exists show error message

   $count = mysqli_num_rows($result);
    if($count !==1) {
         echo '<div class="alert alert-danger">Please try again</div>';
         exit;
    }

    /* Error messages */
$missingPassword ="<p><stro><strong>Please enter a Password!</strong></stro></p>";
$invalidPassword="<p><strong>Your password should be at least 6 characters long and include one capital letter and one number !</strong></p>";
$diffrentPassword ="<p><strong>Passwords don't match!</strong></p>";
$missingPassword2 = "<p><strong>Please confirm password!</strong></p>";
$errors ="";

// GET Passwords
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

    //Prepare vars for query 
    $password = mysqli_real_escape_string($link,$password);
    //hash password
    $password = hash('sha256',$password);

    $user_id = mysqli_real_escape_string($link,$user_id);

    //Update password for user_id
    $sql = "UPDATE users SET password='$password' WHERE user_id = '$user_id'";
    $result = mysqli_query($link, $sql);

    //Check if query is succesffull
    if(!$result) {
        echo '<div class="alert alert-danger"> There was a problem storing new password!</div>';
        exit;
    }
  
    //change status of key to used not pending ! so it cant be used 2x
    $sql = "UPDATE forgotpassword SET status ='used' WHERE rkey = '$rkey' AND user_id='$user_id' ";
    $result = mysqli_query($link, $sql);
    

    //Check if query is succesffull
    if(!$result) {
        echo '<div class="alert alert-danger"> Error running the query!</div>';
        echo mysqli_error($link);
       
    }
    else {
    	echo 'Your password has been updated successfully ! <a href="localhost/notesapp/index.php">Login</a>';
    }

?>
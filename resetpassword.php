<?php
session_start();
include('connection.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible"
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <link href="styling.css"  rel="stylesheet">
    <title>Password Reset</title>
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
            <h1>Password Reset</h1>
            
            <!-- Error or Success Message for reset password -->
            <div id="resultMessage">
                
            </div>
<?php

//Check GET Parameters is they are missing

if( !isset($_GET['user_id']) && !isset($_GET['key']) ){
	echo "<div class='alert alert-danger'>There was an error. Please click on your  link you recived by email</div>";
	exit;
}

//if dont missing store them
$user_id = $_GET['user_id'];
$rkey = $_GET['key'];
$time = time() - 86400; // time for key, its valid only 24hours

//prepare for query
$user_id = mysqli_real_escape_string($link, $user_id);
$rkey = mysqli_real_escape_string($link, $rkey);


//check if we have combination of same address and key
//if we have set activation key activated
//run the query
$sql = "SELECT user_id FROM forgotpassword WHERE rkey='$rkey' AND user_id='$user_id' AND time > '$time' AND status='pending'";
$result = mysqli_query($link,$sql);
$row = mysqli_fetch_array($result,MYSQLI_ASSOC);

  if(!$result) {
      echo '<div class="alert alert-danger"> Error running the query</div>';
     echo mysqli_error($link);
     exit;   
   }
   //If combination does not exists show error message

   $count = mysqli_num_rows($result);
   
    if($count !== 1) {
         echo '<div class="alert alert-danger">Please try again</div>';
         exit;
    }
    //print form for reset password with hidden user_id and key fields
    echo "
        <form method='POST' id='passwordreset'> 
        <input type='hidden'name='key' value='$rkey'>
        <input type='hidden' name='user_id' value='$user_id'>
        <div class='form-group'> 
            
        <label for='password'> Enter your new password</label>
            <input type='password' name='password' id='password' placeholder ='Enter new password' class='form-control'>
        <br/>;
        <label for='password2'> Confirm your new password</label>
              <input type='password' name='password2' id='password2' placeholder ='Confirm new password' class='form-control'>
        <br/>
              <input type='submit' value ='Reset Password' name = 'resetpassword' class='btn btn-success btn-lg'>
        </div>


        </form>
    ";


?>
</div>
</div>


</div>
<script
    src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/j
	query.min.js"></script>
<script src="js/bootstrap.min.js"></script>



<!-- Ajax call to storereset password, send new password values -->
<script>
$("#passwordreset").submit(function(event){
        //prevent defult php from processing
        event.preventDefault();
        //collect user inputs
        var datatopost = $(this).serializeArray();
        //send them to signup.php
        $.ajax({
            url:"storeresetpassword.php",
            type:"POST",
            data: datatopost,
            success: function(data){
               $("#resultMessage").addClass('alert alert-success');
              $("#resultMessage").html(data);
          },
            error: function(data){
            
                $("#resultMessage").html(data);
            }

        });

    });


</script>
</body>
</html>
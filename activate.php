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
            <h1>Account activation</h1
<?php



//Check GET Parameters is they are missing

if( !isset($_GET['email']) && !isset($_GET['key']) ){
	echo "<div class='alert alert-danger'>There was an error. Please click on your activation link you recived by email</div>";
	exit;
}

//if dont missing store them
$email = $_GET['email'];
$key = $_GET['key'];

//prepare for query
$email = mysqli_real_escape_string($link, $email);
$key = mysqli_real_escape_string($link, $key);


//check if we have combination of same address and key
//if we have set activation key activated

$sql = "UPDATE users SET activation = 'activated' WHERE (email = '$email' and activation = '$key') LIMIT 1";

//run the query
$result = mysqli_query($link,$sql);

//check if there was a success update in DB
if (mysqli_affected_rows($link) == 1 ) {
	echo "<div class='alert alert-success'>Your account has been activated</div>";
	echo "<a href ='index.php' type='button' class='btn btn-lg btn-success'> Log in</a>";
}
else {
	echo "<div class='alert alert-danger'>Your account can not be activated. Please try again later !</div>";
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
<?php
session_start();
include('connection.php');

$missingEmail = '<p><strong>Please enter email address</strong></p>';
$missingPassword = '<p><strong>Please enter your password</strong></p>';
$errors = "";


//check inputs
if(empty($_POST["loginemail"])){
        $errors .= $missingEmail;
    }
    else {
        $email = filter_var($_POST["loginemail"], FILTER_SANITIZE_EMAIL );      
    }

if(empty($_POST["loginpassword"])){
        $errors .= $missingPassword;
    }
    else {
        $password = filter_var($_POST["loginpassword"], FILTER_SANITIZE_STRING );      
    }
    
   //Check if there are any errors
    if($errors) {
        $resultMessage = "<div class='alert alert-danger'>$errors</div>";
        echo $resultMessage;


    }
    else {
    	//No eerors
    	//prepare vars
    	$email = mysqli_real_escape_string($link,$email);
    	$password = mysqli_real_escape_string($link,$password);
    	$password = hash('sha256',$password);
    

	    //statement
	    $sql = "SELECT * FROM users WHERE(email = '$email' and password = '$password' and activation = 'activated')";

	    //run q
	    $result = mysqli_query($link,$sql);
	    //Check if query is succesffull
	    if(!$result) {
	        echo '<div class="alert alert-danger"> Error running the query</div>';
	        echo mysqli_error($link);
	        exit;
	    }

	    $count = mysqli_num_rows($result);
	    if($count !== 1) {
	    	  echo '<div class="alert alert-danger"> Wrong username or password</div>';
	    }
	    else {
	    	$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
	    	//save users details in session variables
	    	$_SESSION['user_id'] = $row['user_id'];
	    	$_SESSION['username'] = $row['username'];
	    	$_SESSION['email'] = $row['email'];
	    }


	    if (empty($_POST['rememberme'])) {
	    	echo 'success';
	    }
	    else {
	    	//Create two variables
	    	$authentificator1 = bin2hex(openssl_random_pseudo_bytes(10));	
	    	$authenficator2 = openssl_random_pseudo_bytes(20);	

	    	//join them in string
	    	function f1($a,$b){
	    		$c = $a.'.'.bin2hex($b);	
	    		return $c;
	    	}
	    	//hashing of variable
	    	function f2($a) {
	    		return hash('sha256',$a);
	    	}

	    	$f2authentificator2 = f2($authenficator2);

	    	$user_id = $_SESSION['user_id'];
	    	$expiration = date('Y-m-d H:i:s',time()+1296000);



	    	$cookieValue = f1($authentificator1,$authenficator2);

	    	//set cookie 
	    	setcookie(
	    		'rememberme',
	    		$cookieValue,
	    		time() + 1296000);
	  		

	  		//run the query to store them in remember me table
	  		 $sql = "INSERT INTO rememberme
        (`authentificator1`, `f2authentificator2`, `user_id`, `expires`)
        VALUES
        ('$authentificator1', '$f2authentificator2', '$user_id', '$expiration')";

	  		$result = mysqli_query($link,$sql);

	  		//check if query succ
	  		if(!$result) {
	  			echo '<div class="alert alert-danger"> There was an error storing data to remember you next time.</div>';
	  			echo mysqli_error($link);
	  		}
	  		else {
	  			echo "success";
	  		}	
		}	
	}
?>
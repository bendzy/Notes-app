<?php
include("connection.php");
//if the user is not logged in & cookie rememberme exists

if(!isset($_SESSION['user_id']) && !empty($_COOKIE['rememberme'])) {
	
	//extract cookie values
	list($authentificator1,$authentificator2) = explode('.', $_COOKIE['rememberme']);

	//turn it back to binary
	$authentificator2 = hex2bin($authentificator2);
	$f2authentificator2 = hash('sha256',$authentificator2);


	$sql = "SELECT * FROM rememberme WHERE authentificator1 = '$authentificator1'";
	$result = mysqli_query($link,$sql);
	//query not succesffull
	if(!$result) {
		echo '<div class="alert alert-danger"> There was an error running the query.</div>';
		exit;
	}

	
	    $count = mysqli_num_rows($result);
	    if($count !== 1) {
	    	  echo '<div class="alert alert-danger">Remember me process failed</div>';
	    	  exit;
	    }

	    $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
	    //chech auth2 if they match
	    if(!hash_equals($row['f2authentificator2'], $f2authentificator2) ) {
	    		echo '<div class="alert alert-danger">Hash equals returned false failed</div>';
	    }else {
	    	//create new authentificators

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
	    	// saver user id 
	    	$_SESSION['user_id'] = $row['user_id'];
	    	header('location:mainpageloggedin.php');
	    }

}else {
	echo '<div class="alert alert-danger" style="margin-top:50px"> User_id:'.$_SESSION['user_id'].'</div>'; 
	echo '<div class="alert alert-danger style="margin-top:50px"> cookie Value:'.$_COOKIE['rememberme'].'</div>'; 
}

?>
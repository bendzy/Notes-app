<?php
//check if the user is set
if(isset($_SESSION['user_id'])  && $_GET['logout'] == 1 ) {
	//destroy session
	session_destroy();
	//destroy cookie
	setcookie('rememberme',"", time()-3600);
}

?>
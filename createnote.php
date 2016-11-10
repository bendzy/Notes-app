<?php
session_start();
include('connection.php');
//get user_id
$user_id = $_SESSION['user_id'];

//get the current time
$time = time();

//run a query

$sql = "INSERT INTO notes (`user_id`, `note`, `time`) VALUES ($user_id, '', '$time')";
$result = mysqli_query($link,$sql);
echo $result;

if(!$result) {
	$error = mysqli_error($link);
	echo $error;
}else {
	//return the auto increment generated id in last query -> id of notes table
	echo mysqli_insert_id($link);
}

?>
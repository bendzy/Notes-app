<?php
session_start();
include('connection.php');

//get user id
$user_id = $_SESSION["user_id"];
//run a query to delete empty notes
//if you create new note and go back without writing anything in note we have to delete it

$sql = "DELETE FROM notes WHERE note=''";
$result = mysqli_query($link, $sql);

//check if query is succesfful
if(!$result) {
	echo '<div class="alert alert-warning">Error occured!</div>';
	exit;
}

//run a query to look for notes corresponding to useR_id
$sql = "SELECT * FROM notes WHERE user_id = '$user_id' ORDER BY time DESC";

//shows notes or alert message
if( $result = mysqli_query($link,$sql)) {
	//check how many rows
	if(mysqli_num_rows($result) > 0 ){
		while($row = mysqli_fetch_array($result,MYSQLI_ASSOC) ){
			$note_id = $row['id'];
			$note = $row['note'];
			$time = $row['time'];
			$time = date('F d, Y h:i:s A', $time);
			
			//hide note id in noteheader
			echo "<div class='noteheader' id='$note_id'>

					<div class='text'>$note</div>
					<div class='timetext'> $time</div>
 				</div>";
		}

	}else{
		echo '<div class="alert alert-warning">You have nonot created any notes yet </div>';
	exit;
	}
}else {
	echo '<div class="alert alert-warning">Error occured!</div>';
	exit;
}

?>
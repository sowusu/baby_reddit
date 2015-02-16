<?php
	session_start();
	$username = $_SESSION['username'];
	//CHECK CSRF TOKEN
	if(isset($_SESSION['token']) && isset($_POST['token']) && ($_SESSION['token'] !== $_POST['token'])){
        die("Request forgery detected");
}

	$mysqli = new mysqli('localhost', 'webuser', 'webpass', 'newspage');

	if($mysqli->connect_errno){
		print("CONNECTION ERROR YOU FAILURE!");
		exit;
	} 

	$storyid=$_POST['storyid'];
	$commentid=$_POST['commentid'];

	$stmt2 = $mysqli->query("DELETE from comments WHERE comment_id=".$commentid);
	if(!$stmt2){
		printf("Query Prep Failed: %s\n", $mysqli->error);
		exit;
	}


	$_SESSION['storyid']=$storyid;

	header('Location: ./storyPage.php');
	die();

?>

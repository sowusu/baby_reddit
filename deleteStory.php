<?php
	session_start();
	$username = $_SESSION['username'];
	//CHECK CSRF TOKEN
	if($_SESSION['token'] !== $_POST['token']){
		die("Request forgery detected");
	}

	$mysqli = new mysqli('localhost', 'webuser', 'webpass', 'newspage');

	if($mysqli->connect_errno){
		print("CONNECTION ERROR YOU FAILURE!");
		exit;
	} 

	$storyid=$_POST['storyid'];

	$stmt2 = $mysqli->query("DELETE from comments WHERE story_id=".$storyid);
	if(!$stmt2){
		printf("Query Prep Failed: %s\n", $mysqli->error);
		exit;
	}


	$stmt = $mysqli->query("DELETE from stories WHERE story_id=".$storyid);
	if(!$stmt){
		printf("Query Prep Failed: %s\n", $mysqli->error);
		exit;
	}

	header('Location: ./mainPage.php');
	die();

?>

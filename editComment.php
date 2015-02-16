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
	$commentid=$_POST['commentid'];
	$comment=$_POST['comment'];

	$stmt = $mysqli->query("update comments set comment_content='".$comment."' where comment_id=".$commentid);
	if(!$stmt){
		printf("Query Prep Failed: %s\n", $mysqli->error);
		exit;
	}

	$_SESSION['storyid'] = $storyid;

	header('Location: ./storyPage.php');
	die();

?>

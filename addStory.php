<?php
	session_start();
	$username = $_SESSION['username'];
	//CHECK CSRF TOKEN
	if($_SESSION['token'] !== $_POST['token']){
		die("Request forgery detected");
	}

	$mysqli = new mysqli('localhost', 'webuser', 'webuserpass', 'newspage');

	if($mysqli->connect_errno){
		print("CONNECTION ERROR YOU FAILURE!");
		exit;
	} 

	if(!empty($_POST['storyname'])){
		$storyname=$_POST['storyname'];
	}
	else{
		header('Location: ./mainPage.php');
		die();
	}
	if(!empty($_POST['storylink'])){
		$storylink=$_POST['storylink'];
	}
	else{
		$storylink=null;
	}
	if(!empty($_POST['storycontent'])){
		$storycontent=$_POST['storycontent'];
	}
	else{
		$storycontent=null;
	}

	//temp until we get users table
	$creator_id = $_SESSION['userid'];

	$stmt = $mysqli->prepare("insert into stories (story_title, story_link, story_content, creator_id, creator_name) values (?, ?, ?, ?, ?)");
	if(!$stmt){
		printf("Query Prep Failed: %s\n", $mysqli->error);
		exit;
	}

	$stmt->bind_param('sssis', $storyname, $storylink, $storycontent, $creator_id, $username);
	 
	$stmt->execute();
	 
	$stmt->close();

	header('Location: ./mainPage.php');
	die();

?>

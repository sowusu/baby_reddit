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

	if(isset($_POST['comment'])){
		$comment=$_POST['comment'];
	}
	$id=$_POST['storyid'];

	//temp until we get users table
	$creator_id = $_SESSION['userid'];

	$stmt = $mysqli->prepare("insert into comments (comment_content, story_id, creator_id, creator_name) values (?, ?, ?, ?)");
	if(!$stmt){
		printf("Query Prep Failed: %s\n", $mysqli->error);
		exit;
	}

	$stmt->bind_param('siis', $comment, $id, $creator_id, $username);
	 
	$stmt->execute();
	 
	$stmt->close();

	$_SESSION['storyid'] = $id;

	header('Location: ./storyPage.php');
	die();

?>

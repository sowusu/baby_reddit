<?php
session_start();
//CHECK CSRF TOKEN
if(isset($_SESSION['token']) && isset($_POST['token']) && ($_SESSION['token'] !== $_POST['token'])){
        die("Request forgery detected");
}

$username = $_SESSION['username'];

$mysqli = new mysqli('localhost', 'webuser', 'webpass', 'newspage');

if($mysqli->connect_errno){
	print("CONNECTION ERROR YOU FAILURE!");
	exit;
} 

if(isset($_POST['commentid'])){

	$commentid=$_POST['commentid'];
	$storyid=$_POST['storyid'];

	$stmt2 = $mysqli->query("update comments set votes=votes+1 WHERE comment_id=".$commentid);
	if(!$stmt2){
		printf("Query Prep Failed: %s\n", $mysqli->error);
		exit;
	}

	$_SESSION['storyid'] = $storyid;

	header('Location: ./storyPage.php');
	die();

}
else{

	$storyid=$_POST['storyid'];

	$stmt2 = $mysqli->query("update stories set votes=votes+1 WHERE story_id=".$storyid);
	if(!$stmt2){
		printf("Query Prep Failed: %s\n", $mysqli->error);
		exit;
	}

	header('Location: ./mainPage.php');
	die();

}

?>

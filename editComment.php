<?php
session_start();
$username = $_SESSION['username'];

$mysqli = new mysqli('localhost', 'webuser', 'webpass', 'newspage');

if($mysqli->connect_errno){
	print("CONNECTION ERROR YOU FAILURE!");
	exit;
} 

$storyid=$_GET['storyid'];
$commentid=$_GET['commentid'];
$comment=$_GET['comment'];

$stmt = $mysqli->query("update comments set comment_content='".$comment."' where comment_id=".$commentid);
if(!$stmt){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
}

$_SESSION['storyid'] = $storyid;

header('Location: ./storyPage.php');
die();

?>

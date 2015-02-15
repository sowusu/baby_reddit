<?php
session_start();
$username = $_SESSION['username'];

$mysqli = new mysqli('localhost', 'webuser', 'webpass', 'newspage');

if($mysqli->connect_errno){
	print("CONNECTION ERROR YOU FAILURE!");
	exit;
} 

if(isset($_GET['comment'])){
	$comment=$_GET['comment'];
}
$id=$_GET['storyid'];

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

<?php
session_start();
$username = $_SESSION['username'];

$mysqli = new mysqli('localhost', 'webuser', 'webuserpass', 'newspage');

if($mysqli->connect_errno){
	print("CONNECTION ERROR YOU FAILURE!");
	exit;
} 

if(!empty($_GET['storyname'])){
	$storyname=$_GET['storyname'];
}
else{
	header('Location: ./mainPage.php');
	die();
}
if(!empty($_GET['storylink'])){
	$storylink=$_GET['storylink'];
}
else{
	$storylink=null;
}
if(!empty($_GET['storycontent'])){
	$storycontent=$_GET['storycontent'];
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

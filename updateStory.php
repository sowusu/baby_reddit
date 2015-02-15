<?php
session_start();
$username = $_SESSION['username'];

$mysqli = new mysqli('localhost', 'webuser', 'webpass', 'newspage');

if($mysqli->connect_errno){
	print("CONNECTION ERROR YOU FAILURE!");
	exit;
} 

$storyid = $_GET['storyid'];
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

$stmt = $mysqli->query("update stories set story_title='".$storyname."', story_link='".$storylink."', story_content='".$storycontent."' where story_id=".$storyid);
if(!$stmt){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
}

header('Location: ./mainPage.php');
die();

?>

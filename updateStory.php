<?php
session_start();
$username = $_SESSION['username'];

//begin mysql session
$mysqli = new mysqli('localhost', 'webuser', 'webpass', 'newspage');

if($mysqli->connect_errno){
	print("CONNECTION ERROR YOU FAILURE!");
	exit;
} 

//get the information about story
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

//update the story
$stmt = $mysqli->prepare("update stories set story_title=?, story_link=?, story_content=? where story_id=".$storyid);
if(!$stmt){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
}

$stmt->bind_param('sss', $storyname, $storylink, $storycontent);

$stmt->execute();

$stmt->close();

header('Location: ./mainPage.php');
die();

?>

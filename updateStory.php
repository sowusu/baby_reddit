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

$storyid = $_POST['storyid'];
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

$stmt = $mysqli->query("update stories set story_title='".$storyname."', story_link='".$storylink."', story_content='".$storycontent."' where story_id=".$storyid);
if(!$stmt){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
}

header('Location: ./mainPage.php');
die();

?>

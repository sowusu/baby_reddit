<!DOCTYPE html>
<html>
<head>
        <title> Stories!!! :) </title>
        <meta http-equiv="Content-Type" content="text/html;charset=utf-8" >
</head>
<body>
<?php
session_start();
if(isset($_SESSION['username'])){
	$username = $_SESSION['username'];
	echo "<form action=\"logout.php\">";
        echo         "<input type=\"submit\" name=\"logout\" value=\"Logout\">";
        echo "</form>";
	echo "<form action=\"createStory.php\">";
	echo         "<input type=\"submit\" name=\"mkstry\" value=\"Submit A New Story!\">";
	echo "</form>";
}
//<!-- Sign In/Sign Up Button -->
else{
	echo "<form action=\"signin.php\">";
	echo         "<input type=\"submit\" name=\"signin\" value=\"Sign In / Sign Up\">";
	echo "</form>";
}

$mysqli = new mysqli('localhost', 'webuser', 'webpass', 'newspage');

if($mysqli->connect_errno){
	print("CONNECTION ERROR YOU FAILURE!");
	exit;
} 

if(isset($_SESSION['userid'])){
	$crntcreator=$_SESSION['userid'];
}
else{
	$crntcreator=0;
}
$ids;
$stories;
$creators;
$names;
$votes;

$stmt = $mysqli->prepare("select story_id, story_title, creator_id, creator_name, votes from stories order by votes desc");
if(!$stmt){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
}
 
$stmt->execute();
 
$stmt->bind_result($ids, $stories, $creators, $names, $votes);
 
echo "<ul>\n";
while($stmt->fetch()){
	echo "<form action=\"storyPage.php\" method=\"GET\">";
	printf("\t<li><label>[VOTES: %s]</label><input type=\"hidden\" name=\"storyid\" value=\"%s\"><input type = \"submit\" value=\"%s\">",
	htmlspecialchars($votes),
	htmlspecialchars($ids), 
	htmlspecialchars($stories));
	echo "<input type=\"submit\" value=\"Upvote\" formaction=\"upvote.php\">";
	echo "<input type=\"submit\" value=\"Downvote\" formaction=\"downvote.php\">";
	echo "--by ".htmlspecialchars($names);
	if(htmlspecialchars($creators)==$crntcreator){
		printf("\t<input type=\"hidden\" name=\"storyid\" value=\"%s\"><input type = \"submit\" value=\"Delete\" formaction=\"deleteStory.php\">\n",
		htmlspecialchars($ids));
		printf("\t<input type=\"hidden\" name=\"storyid\" value=\"%s\"><input type = \"submit\" value=\"Edit\" formaction=\"editStory.php\">\n",
		htmlspecialchars($ids));
	}
	echo "</form>";
	echo "</li>";
}
echo "</ul>\n";
 
$stmt->close();

//
//
//Sign In button / create account button
//
//Submit new text story;
//
//Submit link to story
//
//for(story #x to x+10){
//	Print href to storypage
//}
//
//
?>
</body>
</html>

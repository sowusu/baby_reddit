<!DOCTYPE html>
<html>
<head>
        <title> Read the Story! </title>
        <meta http-equiv="Content-Type" content="text/html;charset=utf-8" >
</head>
<body>
<?php
session_start();
//CHECK CSRF TOKEN
if($_SESSION['token'] !== $_POST['token']){
  die("Request forgery detected");
}
if(isset($_SESSION['username'])){
	$username = $_SESSION['username'];
	$userid=$_SESSION['userid'];
	echo "<form action=\"logout.php\">";
	echo         "<input type=\"submit\" name=\"logout\" value=\"Logout\">";
	echo "</form>";
}
//<!-- Sign In/Sign Up Button -->
else{
	$userid = 0;
	echo "<form action=\"signin.php\">";
	echo         "<input type=\"submit\" name=\"signin\" value=\"Sign In / Sign Up\">";
	echo "</form>";
}


echo "<form action=\"mainPage.php\">";
echo         "<input type=\"submit\" name=\"home\" value=\"Back to Stories\">";
echo "</form>";


$mysqli = new mysqli('localhost', 'webuser', 'webpass', 'newspage');

if($mysqli->connect_errno){
	print("CONNECTION ERROR YOU FAILURE!");
	exit;
} 

if(isset($_POST['storyid'])){
	$crntstry = $_POST['storyid'];
}
else if(isset($_SESSION['storyid'])){
	$crntstry = $_SESSION['storyid'];
	unset($_SESSION['storyid']);
}
else {
	$crntstry = 0;
	echo "NO STORY ERROR.....";
}

$link;
$content;
$id;

$stmt1 = $mysqli->prepare("select story_link, story_content, story_id from stories order by story_id");


if(!$stmt1){
	printf("Query Prep1 Failed: %s\n", $mysqli->error);
	exit;
}
 
$stmt1->execute();
 
$stmt1->bind_result($link, $content, $id);

while($stmt1->fetch()){
	if(htmlspecialchars($id)==$crntstry){
		if($link!=null){
			printf("\t<a href=%s>Associated Content</a><br><br>", htmlspecialchars($link));
		}
		if($content!=null){
			echo htmlspecialchars($content);
		}
		break;
	}
}
 
$stmt1->close();

if(isset($_SESSION['username'])){
	echo "<form action=\"createComment.php\" method = \"POST\">";
	echo "<input type=\"text\" name=\"comment\">";
	printf("\t<input type=\"hidden\" value=\"%s\" name=\"storyid\">", $crntstry);
	echo "<input type=\"hidden\" name=\"token\" value=\"<?php echo $_SESSION\[\'token\'\];?>\" />"
	echo "<input type=\"submit\" name=\"mkcmnt\" value=\"Share Your Opinion\">";
	echo "</form>";
}

$editid = 0;
if(isset($_POST['commentid'])){
	$editid = $_POST['commentid'];
}

$creator_id = $userid;
$cmntids;
$comments;
$stryid;
$creators;
$names;
$votes;

$stmt2 = $mysqli->prepare("select comment_id, comment_content, story_id, creator_id, creator_name, votes from comments order by votes desc");

if(!$stmt2){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
}
 
$stmt2->execute();
 
$stmt2->bind_result($cmntids,$comments,$stryid,$creators,$names,$votes);
 
echo "<ul>\n";
while($stmt2->fetch()){
	if(htmlspecialchars($stryid)==$crntstry){
		if($editid!=$cmntids){
			printf("\t<li>[VOTES: %s] %s",
			htmlspecialchars($votes),
			htmlspecialchars($comments));
			echo " --by ".htmlspecialchars($names)."</li>";
			echo "<form action=\"upvote.php\" method\"POST\">";
			echo "<input type=\"hidden\" name=\"commentid\" value=".htmlspecialchars($cmntids).">";
			echo "<input type=\"hidden\" name=\"storyid\" value=".htmlspecialchars($stryid).">";
			echo "<input type=\"submit\" value=\"Upvote\" formaction=\"upvote.php\">";
        	echo "<input type=\"submit\" value=\"Downvote\" formaction=\"downvote.php\">";
        	echo "<input type=\"hidden\" name=\"token\" value=\"<?php echo $_SESSION\[\'token\'\];?>\" />"
			if(htmlspecialchars($creators)==$creator_id){
				echo "<input type=\"submit\" name=\"delete\" value=\"Delete\" formaction=\"deleteComment.php\">";
				echo "<input type=\"submit\" name=\"edit\" value=\"Edit\" formaction=\"storyPage.php\">";
			}
			echo "</form>";
		}
		else{
			echo "<form action=\"editComment.php\" method = \"POST\">";
			echo "<input type=\"hidden\" name=\"commentid\" value=".htmlspecialchars($cmntids).">";
			echo "<input type=\"hidden\" name=\"storyid\" value=".htmlspecialchars($stryid).">";
			echo "<input type=\"text\" name=\"comment\" value=\"".htmlspecialchars($comments)."\">";
			echo "<input type=\"hidden\" name=\"token\" value=\"<?php echo $_SESSION\[\'token\'\];?>\" />"
			echo "<input type=\"submit\" name=\"edit\" value=\"Submit Edit\">";
			echo "</form>";
		}
	}
}
echo "</ul>\n";
 
$stmt2->close();

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

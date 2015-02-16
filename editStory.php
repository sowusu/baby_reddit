<!DOCTYPE html>
<html>
	<head>
        <title> Edit Your Story! </title>
        <meta http-equiv="Content-Type" content="text/html;charset=utf-8" >
	</head>
	<body>
		<?php
		session_start();
		$username = $_SESSION['username'];
		//CHECK CSRF TOKEN
if(isset($_SESSION['token']) && isset($_POST['token']) && ($_SESSION['token'] !== $_POST['token'])){
        die("Request forgery detected");
}		
$mysqli = new mysqli('localhost', 'webuser', 'webpass', 'newspage');

		if($mysqli->connect_errno){
		        print("CONNECTION ERROR YOU FAILURE!");
		        exit;
		}

		$storyid = $_POST['storyid'];

		$name;
		$link;
		$content;

		$stmt = $mysqli->prepare("select story_title, story_link, story_content from stories where story_id=".$storyid);

		if(!$stmt){
		        printf("Query Prep Failed: %s\n", $mysqli->error);
		        exit;
		}

		$stmt->execute();

		$stmt->bind_result($name, $link, $content);

		$stmt->fetch();

		echo "<form action=\"logout.php\">";
		echo         "<input type=\"submit\" name=\"logout\" value=\"Logout\">";
		echo "</form>";
		echo "<form action=\"mainPage.php\">";
		echo         "<input type=\"submit\" name=\"home\" value=\"Back to Stories\">";
		echo "</form>";
		echo "<form action=\"updateStory.php\" method=\"POST\">";
		echo "<input type=\"hidden\" name=\"storyid\" value=".$storyid.">";
		echo "Story Name: ";
		echo "<input type=\"text\" name=\"storyname\"value=\"".htmlspecialchars($name)."\"><br>";
		echo "Story Link (Optional): ";
		echo "<input type=\"text\" name=\"storylink\" value=\"".htmlspecialchars($link)."\"><br>";
		echo "Story Text (Optional): ";
		echo "<input type=\"text\" name=\"storycontent\" value=\"".htmlspecialchars($content)."\"><br>";
if(isset($_SESSION['token'])){
                echo "<input type=\"hidden\" name=\"token\" value=\"".$_SESSION['token']."\" />";
        }
		
		echo "<input type=\"submit\" value=\"Update\">";
		echo "</form>";
		$stmt->close();
		?>
	</body>
</html>

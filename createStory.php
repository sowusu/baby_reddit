<!DOCTYPE html>
<html>
	<head>
        <title> Create Your Own Story! </title>
        <meta http-equiv="Content-Type" content="text/html;charset=utf-8" >
	</head>
	<body>
		<?php
			session_start();
			//CHECK CSRF TOKEN
			if($_SESSION['token'] !== $_POST['token']){
				die("Request forgery detected");
			}
			$username = $_SESSION['username'];
			echo "<form action=\"logout.php\" >";
			echo         "<input type=\"submit\" name=\"logout\" value=\"Logout\">";
			echo "</form>";
			echo "<form action=\"mainPage.php\">";
			echo         "<input type=\"submit\" name=\"home\" value=\"Back to Stories\">";
			echo "</form>";
			echo "<form action=\"addStory.php\" method=\"POST\">";
			echo "Give your story a name: ";
			echo "<input type=\"text\" name=\"storyname\"><br>";
			echo "Link associated content (Optional): ";
			echo "<input type=\"text\" name=\"storylink\"><br>";
			echo "Add some lively text to your story (Optional): ";
			echo "<input type=\"text\" name=\"storycontent\"><br>";
			echo "<input type=\"hidden\" name=\"token\" value=\"<?php echo $_SESSION\[\'token\'\];?>\" />"
			echo "<input type=\"submit\" value=\"CREATE!\">";
			echo "</form>";
		?>
	</body>
</html>

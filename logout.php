<?php
session_start();
unset($_SESSION['userid']);//unset the user's id
unset($_SESSION['username']);//unset the users password

//go to main story page
header('Location: ./mainPage.php');
die();

?>

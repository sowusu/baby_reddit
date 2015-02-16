<?php
session_start();
unset($_SESSION['userid']);
unset($_SESSION['username']);
unset($_SESSION['token']);

header('Location: ./mainPage.php');
die();

?>

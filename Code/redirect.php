<?php
session_start();
$_SESSION['username'] = $_GET["userid"];
$_SESSION['pass'] = $_GET["pass"];
?>
<html>
<head>
<meta http-equiv="refresh" content="0;URL=edituser.php">
</head>
</html>
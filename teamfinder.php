<?php

require_once 'core/init.php';
// instantiates the core class

if(Session::exists('home')) {
	echo '<p>' . Session::flash('home') . '</p>';
}

$user = new User(); // current user

if($user->isLoggedIn()) {
?>

<html>

<head>
	<title>Team Finder</title>
	<link rel="stylesheet" type="text/css" href="css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<link rel="shortcut icon" href="css/Martin-Berube-Sport-Basketball.ico">
</head>

<body background="css/basketball.jpg">

<div class="col-md-4">
</div>
	<div class="col-md-4 registerform">
		<h1><center>Team Finder</h1></center>
		<div class="row"><center>
		<a href="findteam.php"><h2>Find Team</h2></a>
	</div>
	</div>
	</center>
</body>
</html>

<?php
} else {
	header("Location: login.php");
}
?>
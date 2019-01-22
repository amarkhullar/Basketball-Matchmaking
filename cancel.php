<?php

require_once 'core/init.php';

$user = new User();

if(!$user->isLoggedIn()) {
	header("Location: login.php");
}

// if(!Input::Exists()) {
//   header("Location: index.php");
// }

$teamid = $user->data()->teamid;

$getmatchid = Input::get('match');

?>

<html>

<head>
	<title>Cancel Match</title>
	<link rel="stylesheet" type="text/css" href="css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<link rel="shortcut icon" href="css/Martin-Berube-Sport-Basketball.ico">
</head>

<body background="css/basketball.jpg">

  <div class="row">
    <div class="col-md-12">
      <h1><center>Cancel Match</h1></center>
    </div>
  </div>
    
  <div class="col-md-4">
  </div>
  <div class="col-md-4 loginform">
    
    <center><h3>

		<div class="row">
			<a href="cancelled.php?match=<?php echo ($getmatchid); ?>">Confirm cancel?</a>
		</div><br>
	
	<div class="row">
		<a href="index.php">Home</a>
	</div>

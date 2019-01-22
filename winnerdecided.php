<?php

require_once 'core/init.php';

$user = new User();

if(!$user->isLoggedIn()) {
	header("Location: login.php");
}

if(!Input::Exists()) {
  header("Location: index.php");
}

$teamid = $user->data()->teamid;

$winnermatch = Input::get('winnermatch');

$arr = explode("/", $winnermatch, 2);
$winner = $arr[0];
$match = $arr[1];

$sql = "SELECT name FROM teams WHERE id = {$winner}";
$winnerteam = DB::getInstance()->query($sql);
$winnerteamname = $winnerteam->first()->name;

$sql = "UPDATE matches SET winner = {$winner} WHERE id = {$match}";
DB::getInstance()->query($sql);

?>

<html>

<head>
	<title>Who won?</title>
	<link rel="stylesheet" type="text/css" href="css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<link rel="shortcut icon" href="css/Martin-Berube-Sport-Basketball.ico">
</head>

<body background="css/basketball.jpg">

  <div class="row">
    <div class="col-md-12">
      <h1><center>Winner Decided</h1></center>
    </div>
  </div>
    
  <div class="col-md-4">
  </div>
  <div class="col-md-4 loginform">
    
    <center><h3>

    	<div class="row">
    		<?php
        echo $winnerteamname . " has been declared the winner of the match";
        ?>
    	</div>
    	
    	<br>


	
	<div class="row">
		<a href="index.php">Home</a>
	</div>

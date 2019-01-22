<?php

require_once 'core/init.php';

$user = new User();

if(!$user->isLoggedIn()) {
	header("Location: login.php");
}

$teamid = $user->data()->teamid;

$getmatchid = Input::get('match');

$sql = "SELECT * FROM matches WHERE id = {$getmatchid}";

$matchdata = DB::getInstance()->query($sql);

$team1id = $matchdata->first()->team1;
$team2id = $matchdata->first()->team2;

$sql = "SELECT name FROM teams WHERE id = {$team1id}";
$team1 = DB::getInstance()->query($sql);
$team1name = $team1->first()->name;

$sql = "SELECT name FROM teams WHERE id = {$team2id}";
$team2 = DB::getInstance()->query($sql);
$team2name = $team2->first()->name;

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
      <h1><center>Who won?</h1></center>
    </div>
  </div>
    
  <div class="col-md-4">
  </div>
  <div class="col-md-4 loginform">
    
    <center><h3>

    	<div class="row">
    		Who won?
    	</div>
    	
    	<br>

    	<div class="row">
    		<a href="winnerdecided.php?winnermatch=<?php echo $team1id . '/' . $getmatchid ?>"><?php echo $team1name; ?></a> OR <a href="winnerdecided.php?winnermatch=<?php echo $team2id . '/' . $getmatchid ?>"><?php echo $team2name; ?></a>
    	</div>

    	<br>


	
	<div class="row">
		<a href="index.php">Home</a>
	</div>

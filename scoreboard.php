<?php

require_once 'core/init.php';
// instantiates the core class
require_once 'phplot.php';

if(Session::exists('home')) {
	echo '<p>' . Session::flash('home') . '</p>';
}

$user = new User(); // current user

if(!$user->isLoggedIn()) {
	header("Location: login.php");
}

$x = 0;

$sql = "SELECT * FROM teams";
$teams = DB::getInstance()->query($sql);
$teamcount = $teams->count();
foreach($teams->results() as $team) {
	$teamname = $team->name;
	$teamid = $team->id;
	$score = TeamInfo::FindScore($teamid);
	$teamArray[$x] = ($teamname);
	$scoreArray[$x] = ($score);
	
	$x = $x + 1;
}
			
list($scoreArray, $nameArray) = Sorts::BubbleSort($scoreArray, $teamArray);


?>

<html>

<head>
	<title>Scoreboard</title>
	<link rel="stylesheet" type="text/css" href="css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<link rel="shortcut icon" href="css/Martin-Berube-Sport-Basketball.ico">
</head>

<body background="css/basketball.jpg">

<div class="col-md-4">
</div>
	<div class="col-md-4 registerform">
		<h1><center>Scoreboard</h1></center>
		<h3><center>
		<div class="row">

		</div><br>
		
		<div class="row">
			<div class="table-responsive">
  				<table class="table" border="1" cellspacing="4" cellpadding="4">
  					
  					<tr>
  					<th>Team</th>
  					<th>Score</th>
  					</tr>
  					<tr>
  					<h3>
  					<?php
  					for ($x = 0; $x <= $teamcount - 1; $x++) {
    					echo '<td>' . $nameArray[$x] . '</td>';
    					echo '<td>' . $scoreArray[$x] . '</td>';
    					echo '</tr><tr>';
    				} 
  					?>
 					
  				</table>
			</div>
		</div>

<!-- 		<div class="row">
			<iframe src="scoregraph.php" height="65%" width="100%">
			</iframe>
		</div> -->

		<br>

		<div class="row">
			<a href="index.php">Home</a>
		</div>

	</div>
	</center>

</body>
</html>


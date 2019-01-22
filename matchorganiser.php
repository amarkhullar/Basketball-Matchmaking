<?php

require_once 'core/init.php';
// instantiates the core class


if(Session::exists('home')) {
	echo '<p>' . Session::flash('home') . '</p>';
}

$user = new User(); // current user

if(!$user->isLoggedIn()) {
	header("Location: index.php");
}

$teamid = $user->data()->teamid;

$now = new DateTime('now');
$day = $now->format('d');
$month = $now->format('m');
$year = $now->format('y');

$weekno = date('W');

// if week < 10 then week = 0 . week

$weekyear = $weekno . $year;

$sql = "SELECT * FROM matches WHERE weekyear = {$weekyear} AND (team1 = {$teamid} OR team2 = {$teamid})";

$teammatchthisweek = DB::getInstance()->query($sql);

?>

<html>

<head>
	<title>Match Organiser</title>
	<link rel="stylesheet" type="text/css" href="css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<link rel="shortcut icon" href="css/Martin-Berube-Sport-Basketball.ico">
</head>

<body background="css/basketball.jpg">

	<div class="row">
		<div class="col-md-12">
			<h1><center>Match Organiser</h1></center>
		</div>
	</div>
		
	<div class="col-md-4">
	</div>
	<div class="col-md-4 loginform">
		
		<center>

			<div class="row"><h3>
			<?php

			if($teamid == 0) {
				echo "You are not in a team, you cannot book a match";
			}else {

				if($teammatchthisweek->count() > 0) {

					echo "You already have a match booked this week:" . '<br><br>';
					$team1id = $teammatchthisweek->first()->team1;
					$team2id = $teammatchthisweek->first()->team2;
					$matchdate = $teammatchthisweek->first()->weekyear;
					$matchlocationid = $teammatchthisweek->first()->locationid;

					$sql = "SELECT name FROM teams WHERE id = {$team1id} OR id = {$team2id}";
					$teamnames = DB::getInstance()->query($sql);
					if($teamnames->count() > 1) {
						$team1name = $teamnames->results()[0]->name;
						$team2name = $teamnames->results()[1]->name;
					}
					$locationsql = "SELECT name, address FROM locations WHERE id = {$matchlocationid}";
					$locations = DB::getInstance()->query($locationsql);
					$locationname = $locations->first()->name;
					$locationaddress = $locations->first()->address;
					echo $team1name . ' VS ' . $team2name . '<br>';
					echo $locationname . '<br>';
					echo $locationaddress . '<br>';

					echo "Sunday @1 PM";

				} else {
			?>
			</h3>
			<a href="bookmatch.php"><h1>Book a Match</h1></a>
			<?php
			}
		}
			?>
			</div>

			<div class="row">
			<a href="index.php"><h1>Home</a></h1>
			</div>

</body>

</html>
